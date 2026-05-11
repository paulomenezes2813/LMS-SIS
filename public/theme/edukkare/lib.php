<?php
// This file is part of the Edukkare-LMS distribution.
//
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Theme Edukkare — SCSS callbacks.
 *
 * @package    theme_edukkare
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Retorna o SCSS principal (herdado de Boost).
 *
 * @param theme_config $theme
 * @return string
 */
function theme_edukkare_get_main_scss_content($theme) {
    global $CFG;

    // Permite que o admin escolha um preset alternativo no futuro; por padrão usa o do Boost.
    require_once($CFG->dirroot . '/theme/boost/lib.php');

    return theme_boost_get_main_scss_content($theme);
}

/**
 * Pre-SCSS: tokens da marca Edukkare. Carregado ANTES do _variables do Boost para que
 * sobrescreva as variáveis padrão (cores, fontes, raios).
 *
 * @param theme_config $theme
 * @return string
 */
function theme_edukkare_get_pre_scss($theme) {
    $scss = '';

    // Cores customizadas vindas das settings (sobrescrevem o pre.scss embutido).
    $brandcolor = isset($theme->settings->brandcolor) ? $theme->settings->brandcolor : '';
    if (!empty($brandcolor)) {
        $scss .= '$primary: ' . $brandcolor . ';' . "\n";
    }

    // Carrega o arquivo de tokens da marca.
    $prescssfile = __DIR__ . '/scss/pre.scss';
    if (file_exists($prescssfile)) {
        $scss .= "\n" . file_get_contents($prescssfile);
    }

    // Custom SCSS livre via settings (admin pode injetar overrides sem editar arquivo).
    if (!empty($theme->settings->scsspre)) {
        $scss .= "\n" . $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Extra-SCSS: regras custom DEPOIS do Boost. Sobrescreve componentes (login, cards,
 * botões, certificados, etc.) sem precisar duplicar todo o _variables.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_edukkare_get_extra_scss($theme) {
    $scss = '';

    $postscssfile = __DIR__ . '/scss/post.scss';
    if (file_exists($postscssfile)) {
        $scss .= file_get_contents($postscssfile);
    }

    if (!empty($theme->settings->scsspost)) {
        $scss .= "\n" . $theme->settings->scsspost;
    }

    return $scss;
}

/**
 * Devolve a URL de uma imagem servida pelo tema (logo, favicon, login background).
 *
 * @param string $filearea
 * @param string $filename
 * @param theme_config $theme
 * @return moodle_url|null
 */
function theme_edukkare_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel === CONTEXT_SYSTEM
        && in_array($filearea, ['logo', 'logocompact', 'loginbackgroundimage', 'favicon'], true)) {
        $theme = theme_config::load('edukkare');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
    send_file_not_found();
}
