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
    public function index($lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }

        $drafts = Draft::where("user_uuid", $user->uuid)->latest()->paginate(20);
        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "drafts" => $drafts
            ]
        ]);
    }

   
    /**
     * Create draft.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lumen)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'content' => ['string'],
        ]);

        $user = Auth::user();
        $title = $validated['title'];
        $counter = 1;
        $originalTitle = $title;

        while ($user->draft->where('title', $title)->exists()) {
            $title = $originalTitle . ' (' . $counter++ . ')';
        }

        $slug = strtolower(str_replace(' ', '_', $validated['title']));
        $baseSlug = $slug;
        $counter = 1;
        while (Draft::where('slug', $slug)->where('user_uuid', $user->uuid)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }

        $draft = Draft::create([
            'uuid' => Str::uuid(),
            'slug' => $slug,
            'user_uuid' => $user->uuid,
            'title' => $title,
            'content' => $validated['content'],
        ]);

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "draft" => $draft
            ]
        ]);
    }


    /**
     * Show draft.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lumen, Draft $draft)
    {
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }elseif($draft->user_uuid !== $user->uuid){
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "draft" => $draft->load('branch')
            ]
        ]);
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
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ], 419);
        } elseif (!$draft) {
            return response()->json([
                "status" => 404,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ], 404);
        } elseif ($draft->user_uuid !== $user->uuid) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ], 419);
        }
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'content' => ['string'],
        ]);
        $user = auth()->user();

        $slug = strtolower(str_replace(' ', '_', $validated['title']));
        $baseSlug = $slug;
        $counter = 1;
        while (Draft::where('slug', $slug)->where('user_uuid', $user->uuid)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }

        $draft->title = $validated['title'];
        $draft->content = $validated['content'];
        $draft->slug = $slug;
        $draft->save();

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "drafts" => $draft->branch
            ]
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
        $user = Auth::user();
        if ($lumen !== $user->username) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        } elseif ($draft->user_uuid !== $user->uuid) {
            return response()->json([
                "status" => 419,
                "success" => false,
                "message" => "Unauthorized",
                "data" => [
                    "message" => "Unauthorized",
                ]
            ]);
        }
        $branches = Branch::where('uuid', $draft->uuid)->get();
        foreach ($branches as $branch) {
            $branch->delete();
        }

        $draft->delete();
        
        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
            ]
        ]);
    }
}
