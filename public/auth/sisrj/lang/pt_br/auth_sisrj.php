<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'SSO Edukkare SIS';
$string['auth_sisrjdescription'] = 'Single sign-on com o SIS da instituição via OAuth 2.0 + OpenID Connect.';
$string['signin_with_sisrj'] = 'Entrar com Edukkare';

$string['settings_oauth'] = 'OAuth 2.0 / OIDC';
$string['settings_oauth_desc'] = 'Endpoints e credenciais registrados no SIS para esta instância Moodle.';

$string['authorize_url'] = 'Endpoint de autorização';
$string['authorize_url_desc'] = 'URL OAuth de autorização exposta pelo SIS.';
$string['token_url'] = 'Endpoint de token';
$string['token_url_desc'] = 'URL OAuth de troca de token exposta pelo SIS.';
$string['expected_issuer'] = 'Issuer esperado';
$string['expected_issuer_desc'] = 'Valor do claim `iss` que o SIS vai assinar nos id_tokens.';
$string['client_id'] = 'Client ID';
$string['client_id_desc'] = 'Identificador OAuth registrado no SIS.';
$string['client_secret'] = 'Client secret';
$string['client_secret_desc'] = 'Segredo OAuth. Armazenado criptografado.';

$string['configmissing'] = 'Auth SISRJ não está configurado. Defina os endpoints OAuth primeiro.';
$string['state_mismatch'] = 'Estado de login não confere — possível CSRF.';
$string['token_exchange_failed'] = 'Falha ao trocar o código de autorização por tokens.';
$string['invalid_jwt'] = 'id_token inválido retornado pelo SIS.';
$string['invalid_issuer'] = 'Issuer do JWT não corresponde ao esperado.';
$string['invalid_audience'] = 'Audience do JWT não corresponde ao client configurado.';
$string['expired_token'] = 'JWT expirado.';
$string['jwt_missing_sub'] = 'JWT sem claim `sub`.';

$string['privacy:metadata'] = 'Auth SISRJ não armazena dados pessoais localmente além do registro Moodle do usuário atualizado a partir dos claims JWT.';
