<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Traits;

trait UsersOnlineTrait
{
    /**
     * Check if the current user is online.
     *
     * @return bool
     */
    public function isOnline()
    {
        if (! $this->last_action) {
            return false;
        }

        return $this->last_action->gt(now()->subMinutes(5));
    }
}
