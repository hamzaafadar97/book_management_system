<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::paginate(10);
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'author' => 'required|max:50',
            'publication_date' => 'required|date',
            'description' => 'max:200',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    /**
     * Display the specified book.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Update the specified book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255',
            'author' => 'sometimes|required|max:255',
            'description' => 'sometimes|nullable|max:1000',
            'publication_date' => 'sometimes|nullable|date',
        ]);

        $book->update($validatedData);

        return response()->json($book, 200);
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
