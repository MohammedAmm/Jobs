<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Worker;
use Auth;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'rate'=> ['required', 'integer', 'between:1,5'],
            ]);
        $id = $request->id;
        $rate = $request->rate;
        $worker = Worker::where('user_id', $id)->first();
        if ($worker) {
            $rating = Rating::where('user_id', Auth::user()->id)->where('worker_id', $id)->first();
            if (!$rating) {
                $rating = new Rating;
                $rating->user_id = Auth::user()->id;
                $rating->worker_id = $id;
                $rating->ratings = $rate;
                $rating->save();
                $worker->rate=$worker->averageRating();
                $worker->no_rates=$worker->totalRatings();
                $worker->save();
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
