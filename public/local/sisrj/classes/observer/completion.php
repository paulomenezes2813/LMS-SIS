<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\observer;

defined('MOODLE_INTERNAL') || die();

use local_sisrj\outbox;

/**
 * Observa conclusão de curso e dispara evento de certificação para o SIS.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class completion {

    public static function course_completed(\core\event\course_completed $event): void {
        outbox::enqueue('course.completed', [
            'moodleuserid'   => $event->relateduserid,
            'moodlecourseid' => $event->courseid,
            'completedat'    => $event->timecreated,
        ]);
    }
}
