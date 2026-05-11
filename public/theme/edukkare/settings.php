<?php
// This file is part of the Edukkare-LMS distribution.
//
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Theme Edukkare — settings.
 *
 * @package    theme_edukkare
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings = new theme_boost_admin_settingspage_tabs('themesettingedukkare', get_string('configtitle', 'theme_edukkare'));

    // ====== Aba: Geral ======
    $page = new admin_settingpage('theme_edukkare_general', get_string('generalsettings', 'theme_edukkare'));

    // Cor primária.
    $name = 'theme_edukkare/brandcolor';
    $title = get_string('brandcolor', 'theme_edukkare');
    $description = get_string('brandcolor_desc', 'theme_edukkare');
    $default = '#3730A3';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo principal.
    $name = 'theme_edukkare/logo';
    $title = get_string('logo', 'theme_edukkare');
    $description = get_string('logo_desc', 'theme_edukkare');
    $opts = ['accepted_types' => ['.svg', '.png'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo compacto.
    $name = 'theme_edukkare/logocompact';
    $title = get_string('logocompact', 'theme_edukkare');
    $description = get_string('logocompact_desc', 'theme_edukkare');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logocompact', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Favicon.
    $name = 'theme_edukkare/favicon';
    $title = get_string('favicon', 'theme_edukkare');
    $description = get_string('favicon_desc', 'theme_edukkare');
    $opts = ['accepted_types' => ['.ico', '.png', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // ====== Aba: Login ======
    $page = new admin_settingpage('theme_edukkare_login', get_string('loginsettings', 'theme_edukkare'));

    $name = 'theme_edukkare/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_edukkare');
    $description = get_string('loginbackgroundimage_desc', 'theme_edukkare');
    $opts = ['accepted_types' => ['.jpg', '.jpeg', '.png', '.webp'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_edukkare/logintagline';
    $title = get_string('logintagline', 'theme_edukkare');
    $description = get_string('logintagline_desc', 'theme_edukkare');
    $default = get_string('default_logintagline', 'theme_edukkare');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $page->add($setting);

    $settings->add($page);

    // ====== Aba: SCSS avançado ======
    $page = new admin_settingpage('theme_edukkare_advanced', get_string('advancedsettings', 'theme_edukkare'));

    $name = 'theme_edukkare/scsspre';
    $title = get_string('scsspre', 'theme_edukkare');
    $description = get_string('scsspre_desc', 'theme_edukkare');
    $default = '';
    $setting = new admin_setting_scsscode($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_edukkare/scsspost';
    $title = get_string('scsspost', 'theme_edukkare');
    $description = get_string('scsspost_desc', 'theme_edukkare');
    $default = '';
    $setting = new admin_setting_scsscode($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
