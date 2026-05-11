<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Auth SISRJ — version.
 *
 * @package    auth_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'auth_sisrj';
$plugin->version   = 2026051000;
$plugin->release   = '0.1.0';
$plugin->requires  = 2025040100;
$plugin->maturity  = MATURITY_ALPHA;
$plugin->dependencies = [
    'local_sisrj' => 2026051000,
];
