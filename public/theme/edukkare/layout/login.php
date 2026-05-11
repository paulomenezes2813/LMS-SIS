<?php
// This file is part of the Edukkare-LMS distribution.
//
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Theme Edukkare — login layout (override do Boost).
 *
 * Diferenças em relação ao Boost:
 *  - Injeta a URL do logo configurado em `core_admin/logo` no contexto Mustache
 *    para o painel esquerdo usar o logo do cliente (ex.: EDUKARE PEDTECH).
 *  - Injeta a tagline configurada pelo admin em theme_edukkare → Login.
 *
 * @package    theme_edukkare
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes();

// Instruções customizadas do admin (mantém compatibilidade com auth_instructions).
$leftinstructions = !empty($CFG->auth_instructions)
    ? format_text($CFG->auth_instructions, FORMAT_MOODLE, ['context' => context_system::instance()])
    : null;

// URL do logo configurado no site. Usa o logo principal se disponível, senão o compacto.
$logourl = $OUTPUT->get_logo_url(null, 200);
if (!$logourl) {
    $logourl = $OUTPUT->get_compact_logo_url(null, 200);
}

// Tagline custom do tema; fallback para o default.
$logintagline = get_config('theme_edukkare', 'logintagline');
if (empty($logintagline)) {
    $logintagline = get_string('default_logintagline', 'theme_edukkare');
}

$templatecontext = [
    'sitename'        => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), 'escape' => false]),
    'sitefullname'    => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID), 'escape' => false]),
    'output'          => $OUTPUT,
    'bodyattributes'  => $bodyattributes,
    'leftinstructions' => $leftinstructions,
    'logourl'         => $logourl ? $logourl->out(false) : null,
    'logintagline'    => $logintagline,
];

echo $OUTPUT->render_from_template('theme_boost/login', $templatecontext);
