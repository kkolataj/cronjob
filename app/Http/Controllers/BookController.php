<?php

namespace App\Http\Controllers;

use App\Book;
use App\UserSettings;
use Illuminate\Http\Request;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index',compact('books'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);


        Book::create($request->all());


        return redirect()->route('books.index')
                        ->with('success','Book created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show',compact('book'));
    }


    /**
     * Display the specified resource by ID.
     *
     * @param  \App\UserSettings  $userSettings
     * @return \Illuminate\Http\Response
     */
    public function showItemById($userId)
    {
        // $books = UserSettings::get(['name'])->pluck('name'); // fajnie wyciąga wartosc wszystkich elementow wedlug nazwy wlasciwosci
        $userSettings = UserSettings::where('_id', '=', $userId)->first();
        // \Log::info($userSettings);
        return $userSettings;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit',compact('book'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSettings  $userSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $values = $request->all();
        \Log::info($values);

        //  request()->validate([
        //     'hasActiveNotifications' => 'required'
        // ]);
        UserSettings::findOrFail($request->id)->update($values);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();


        return redirect()->route('books.index')
                        ->with('success','Book deleted successfully');
    }
}
