<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('reports', new admin_externalpage(
        'tool_sisrj_dashboard',
        get_string('dashboard', 'tool_sisrj'),
        new moodle_url('/admin/tool/sisrj/index.php'),
        'local/sisrj:viewlogs'
    ));
}
