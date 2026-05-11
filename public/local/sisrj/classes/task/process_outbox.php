<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;
use curl;

/**
 * Consome local_sisrj_outbox e entrega cada evento ao SIS via HTTP POST.
 * Implementa backoff exponencial via campo nextattemptat.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class process_outbox extends scheduled_task {

    public function get_name(): string {
        return get_string('task_process_outbox', 'local_sisrj');
    }

    public function execute(): void {
        global $CFG, $DB;

        $baseurl = (string) get_config('local_sisrj', 'sis_base_url');
        $token   = (string) get_config('local_sisrj', 'sis_outbox_token');
        $maxretries = (int) get_config('local_sisrj', 'outbox_retry_max') ?: 5;

        if ($baseurl === '' || $token === '') {
            mtrace('[local_sisrj] outbox skipped: SIS base URL ou token não configurados.');
            return;
        }

        require_once($CFG->libdir . '/filelib.php');

        $now = time();
        $pending = $DB->get_records_select(
            'local_sisrj_outbox',
            "status IN ('pending', 'retry') AND nextattemptat <= ? AND attempts < ?",
            [$now, $maxretries],
            'nextattemptat ASC',
            '*',
            0,
            50
        );

        foreach ($pending as $record) {
            $curl = new curl();
            $curl->setHeader([
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'X-Edukkare-Event: ' . $record->event,
            ]);

            $endpoint = rtrim($baseurl, '/') . '/webhooks/moodle';
            $response = $curl->post($endpoint, $record->payload);
            $httpcode = (int) $curl->get_info()['http_code'];

            $update = (object) ['id' => $record->id, 'attempts' => $record->attempts + 1];

            if ($httpcode >= 200 && $httpcode < 300) {
                $update->status = 'done';
                $update->sentat = time();
                $update->lasterror = null;
            } else {
                $update->status = 'retry';
                $update->lasterror = "HTTP {$httpcode}: " . substr((string) $response, 0, 500);
                // Backoff exponencial: 2^attempts minutos.
                $update->nextattemptat = time() + (60 * (2 ** ($record->attempts + 1)));

                if (($record->attempts + 1) >= $maxretries) {
                    $update->status = 'failed';
                }
            }

            $DB->update_record('local_sisrj_outbox', $update);
        }
    }
}
