<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class LibrayController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('ISBN')) {
            $query->where('ISBN', '=', $request->ISBN);
        }

        if ($request->has('is_available')) {
            $isAvailable = filter_var($request->is_available, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_available', '=', $isAvailable);
        }

        $books = $query->paginate(15);
        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }
}
