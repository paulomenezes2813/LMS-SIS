<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\observer;

defined('MOODLE_INTERNAL') || die();

use local_sisrj\outbox;

/**
 * Observa eventos de matrícula do core e envia para o SIS via outbox.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class enrolment {

    public static function enrolment_created(\core\event\user_enrolment_created $event): void {
        outbox::enqueue('enrolment.created', [
            'moodleuserid'   => $event->relateduserid,
            'moodlecourseid' => $event->courseid,
            'enrol'          => $event->other['enrol'] ?? '',
            'timestamp'      => $event->timecreated,
        ]);
    }

    public static function enrolment_deleted(\core\event\user_enrolment_deleted $event): void {
        outbox::enqueue('enrolment.deleted', [
            'moodleuserid'   => $event->relateduserid,
            'moodlecourseid' => $event->courseid,
            'timestamp'      => $event->timecreated,
        ]);
    }
}
