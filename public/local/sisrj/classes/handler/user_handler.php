<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\handler;

defined('MOODLE_INTERNAL') || die();

/**
 * Cria/atualiza/desabilita usuários no Moodle a partir de eventos do SIS.
 *
 * Payload esperado (user.created / user.updated):
 * {
 *   "sisid": "12345",
 *   "username": "fulano.silva",
 *   "email": "fulano@dominio",
 *   "firstname": "Fulano",
 *   "lastname": "Silva",
 *   "cpf": "00000000000",
 *   "role": "student" | "teacher" | "manager"
 * }
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class user_handler {

    public function upsert(array $payload): int {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/user/lib.php');
        require_once($CFG->libdir . '/moodlelib.php');

        $sisid = (string) ($payload['sisid'] ?? '');
        if ($sisid === '') {
            throw new \moodle_exception('webhook_invalid_payload', 'local_sisrj');
        }

        $idmap = $DB->get_record('local_sisrj_idmap', [
            'entitytype' => 'user',
            'sisid'      => $sisid,
        ]);

        $data = (object) [
            'username'  => clean_param($payload['username'] ?? '', PARAM_USERNAME),
            'email'     => clean_param($payload['email'] ?? '', PARAM_EMAIL),
            'firstname' => clean_param($payload['firstname'] ?? '', PARAM_TEXT),
            'lastname'  => clean_param($payload['lastname'] ?? '', PARAM_TEXT),
            'auth'      => 'sisrj',
            'confirmed' => 1,
            'mnethostid' => $CFG->mnet_localhost_id,
            'lang'      => 'pt_br',
        ];

        if ($idmap) {
            $data->id = $idmap->moodleid;
            user_update_user($data, false, true);
            $DB->set_field('local_sisrj_idmap', 'updatedat', time(), ['id' => $idmap->id]);
            return (int) $data->id;
        }

        $userid = user_create_user($data, false, true);

        $DB->insert_record('local_sisrj_idmap', (object) [
            'entitytype' => 'user',
            'sisid'      => $sisid,
            'moodleid'   => $userid,
            'createdat'  => time(),
            'updatedat'  => time(),
        ]);

        return (int) $userid;
    }

    public function soft_delete(array $payload): void {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/user/lib.php');

        $sisid = (string) ($payload['sisid'] ?? '');
        $idmap = $DB->get_record('local_sisrj_idmap', [
            'entitytype' => 'user',
            'sisid'      => $sisid,
        ]);
        if (!$idmap) {
            return;
        }

        $user = $DB->get_record('user', ['id' => $idmap->moodleid]);
        if ($user && !$user->deleted) {
            // Exclusão lógica — atende requisito 36 desejável (LGPD).
            $DB->set_field('user', 'suspended', 1, ['id' => $user->id]);
        }
    }
}
