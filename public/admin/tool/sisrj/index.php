<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Tool SISRJ — dashboard de status da integração SIS ↔ Moodle.
 *
 * @package    tool_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('tool_sisrj_dashboard');
require_capability('local/sisrj:viewlogs', context_system::instance());

$PAGE->set_title(get_string('dashboard', 'tool_sisrj'));
$PAGE->set_heading(get_string('dashboard', 'tool_sisrj'));

echo $OUTPUT->header();

// Contadores rápidos por status.
$counts = [];
foreach (['pending', 'processing', 'done', 'failed', 'abandoned'] as $status) {
    $counts['inbox'][$status]  = $DB->count_records('local_sisrj_webhook_log', ['status' => $status]);
}
foreach (['pending', 'retry', 'done', 'failed'] as $status) {
    $counts['outbox'][$status] = $DB->count_records('local_sisrj_outbox', ['status' => $status]);
}

echo $OUTPUT->heading(get_string('inbox', 'tool_sisrj'), 3);
echo html_writer::start_tag('div', ['class' => 'd-flex flex-wrap gap-3 mb-4']);
foreach ($counts['inbox'] as $status => $n) {
    echo html_writer::tag(
        'div',
        html_writer::tag('strong', $n, ['class' => 'h4 d-block']) .
        html_writer::tag('span', get_string("status_$status", 'tool_sisrj'), ['class' => 'text-muted small']),
        ['class' => 'card p-3 border']
    );
}
echo html_writer::end_tag('div');

echo $OUTPUT->heading(get_string('outbox', 'tool_sisrj'), 3);
echo html_writer::start_tag('div', ['class' => 'd-flex flex-wrap gap-3 mb-4']);
foreach ($counts['outbox'] as $status => $n) {
    echo html_writer::tag(
        'div',
        html_writer::tag('strong', $n, ['class' => 'h4 d-block']) .
        html_writer::tag('span', get_string("status_$status", 'tool_sisrj'), ['class' => 'text-muted small']),
        ['class' => 'card p-3 border']
    );
}
echo html_writer::end_tag('div');

// Últimos 20 webhooks recebidos.
echo $OUTPUT->heading(get_string('recent_events', 'tool_sisrj'), 3);
$recent = $DB->get_records('local_sisrj_webhook_log', null, 'receivedat DESC', '*', 0, 20);

$table = new html_table();
$table->head = ['#', 'Evento', 'Status', 'Tentativas', 'Recebido em', 'Último erro'];
foreach ($recent as $r) {
    $table->data[] = [
        $r->id,
        s($r->event),
        s($r->status),
        $r->attempts,
        userdate($r->receivedat),
        s(mb_strimwidth((string) $r->lasterror, 0, 80, '…')),
    ];
}
echo html_writer::table($table);

echo $OUTPUT->footer();
