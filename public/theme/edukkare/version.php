<?php
// This file is part of the Edukkare-LMS distribution.
//
// Theme Edukkare is licensed under the GNU GPL v3 or later, in conformity
// with the upstream Moodle license. See COPYING.txt at the project root.

/**
 * Theme Edukkare — version definition.
 *
 * @package    theme_edukkare
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_edukkare';
$plugin->version   = 2026051000;        // Date: 2026-05-10, release 00.
$plugin->release   = '1.0.0';
$plugin->requires  = 2025040100;        // Moodle 5.0+.
$plugin->maturity  = MATURITY_ALPHA;
$plugin->dependencies = [
    'theme_boost' => 2025040100,
];
