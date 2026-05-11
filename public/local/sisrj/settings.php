<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Local SISRJ — settings page.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $settings = new admin_settingpage('local_sisrj', get_string('pluginname', 'local_sisrj'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_heading(
        'local_sisrj_general',
        get_string('settings_general', 'local_sisrj'),
        ''
    ));

    $settings->add(new admin_setting_configtext(
        'local_sisrj/sis_base_url',
        get_string('sis_base_url', 'local_sisrj'),
        get_string('sis_base_url_desc', 'local_sisrj'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'local_sisrj/sis_outbox_token',
        get_string('sis_outbox_token', 'local_sisrj'),
        get_string('sis_outbox_token_desc', 'local_sisrj'),
        ''
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'local_sisrj/sis_inbox_secret',
        get_string('sis_inbox_secret', 'local_sisrj'),
        get_string('sis_inbox_secret_desc', 'local_sisrj'),
        ''
    ));

    $settings->add(new admin_setting_configtext(
        'local_sisrj/outbox_retry_max',
        get_string('outbox_retry_max', 'local_sisrj'),
        get_string('outbox_retry_max_desc', 'local_sisrj'),
        '5',
        PARAM_INT
    ));
}
