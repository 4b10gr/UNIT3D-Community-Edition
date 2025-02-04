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

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Seedbox;
use Illuminate\Http\Request;

class SeedboxController extends Controller
{
    /**
     * Display All Registered Seedboxes.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $seedboxes = Seedbox::with('user')->latest()->paginate(50);

        return view('Staff.seedbox.index', ['seedboxes' => $seedboxes]);
    }

    /**
     * Delete A Registered Seedbox.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param                            $id
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $seedbox = Seedbox::findOrFail($id);

        abort_unless($user->group->is_modo, 403);
        $seedbox->delete();

        return redirect()->route('staff.seedboxes.index')
            ->withSuccess('Seedbox Record Has Successfully Been Deleted');
    }
}
