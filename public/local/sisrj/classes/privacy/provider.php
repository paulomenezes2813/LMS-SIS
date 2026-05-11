<?php
// This file is part of the Edukkare-LMS distribution.
// GNU GPL v3 or later. See COPYING.txt.

namespace local_sisrj\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;
use core_privacy\local\metadata\provider as metadataprovider;

/**
 * LGPD / Privacy API — declara que local_sisrj troca dados pessoais com
 * sistema externo (SIS).
 *
 * @package    local_sisrj
 * @copyright  2026 EDUKKARE PEDTECH LTDA
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 */
class provider implements metadataprovider {

    public static function get_metadata(collection $collection): collection {
        $collection->add_external_location_link(
            'sisapi',
            [
                'userid' => 'privacy:metadata:sisapi:userid',
                'sisid'  => 'privacy:metadata:sisapi:sisid',
                'email'  => 'privacy:metadata:sisapi:email',
                'event'  => 'privacy:metadata:sisapi:event',
            ],
            'privacy:metadata:sisapi'
        );
        return $collection;
    }
}
