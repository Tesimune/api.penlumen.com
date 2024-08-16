<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
       return response()->json(
           $request->user()->books()->get()
       );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated["uuid"] = Str::uuid();
        $validated["user_id"] = $request->user()->id;

        if ($request->hasFile("cover")){
            $validated["cover"] = $request->file("cover")->store("uploads/cover");
        }

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile("cover")){
            $validated["cover"] = $request->file("cover")->store("uploads/cover");
        }

        $book->update($validated);

        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book): JsonResponse
    {
        if ($request->user()->can("delete", $book)){
            $book->delete();
            return response()->json(null, 204);
        }
        return response()->json(["message" => "Unauthorized"], 403);
    }
}
