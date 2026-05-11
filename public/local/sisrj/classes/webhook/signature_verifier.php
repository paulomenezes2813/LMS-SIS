<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\webhook;

defined('MOODLE_INTERNAL') || die();

/**
 * Verifica assinaturas HMAC-SHA256 de webhooks vindos do SIS.
 *
 * Contrato: o SIS calcula `hmac = HMAC-SHA256(secret, payload)` e envia o hex
 * em hexadecimal no campo `signature`. Aqui recomputamos e comparamos em
 * tempo constante (`hash_equals`) para evitar timing attacks.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class signature_verifier {

    /**
     * @param string $payload Corpo bruto da requisição.
     * @param string $signature Assinatura recebida do SIS.
     * @return bool true se válida.
     */
    public function verify(string $payload, string $signature): bool {
        $secret = (string) get_config('local_sisrj', 'sis_inbox_secret');
        if ($secret === '') {
            // Configuração ausente — rejeita por padrão (fail-closed).
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expected, $signature);
    }
}
