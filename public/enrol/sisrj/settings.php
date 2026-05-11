<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading(
        'enrol_sisrj_settings',
        '',
        get_string('pluginname_desc', 'enrol_sisrj')
    ));

    // Role padrão para matrículas vindas do SIS quando o evento não especifica.
    $roles = get_default_enrol_roles(context_system::instance());
    $studentrole = get_archetype_roles('student');
    $studentrole = key($studentrole);
    $settings->add(new admin_setting_configselect(
        'enrol_sisrj/roleid',
        get_string('defaultrole', 'enrol_sisrj'),
        get_string('defaultrole_desc', 'enrol_sisrj'),
        $studentrole,
        $roles
    ));
}
