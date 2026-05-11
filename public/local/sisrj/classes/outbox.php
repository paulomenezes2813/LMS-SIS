<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj;

defined('MOODLE_INTERNAL') || die();

/**
 * Helper para enfileirar eventos do Moodle para envio ao SIS.
 *
 * Usado pelos observers (`observer/*.php`). O delivery efetivo acontece no
 * scheduled task `process_outbox`.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class outbox {

    public static function enqueue(string $event, array $payload): int {
        global $DB;

        return (int) $DB->insert_record('local_sisrj_outbox', (object) [
            'event'         => $event,
            'payload'       => json_encode($payload, JSON_UNESCAPED_UNICODE),
            'status'        => 'pending',
            'attempts'      => 0,
            'nextattemptat' => time(),
            'createdat'     => time(),
        ]);
    }
}
