<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Auth SISRJ — settings.
 *
 * @package    auth_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading(
        'auth_sisrj_oauth',
        get_string('settings_oauth', 'auth_sisrj'),
        get_string('settings_oauth_desc', 'auth_sisrj')
    ));

    $settings->add(new admin_setting_configtext(
        'auth_sisrj/authorize_url',
        get_string('authorize_url', 'auth_sisrj'),
        get_string('authorize_url_desc', 'auth_sisrj'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'auth_sisrj/token_url',
        get_string('token_url', 'auth_sisrj'),
        get_string('token_url_desc', 'auth_sisrj'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'auth_sisrj/expected_issuer',
        get_string('expected_issuer', 'auth_sisrj'),
        get_string('expected_issuer_desc', 'auth_sisrj'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'auth_sisrj/client_id',
        get_string('client_id', 'auth_sisrj'),
        get_string('client_id_desc', 'auth_sisrj'),
        '',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'auth_sisrj/client_secret',
        get_string('client_secret', 'auth_sisrj'),
        get_string('client_secret_desc', 'auth_sisrj'),
        ''
    ));
}
