<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'tool_sisrj';
$plugin->version   = 2026051000;
$plugin->release   = '0.1.0';
$plugin->requires  = 2025040100;
$plugin->maturity  = MATURITY_ALPHA;
$plugin->dependencies = [
    'local_sisrj' => 2026051000,
];
