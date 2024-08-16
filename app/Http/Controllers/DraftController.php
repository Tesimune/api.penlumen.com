<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Draft;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @group Draft Endpoints
 *
 * APIs for Draft Endpoints
 */
class DraftController extends Controller
{
    /**
     * List Drafts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->drafts()->paginate(20);
    }


    /**
     * Create draft.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'content' => ['string'],
        ]);

    }


    /**
     * Show draft.
     *
     * @param  int  $id
     * @return Draft
     */
    public function show(Draft $draft)
    {
       return $draft;
    }

    /**
     * Update draft.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $lumen, Draft $draft)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'content' => ['string'],
        ]);

    }

    /**
     * Delete draft.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lumen, Draft $draft)
    {

    }
}
