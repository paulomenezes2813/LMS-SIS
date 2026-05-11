<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\external;

defined('MOODLE_INTERNAL') || die();

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;

/**
 * Healthcheck endpoint para o SIS verificar disponibilidade.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class ping extends external_api {

    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([]);
    }

    public static function execute(): array {
        global $CFG;
        return [
            'status'  => 'ok',
            'release' => $CFG->release,
            'time'    => time(),
        ];
    }

    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'status'  => new external_value(PARAM_ALPHA, 'ok|degraded|down'),
            'release' => new external_value(PARAM_TEXT, 'Moodle release'),
            'time'    => new external_value(PARAM_INT, 'Unix timestamp'),
        ]);
    }
}
