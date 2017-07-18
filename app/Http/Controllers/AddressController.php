<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\City;
class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $addresses=Address::all();
        return view('admin.addresses.index')->withaddresses($addresses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cis=City::all();
        $cities=[];
        foreach ($cis as $ci) {
            # code...
            $cities[$ci->id]=$ci->city;
        }
        return view('admin.addresses.create')->withCities($cities);
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
        $address=new Address;
        $address->city_id=$request->city_id;
        $address->name=$request->name;
        $address->name_ar=$request->name_ar;
        $address->save();

        return redirect('adminpanel/addresses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cis=City::all();
        $cities=[];
        foreach ($cis as $ci) {
            # code...
            $cities[$ci->id]=$ci->city;
        }
        $address=address::find($id);
        return view('admin.addresses.edit')
        ->withCities($cities)
        ->withaddress($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $address=Address::findOrFail($id);
        $address->city_id=$request->city_id;
        $address->name=$request->name;
         $address->name_ar=$request->name_ar;
        $address->save();

        return redirect('adminpanel/addresses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $address=Address::findOrFail($id);
        $address->delete();
                return redirect('adminpanel/addresses');

    }
}
