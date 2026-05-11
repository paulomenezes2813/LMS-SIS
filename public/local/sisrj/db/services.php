<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Local SISRJ — declaração de Web Services REST.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Funções expostas. URL final: /webservice/rest/server.php?wsfunction=local_sisrj_<func>
$functions = [

    'local_sisrj_receive_webhook' => [
        'classname'   => 'local_sisrj\\external\\receive_webhook',
        'methodname'  => 'execute',
        'description' => 'Recebe webhook do SIS (user.created, enrolment.*, course.*).',
        'type'        => 'write',
        'capabilities' => 'local/sisrj:receivewebhook',
        'ajax'        => false,
        'services'    => ['sisrj_integration'],
    ],

    'local_sisrj_ping' => [
        'classname'   => 'local_sisrj\\external\\ping',
        'methodname'  => 'execute',
        'description' => 'Healthcheck do canal SIS → Moodle.',
        'type'        => 'read',
        'capabilities' => '',
        'ajax'        => false,
        'services'    => ['sisrj_integration'],
    ],
];

// Serviço pré-configurado para o SIS consumir com um token único.
$services = [
    'sisrj_integration' => [
        'functions'        => ['local_sisrj_receive_webhook', 'local_sisrj_ping'],
        'restrictedusers'  => 1,
        'enabled'          => 1,
        'shortname'        => 'sisrj_integration',
        'downloadfiles'    => 0,
        'uploadfiles'      => 0,
    ],
];
