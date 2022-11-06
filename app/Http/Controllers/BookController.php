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

    public function getLatestRate($currency)
    {
        $api_layer_key = \config('global-variables.api_layer_key');
        $curl = curl_init();
        // \Log::info($api_layer_key);
        $url = implode("", ["https://api.apilayer.com/exchangerates_data/latest?symbols=PLN&base=", $currency] );
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: $api_layer_key"
          ),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $array = json_decode($response, true);
        $rates = $array['rates']['PLN'];
        return $rates;
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
