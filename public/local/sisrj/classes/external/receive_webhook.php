<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\external;

defined('MOODLE_INTERNAL') || die();

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use local_sisrj\webhook\signature_verifier;

/**
 * Recebe um webhook do SIS, valida assinatura HMAC e enfileira para processamento.
 *
 * Eventos esperados (lista inicial):
 *   - user.created, user.updated, user.deleted
 *   - course.created, course.updated, course.deleted
 *   - enrolment.created, enrolment.updated, enrolment.deleted
 *   - certificate.issued
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class receive_webhook extends external_api {

    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'event'     => new external_value(PARAM_ALPHANUMEXT, 'Event name, e.g. user.created'),
            'payload'   => new external_value(PARAM_RAW, 'JSON-encoded event payload'),
            'signature' => new external_value(PARAM_TEXT, 'HMAC-SHA256 of payload using shared secret'),
        ]);
    }

    public static function execute(string $event, string $payload, string $signature): array {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            'event' => $event, 'payload' => $payload, 'signature' => $signature,
        ]);

        // 1. Verifica assinatura HMAC contra o segredo configurado.
        $verifier = new signature_verifier();
        if (!$verifier->verify($params['payload'], $params['signature'])) {
            return [
                'status'  => 'rejected',
                'message' => get_string('webhook_invalid_signature', 'local_sisrj'),
                'id'      => 0,
            ];
        }

        // 2. Valida que o payload é JSON parseável.
        $decoded = json_decode($params['payload'], true);
        if (!is_array($decoded)) {
            return [
                'status'  => 'rejected',
                'message' => get_string('webhook_invalid_payload', 'local_sisrj'),
                'id'      => 0,
            ];
        }

        // 3. Enfileira para o scheduled task processar.
        $id = $DB->insert_record('local_sisrj_webhook_log', (object) [
            'event'      => $params['event'],
            'payload'    => $params['payload'],
            'signature'  => $params['signature'],
            'status'     => 'pending',
            'attempts'   => 0,
            'receivedat' => time(),
        ]);

        return [
            'status'  => 'queued',
            'message' => get_string('webhook_received', 'local_sisrj'),
            'id'      => (int) $id,
        ];
    }

    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'status'  => new external_value(PARAM_ALPHA, 'queued|rejected'),
            'message' => new external_value(PARAM_TEXT, 'Human-readable result'),
            'id'      => new external_value(PARAM_INT, 'Inbox log id (0 when rejected)'),
        ]);
    }
}
