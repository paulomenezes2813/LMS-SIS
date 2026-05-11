<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\observer;

defined('MOODLE_INTERNAL') || die();

use local_sisrj\outbox;

/**
 * Observa atualização de nota e envia para o SIS.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class grades {

    public static function user_graded(\core\event\user_graded $event): void {
        $grade = $event->get_grade();

        outbox::enqueue('grade.updated', [
            'moodleuserid'   => $event->relateduserid,
            'moodlecourseid' => $event->courseid,
            'itemid'         => $grade ? $grade->itemid : null,
            'value'          => $grade ? $grade->finalgrade : null,
            'gradedat'       => $event->timecreated,
        ]);
    }
}
