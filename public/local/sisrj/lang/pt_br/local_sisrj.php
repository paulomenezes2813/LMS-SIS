<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Local SISRJ — Portuguese (Brazil) strings.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Engine de integração SIS-RJ';

$string['settings_general'] = 'Geral';
$string['sis_base_url'] = 'URL base do SIS';
$string['sis_base_url_desc'] = 'URL raiz da API REST do SIS (sem barra no final). Exemplo: https://emedi.edukkare.com.br/sis/api';
$string['sis_outbox_token'] = 'Token de autenticação outbox';
$string['sis_outbox_token_desc'] = 'Bearer token que o Moodle usa ao enviar webhooks para o SIS.';
$string['sis_inbox_secret'] = 'Segredo HMAC do inbox';
$string['sis_inbox_secret_desc'] = 'Segredo compartilhado para validar assinaturas dos webhooks recebidos (HMAC-SHA256).';
$string['outbox_retry_max'] = 'Tentativas máximas (outbox)';
$string['outbox_retry_max_desc'] = 'Quantidade máxima de tentativas antes de marcar um evento como falhado.';

$string['sisrj:receivewebhook'] = 'Receber eventos webhook do SIS';
$string['sisrj:viewlogs'] = 'Visualizar logs da integração SIS-RJ';
$string['sisrj:retrywebhook'] = 'Reexecutar webhooks que falharam';

$string['task_process_inbox'] = 'SIS-RJ: processar fila de entrada';
$string['task_process_outbox'] = 'SIS-RJ: entregar eventos da fila de saída';
$string['task_reconcile'] = 'SIS-RJ: reconciliação noturna';

$string['webhook_received'] = 'Webhook aceito';
$string['webhook_invalid_signature'] = 'Assinatura de webhook inválida';
$string['webhook_invalid_payload'] = 'Payload do webhook inválido';
$string['webhook_unknown_event'] = 'Tipo de evento desconhecido: {$a}';

$string['privacy:metadata:sisapi'] = 'A integração SIS-RJ troca identificadores de usuário, dados de matrícula e notas com o Sistema de Informação do Estudante da instituição.';
$string['privacy:metadata:sisapi:userid'] = 'ID interno do usuário no Moodle';
$string['privacy:metadata:sisapi:sisid'] = 'Identificador do usuário no SIS';
$string['privacy:metadata:sisapi:email'] = 'Endereço de e-mail do usuário';
$string['privacy:metadata:sisapi:event'] = 'Tipo de evento trocado';
