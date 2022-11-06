<?php

namespace App\Http\Controllers;

use App\UserSettings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        $user_settings = UserSettings::first();
        // return view('home.index',compact('user_settings'))
        //     ->with('i', (request()->input('page', 1) - 1) * 5);
        return $user_settings;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        UserSettings::create($request->all());

        return redirect()->route('home.index')
        ->with('success','Config created successfully.');
    }

    public function update(Request $request)
    {
        $values = $request->all();
        \Log::info($request);
        if($request->hasActiveNotifications != "on"){
            $values = array(
                'id' => $request->id,
                'hasActiveNotifications' => ""
           );
        }

        //  request()->validate([
        //     'hasActiveNotifications' => 'required'
        // ]);
        UserSettings::findOrFail($request->id)->update($values);

        // return redirect()->route('home.index')
        //                 ->with('success','Book updated successfully');
    }

}
