<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Auth SISRJ — callback do OAuth2. Troca code por tokens e loga o usuário.
 *
 * @package    auth_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->dirroot . '/auth/sisrj/auth.php');

$code  = required_param('code', PARAM_ALPHANUMEXT);
$state = required_param('state', PARAM_ALPHANUMEXT);

// Valida state.
if (empty($SESSION->auth_sisrj_state) || !hash_equals($SESSION->auth_sisrj_state, $state)) {
    print_error('state_mismatch', 'auth_sisrj');
}

$verifier = $SESSION->auth_sisrj_pkce_verifier ?? '';
$wantsurl = $SESSION->auth_sisrj_wantsurl ?? '';
unset($SESSION->auth_sisrj_state, $SESSION->auth_sisrj_pkce_verifier, $SESSION->auth_sisrj_wantsurl);

$config = get_config('auth_sisrj');

// Troca code por tokens.
$curl = new curl();
$curl->setHeader(['Content-Type: application/x-www-form-urlencoded']);
$response = $curl->post($config->token_url, http_build_query([
    'grant_type'    => 'authorization_code',
    'code'          => $code,
    'redirect_uri'  => $CFG->wwwroot . '/auth/sisrj/callback.php',
    'client_id'     => $config->client_id,
    'client_secret' => $config->client_secret,
    'code_verifier' => $verifier,
]));

$tokens = json_decode($response, true);
if (empty($tokens['id_token'])) {
    print_error('token_exchange_failed', 'auth_sisrj');
}

// Decodifica e valida JWT id_token.
// Implementação simples — em produção use firebase/php-jwt com validação de
// assinatura via JWKS endpoint do SIS.
$parts = explode('.', $tokens['id_token']);
if (count($parts) !== 3) {
    print_error('invalid_jwt', 'auth_sisrj');
}
$claims = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

// Validações mínimas.
$expectediss = $config->expected_issuer ?? '';
if ($expectediss && ($claims['iss'] ?? '') !== $expectediss) {
    print_error('invalid_issuer', 'auth_sisrj');
}
if (($claims['aud'] ?? '') !== $config->client_id) {
    print_error('invalid_audience', 'auth_sisrj');
}
if (($claims['exp'] ?? 0) < time()) {
    print_error('expired_token', 'auth_sisrj');
}

// Provisiona/atualiza usuário e loga.
$auth = new auth_plugin_sisrj();
$user = $auth->provision_user_from_claims($claims);

complete_user_login($user);

if (!empty($wantsurl)) {
    redirect(new moodle_url($wantsurl));
}
redirect(new moodle_url('/my/'));
