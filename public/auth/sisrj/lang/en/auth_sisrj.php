<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Edukkare SIS SSO';
$string['auth_sisrjdescription'] = 'Single sign-on against the institution\'s SIS via OAuth 2.0 + OpenID Connect.';
$string['signin_with_sisrj'] = 'Sign in with Edukkare';

$string['settings_oauth'] = 'OAuth 2.0 / OIDC';
$string['settings_oauth_desc'] = 'Endpoints and credentials registered in the SIS for this Moodle instance.';

$string['authorize_url'] = 'Authorization endpoint';
$string['authorize_url_desc'] = 'OAuth authorize URL exposed by the SIS.';
$string['token_url'] = 'Token endpoint';
$string['token_url_desc'] = 'OAuth token URL exposed by the SIS.';
$string['expected_issuer'] = 'Expected issuer';
$string['expected_issuer_desc'] = 'Value of the `iss` claim the SIS will sign on id_tokens.';
$string['client_id'] = 'Client ID';
$string['client_id_desc'] = 'OAuth client identifier registered in the SIS.';
$string['client_secret'] = 'Client secret';
$string['client_secret_desc'] = 'OAuth client secret. Stored encrypted.';

$string['configmissing'] = 'Auth SISRJ is not configured. Set the OAuth endpoints first.';
$string['state_mismatch'] = 'Login state mismatch — possible CSRF.';
$string['token_exchange_failed'] = 'Failed to exchange authorization code for tokens.';
$string['invalid_jwt'] = 'Invalid id_token returned by the SIS.';
$string['invalid_issuer'] = 'JWT issuer does not match the expected one.';
$string['invalid_audience'] = 'JWT audience does not match the configured client.';
$string['expired_token'] = 'JWT is expired.';
$string['jwt_missing_sub'] = 'JWT is missing the `sub` claim.';

$string['privacy:metadata'] = 'Auth SISRJ does not store personal data locally beyond the standard Moodle user record updated from JWT claims.';
