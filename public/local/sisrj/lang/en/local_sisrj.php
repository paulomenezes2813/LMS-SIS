<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

/**
 * Local SISRJ — English strings.
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'SIS-RJ integration engine';

// Settings.
$string['settings_general'] = 'General';
$string['sis_base_url'] = 'SIS base URL';
$string['sis_base_url_desc'] = 'Root URL of the SIS REST API (no trailing slash). Example: https://emedi.edukkare.com.br/sis/api';
$string['sis_outbox_token'] = 'Outbox auth token';
$string['sis_outbox_token_desc'] = 'Bearer token Moodle uses when sending outbound webhooks to the SIS.';
$string['sis_inbox_secret'] = 'Inbox HMAC secret';
$string['sis_inbox_secret_desc'] = 'Shared secret used to validate inbound webhook signatures (HMAC-SHA256).';
$string['outbox_retry_max'] = 'Outbox retry limit';
$string['outbox_retry_max_desc'] = 'Maximum number of attempts before marking an outbound event as failed.';

// Capabilities.
$string['sisrj:receivewebhook'] = 'Receive webhook events from the SIS';
$string['sisrj:viewlogs'] = 'View SIS-RJ integration logs';
$string['sisrj:retrywebhook'] = 'Retry failed webhook deliveries';

// Tasks.
$string['task_process_inbox'] = 'SIS-RJ: process inbox queue';
$string['task_process_outbox'] = 'SIS-RJ: deliver outbox events';
$string['task_reconcile'] = 'SIS-RJ: nightly reconciliation';

// Webhook responses.
$string['webhook_received'] = 'Webhook accepted';
$string['webhook_invalid_signature'] = 'Invalid webhook signature';
$string['webhook_invalid_payload'] = 'Invalid webhook payload';
$string['webhook_unknown_event'] = 'Unknown event type: {$a}';

// Privacy.
$string['privacy:metadata:sisapi'] = 'The SIS-RJ integration exchanges user identifiers, enrolment data and grades with the institution\'s Student Information System.';
$string['privacy:metadata:sisapi:userid'] = 'Internal Moodle user id';
$string['privacy:metadata:sisapi:sisid'] = 'Identifier of the user in the SIS';
$string['privacy:metadata:sisapi:email'] = 'User email address';
$string['privacy:metadata:sisapi:event'] = 'Type of event exchanged';
