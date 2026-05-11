<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;

/**
 * Reconciliação diária — compara entidades entre SIS e Moodle e corrige drift.
 *
 * Estratégia (escopo MVP):
 *   1. Marca webhooks com status='failed' há mais de 24h como 'abandoned'
 *      para evitar reprocessamento infinito.
 *   2. Limpa registros de webhook concluídos com mais de 30 dias.
 *   3. (Futuro) Chama endpoint SIS /sync/diff para descobrir entidades
 *      criadas/atualizadas/deletadas que não passaram por webhook.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class reconcile extends scheduled_task {

    public function get_name(): string {
        return get_string('task_reconcile', 'local_sisrj');
    }

    public function execute(): void {
        global $DB;

        $cutoffabandoned = time() - (24 * 3600);
        $DB->execute(
            "UPDATE {local_sisrj_webhook_log}
                SET status = 'abandoned'
              WHERE status = 'failed' AND receivedat < ?",
            [$cutoffabandoned]
        );

        $cutoffpurge = time() - (30 * 24 * 3600);
        $DB->delete_records_select(
            'local_sisrj_webhook_log',
            "status IN ('done', 'abandoned') AND receivedat < ?",
            [$cutoffpurge]
        );

        mtrace('[local_sisrj] reconciliação concluída.');
    }
}
