<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Enrol SISRJ — método de matrícula controlado pelo SIS.
 *
 * Matrículas são criadas/removidas exclusivamente via webhooks recebidos
 * pelo `local_sisrj`. Nenhuma ação manual é permitida — o SIS é a fonte
 * de verdade da matrícula.
 *
 * @package    enrol_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class enrol_sisrj_plugin extends enrol_plugin {

    /**
     * Permite múltiplas instâncias por curso? Não — apenas uma.
     */
    public function get_instance_defaults() {
        return [
            'status'        => ENROL_INSTANCE_ENABLED,
            'roleid'        => $this->get_config('roleid', 5),  // student por padrão
            'enrolperiod'   => 0,
        ];
    }

    public function can_add_instance($courseid): bool {
        $context = context_course::instance($courseid, MUST_EXIST);
        return has_capability('moodle/course:enrolconfig', $context)
            && has_capability('enrol/sisrj:config', $context);
    }

    public function allow_unenrol(stdClass $instance): bool {
        return false;
    }

    public function allow_manage(stdClass $instance): bool {
        return false;
    }

    /**
     * Marca o método como apenas-leitura na UI — não dá pra editar manualmente.
     */
    public function roles_protected(): bool {
        return true;
    }

    /**
     * Não exibe link de matrícula no curso — usuário não escolhe se inscrever.
     */
    public function get_unenrolself_link($instance): null {
        return null;
    }

    /**
     * Adiciona uma única instância automaticamente quando o curso é criado.
     */
    public function add_default_instance($course) {
        $fields = $this->get_instance_defaults();
        return $this->add_instance($course, $fields);
    }

    /**
     * Sincronizar via cron está a cargo do local_sisrj — aqui retornamos OK.
     */
    public function sync(progress_trace $trace, $courseid = null): int {
        $trace->output('enrol_sisrj: sync delegated to local_sisrj scheduled tasks.');
        return 0;
    }
}
