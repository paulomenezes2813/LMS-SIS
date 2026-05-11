<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Auth SISRJ — entry point. Inicia o fluxo OAuth2 redirecionando ao SIS.
 *
 * @package    auth_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');

require_login(0, false);  // sessão pública ainda OK; aborta se já logado abaixo.

$wantsurl = optional_param('wantsurl', '', PARAM_LOCALURL);
$config = get_config('auth_sisrj');

if (empty($config->authorize_url) || empty($config->client_id)) {
    print_error('configmissing', 'auth_sisrj');
}

// PKCE — proteção contra interceptação do code.
$verifier = bin2hex(random_bytes(32));
$challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

// State — proteção contra CSRF e amarra ao wantsurl.
$state = bin2hex(random_bytes(16));

$SESSION->auth_sisrj_pkce_verifier = $verifier;
$SESSION->auth_sisrj_state         = $state;
$SESSION->auth_sisrj_wantsurl      = $wantsurl;

$params = [
    'response_type'         => 'code',
    'client_id'             => $config->client_id,
    'redirect_uri'          => $CFG->wwwroot . '/auth/sisrj/callback.php',
    'scope'                 => 'openid profile email',
    'state'                 => $state,
    'code_challenge'        => $challenge,
    'code_challenge_method' => 'S256',
];

$authorizeurl = $config->authorize_url . '?' . http_build_query($params);
redirect($authorizeurl);
