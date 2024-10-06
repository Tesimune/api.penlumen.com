<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Branch;
use App\Models\Draft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @group Branch Endpoints
 *
 * APIs for Branch Endpoints
 */
class BranchController extends Controller
{
    /**
     * Create branch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lumen, Draft $draft)
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
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'content' => ['nullable'],
        ]);

        $user = auth()->user();

        $title = $validated['title'];
        $counter = 1;
        $originalTitle = $title;

        while (Branch::where('title', $title)->exists()) {
            $title = $originalTitle . ' (' . $counter++ . ')';
        }

        $slug = strtolower(str_replace(' ', '_', $validated['title']));
        $baseSlug = $slug;
        $counter = 1;
        while (Draft::where('slug', $slug)->where('user_uuid', $user->uuid)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }

        $branch = Branch::create([
            'uuid' => Str::uuid(),
            'slug' => $slug,
            'user_uuid' => $user->uuid,
            'draft_uuid' => $draft->uuid,
            'title' => $title,
            'content' => $validated['content'],
        ]);
        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "branch" => $branch,
            ]
        ]);
    }


    /**
     * Show branch.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lumen, Draft $draft, Branch $branch)
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
        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "branch" => $branch,
            ]
        ]);
    }


    /**
     * Update branch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $lumen, Draft $draft, Branch $branch)
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
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'content' => ['string'],
        ]);

        $user = auth()->user();

        $slug = strtolower(str_replace(' ', '_', $validated['title']));
        $baseSlug = $slug;
        $counter = 1;

        while (Branch::where('slug', $slug)->where('user_uuid', $user->uuid)->where('draft_uuid', $branch->uuid)->exists()) {
            $slug = $baseSlug . '_' . $counter;
            $counter++;
        }

        $branch->title = $validated['title'];
        $branch->content = $validated['content'];
        $branch->slug = $slug;
        $branch->save();

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "branch" => $branch,
            ]
        ]);
    }

    /**
     * Delete branch.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lumen, Draft $draft, Branch $branch)
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
        $branch->delete();

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
