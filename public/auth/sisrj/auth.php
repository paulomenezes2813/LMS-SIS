<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Auth SISRJ — autenticação via SSO com o SIS (OAuth2 / JWT).
 *
 * Fluxo (Authorization Code com PKCE):
 *   1. Usuário clica "Entrar com Edukkare" → redireciona para /auth/sisrj/login.php
 *   2. login.php redireciona para o SIS com client_id, redirect_uri, state, code_challenge
 *   3. SIS autentica, valida e redireciona de volta com `code`
 *   4. callback.php troca `code` por `access_token` + `id_token` (JWT)
 *   5. JWT é validado (assinatura, iss, aud, exp). Claims viram atributos do usuário.
 *   6. Usuário é criado/atualizado e logado no Moodle.
 *
 * @package    auth_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/authlib.php');

class auth_plugin_sisrj extends auth_plugin_base {

    public function __construct() {
        $this->authtype = 'sisrj';
        $this->config = get_config('auth_sisrj');
    }

    /**
     * Usuários autenticados via SIS não têm senha local. Sempre falso.
     */
    public function user_login($username, $password): bool {
        return false;
    }

    /**
     * Não armazenamos senha — o SIS é a fonte de verdade.
     */
    public function is_internal(): bool {
        return false;
    }

    /**
     * Não permitimos troca de senha pelo Moodle (faça no SIS).
     */
    public function can_change_password(): bool {
        return false;
    }

    /**
     * Não criamos usuários do nada — só vêm via SSO ou via webhook do SIS.
     */
    public function can_signup(): bool {
        return false;
    }

    /**
     * Login alternativo exibe o botão "Entrar com Edukkare" na tela de login.
     */
    public function loginpage_idp_list($wantsurl): array {
        global $CFG;

        return [[
            'url'  => new moodle_url('/auth/sisrj/login.php', ['wantsurl' => $wantsurl]),
            'name' => get_string('signin_with_sisrj', 'auth_sisrj'),
            'iconurl' => $CFG->wwwroot . '/auth/sisrj/pix/icon.svg',
        ]];
    }

    /**
     * Aplica claims do JWT vindo do SIS no perfil do usuário.
     *
     * @param array $claims Claims já validados.
     * @return stdClass user record (criado ou atualizado).
     */
    public function provision_user_from_claims(array $claims): stdClass {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/user/lib.php');

        $sisid = (string) ($claims['sub'] ?? '');
        if ($sisid === '') {
            throw new moodle_exception('jwt_missing_sub', 'auth_sisrj');
        }

        // Tenta achar o usuário pelo idmap mantido em local_sisrj.
        $idmap = $DB->get_record('local_sisrj_idmap', [
            'entitytype' => 'user',
            'sisid'      => $sisid,
        ]);

        $userdata = (object) [
            'auth'      => 'sisrj',
            'username'  => clean_param($claims['preferred_username'] ?? $claims['email'] ?? $sisid, PARAM_USERNAME),
            'email'     => clean_param($claims['email'] ?? '', PARAM_EMAIL),
            'firstname' => clean_param($claims['given_name'] ?? '', PARAM_TEXT),
            'lastname'  => clean_param($claims['family_name'] ?? '', PARAM_TEXT),
            'confirmed' => 1,
            'mnethostid' => $CFG->mnet_localhost_id,
            'lang'      => 'pt_br',
            'timezone'  => 'America/Sao_Paulo',
        ];

        if ($idmap) {
            $userdata->id = $idmap->moodleid;
            user_update_user($userdata, false, true);
            $DB->set_field('local_sisrj_idmap', 'updatedat', time(), ['id' => $idmap->id]);
            return $DB->get_record('user', ['id' => $userdata->id], '*', MUST_EXIST);
        }

        $userid = user_create_user($userdata, false, true);
        $DB->insert_record('local_sisrj_idmap', (object) [
            'entitytype' => 'user',
            'sisid'      => $sisid,
            'moodleid'   => $userid,
            'createdat'  => time(),
            'updatedat'  => time(),
        ]);
        return $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
    }
}
