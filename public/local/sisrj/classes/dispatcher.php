<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj;

defined('MOODLE_INTERNAL') || die();

use local_sisrj\handler\enrolment_handler;
use local_sisrj\handler\user_handler;

/**
 * Despacha um evento recebido do SIS para o handler apropriado.
 *
 * Padrão: cada tipo de evento (`user.created`, `enrolment.created`, etc.) tem
 * um método handler em uma classe `handler/*_handler.php`. Novos eventos
 * adicionam-se aqui e implementam-se em uma classe handler própria.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class dispatcher {

    /**
     * @param string $event Nome do evento (ex.: user.created).
     * @param array $payload Payload decodificado do webhook.
     * @throws \moodle_exception Se evento desconhecido ou falha de processamento.
     */
    public function dispatch(string $event, array $payload): void {
        switch ($event) {
            case 'user.created':
            case 'user.updated':
                (new user_handler())->upsert($payload);
                break;

            case 'user.deleted':
                (new user_handler())->soft_delete($payload);
                break;

            case 'enrolment.created':
                (new enrolment_handler())->create($payload);
                break;

            case 'enrolment.deleted':
                (new enrolment_handler())->delete($payload);
                break;

            default:
                throw new \moodle_exception('webhook_unknown_event', 'local_sisrj', '', $event);
        }
    }
}
