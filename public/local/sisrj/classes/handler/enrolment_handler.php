<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\handler;

defined('MOODLE_INTERNAL') || die();

/**
 * Provisiona matrículas no Moodle a partir de eventos do SIS.
 *
 * Payload esperado (enrolment.created):
 * {
 *   "sisenrolmentid": "abc-123",
 *   "user": { "sisid": "12345" },
 *   "course": { "sisid": "CURSO-2026-1" },
 *   "role": "student",
 *   "timestart": 1715000000,
 *   "timeend": 1730000000
 * }
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class enrolment_handler {

    public function create(array $payload): void {
        global $DB;

        $userid = $this->resolve_user_moodleid($payload['user']['sisid'] ?? '');
        $courseid = $this->resolve_course_moodleid($payload['course']['sisid'] ?? '');
        $roleshortname = clean_param($payload['role'] ?? 'student', PARAM_ALPHANUMEXT);

        $role = $DB->get_record('role', ['shortname' => $roleshortname]);
        if (!$role) {
            throw new \moodle_exception('Role not found: ' . $roleshortname);
        }

        // Usa o plugin enrol_sisrj (que vamos criar a seguir).
        $plugin = enrol_get_plugin('sisrj');
        if (!$plugin) {
            throw new \moodle_exception('enrol_sisrj plugin not installed');
        }

        $instance = $DB->get_record('enrol', [
            'courseid' => $courseid,
            'enrol'    => 'sisrj',
        ]);
        if (!$instance) {
            $course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
            $instanceid = $plugin->add_instance($course);
            $instance = $DB->get_record('enrol', ['id' => $instanceid], '*', MUST_EXIST);
        }

        $plugin->enrol_user(
            $instance,
            $userid,
            $role->id,
            (int) ($payload['timestart'] ?? 0),
            (int) ($payload['timeend'] ?? 0)
        );

        $DB->insert_record('local_sisrj_idmap', (object) [
            'entitytype' => 'enrolment',
            'sisid'      => $payload['sisenrolmentid'] ?? '',
            'moodleid'   => $userid,
            'createdat'  => time(),
            'updatedat'  => time(),
        ]);
    }

    public function delete(array $payload): void {
        global $DB;

        $userid = $this->resolve_user_moodleid($payload['user']['sisid'] ?? '');
        $courseid = $this->resolve_course_moodleid($payload['course']['sisid'] ?? '');

        $plugin = enrol_get_plugin('sisrj');
        $instance = $DB->get_record('enrol', [
            'courseid' => $courseid,
            'enrol'    => 'sisrj',
        ]);
        if ($instance && $plugin) {
            $plugin->unenrol_user($instance, $userid);
        }
    }

    private function resolve_user_moodleid(string $sisid): int {
        global $DB;
        $idmap = $DB->get_record('local_sisrj_idmap', [
            'entitytype' => 'user',
            'sisid'      => $sisid,
        ], '*', MUST_EXIST);
        return (int) $idmap->moodleid;
    }

    private function resolve_course_moodleid(string $sisid): int {
        global $DB;
        $idmap = $DB->get_record('local_sisrj_idmap', [
            'entitytype' => 'course',
            'sisid'      => $sisid,
        ], '*', MUST_EXIST);
        return (int) $idmap->moodleid;
    }
}
