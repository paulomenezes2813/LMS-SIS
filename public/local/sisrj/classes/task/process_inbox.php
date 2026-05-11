<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;
use local_sisrj\dispatcher;

/**
 * Consome a fila local_sisrj_webhook_log e despacha cada evento para o handler
 * apropriado (user.*, course.*, enrolment.*, certificate.*).
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class process_inbox extends scheduled_task {

    public function get_name(): string {
        return get_string('task_process_inbox', 'local_sisrj');
    }

    public function execute(): void {
        global $DB;

        $pending = $DB->get_records_select(
            'local_sisrj_webhook_log',
            "status IN ('pending', 'failed') AND attempts < ?",
            [5],
            'receivedat ASC',
            '*',
            0,
            100
        );

        $dispatcher = new dispatcher();

        foreach ($pending as $record) {
            $DB->set_field('local_sisrj_webhook_log', 'status', 'processing', ['id' => $record->id]);
            $DB->set_field('local_sisrj_webhook_log', 'attempts', $record->attempts + 1, ['id' => $record->id]);

            try {
                $payload = json_decode($record->payload, true);
                $dispatcher->dispatch($record->event, $payload);

                $DB->update_record('local_sisrj_webhook_log', (object) [
                    'id'          => $record->id,
                    'status'      => 'done',
                    'processedat' => time(),
                ]);
            } catch (\Throwable $e) {
                mtrace("[local_sisrj] webhook #{$record->id} falhou: " . $e->getMessage());
                $DB->update_record('local_sisrj_webhook_log', (object) [
                    'id'        => $record->id,
                    'status'    => 'failed',
                    'lasterror' => $e->getMessage(),
                ]);
            }
        }
    }
}
