<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Local SISRJ — event observers (envia eventos Moodle → SIS via outbox).
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\\core\\event\\course_completed',
        'callback'  => '\\local_sisrj\\observer\\completion::course_completed',
    ],
    [
        'eventname' => '\\core\\event\\user_graded',
        'callback'  => '\\local_sisrj\\observer\\grades::user_graded',
    ],
    [
        'eventname' => '\\core\\event\\user_enrolment_created',
        'callback'  => '\\local_sisrj\\observer\\enrolment::enrolment_created',
    ],
    [
        'eventname' => '\\core\\event\\user_enrolment_deleted',
        'callback'  => '\\local_sisrj\\observer\\enrolment::enrolment_deleted',
    ],
];
