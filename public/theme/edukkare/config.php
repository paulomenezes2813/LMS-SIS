<?php
// This file is part of the Edukkare-LMS distribution.
//
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Theme Edukkare — config (child of Boost).
 *
 * @package    theme_edukkare
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'edukkare';
$THEME->parents = ['boost'];

$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->editor_scss = ['editor'];
$THEME->usefallback = true;

// SCSS pipeline:
//  1. pre_scss   — tokens (variáveis Sass) injetadas ANTES do Boost (override de _variables).
//  2. main scss  — herdado de Boost via theme_boost_get_main_scss_content().
//  3. extra_scss — regras custom DEPOIS do Boost (post.scss) para sobrescrever componentes.
$THEME->scss = function ($theme) {
    return theme_edukkare_get_main_scss_content($theme);
};

$THEME->prescsscallback = 'theme_edukkare_get_pre_scss';
$THEME->extrascsscallback = 'theme_edukkare_get_extra_scss';

// Layouts: a maior parte é herdada do Boost. Override só do login para injetar
// `logourl` e `logintagline` no contexto Mustache do nosso painel custom.
$THEME->layouts = [
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['langmenu' => true],
    ],
];

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;
$THEME->haseditswitch = true;
$THEME->usescourseindex = true;
$THEME->activityheaderconfig = [
    'notitle' => true,
];

// Marca o tema como pronto para o admin trocar livremente.
$THEME->doctype = 'html5';
$THEME->yuicssmodules = [];
