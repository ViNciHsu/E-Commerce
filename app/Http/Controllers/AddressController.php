<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address_countys = Address::select('county')->groupBy('county')->orderBy('county')->get();
        $address_citys = Address::select('city')->groupBy('city')->orderBy('city')->get();
        $addresses = DB::table('addresses')
            ->select('address_zip', 'county', 'city', 'street')
            ->where('county', "=", '台中市')
            ->where('city', "=", '東區')
            ->get();
        $zipData = [];
        foreach ($addresses as $v){
            $zipData[] = $v->address_zip;
        }

        return view('admin',[
            'address_countys' => $address_countys,
            'address_citys' => $address_citys,
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($county = null,$city = null, Request $request)
    {
       if($county == null){
           return Address::select('county')->groupBy('country')->orderBy('county')->get();
       }else if($county != null && $city == null){
           return Address::select('county','city')->where('county','=',$county)
               ->groupBy('county','city')->orderBy('county')->orderBy('city')->get();
       }else if($county != null && $city != null){
           return Address::select('zip')->where('county','=',$county)->where('city','=',$city)->get();
       }
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
    }

    public function jsonDataCity($county = null)
    {
        $addresses = DB::table('addresses')
            ->select('address_zip', 'county', 'city', 'street')
            ->where('county', "=", $county)
            ->get();
        $cityData = [];
        foreach ($addresses as $v){
            $cityData[] = $v->city;
        }
//        dd($addresses);
        return $addresses;
    }

    public function jsonDataZip($county, $city)
    {
        $addresses = DB::table('addresses')
            ->select('address_zip', 'county', 'city', 'street')
            ->where('county', "=", $county)
            ->where('city', "=", $city)
            ->get();

        return $addresses;
    }

    // 編輯頁 根據縣市抓鄉鎮市區用的Ajax
    public function jsonDataEditCity($id, $county = null)
    {
        $addresses = DB::table('addresses')
            ->select('address_zip', 'county', 'city', 'street')
            ->where('county', "=", $county)
            ->get();
        $cityData = [];
        foreach ($addresses as $v){
            $cityData[] = $v->city;
        }
//        dd($addresses);
        return $addresses;
    }

    // 編輯頁 根據鄉鎮市區所選帶出郵遞區號用的Ajax
    public function jsonDataEditZip($id, $county = null, $city = null)
    {
        $addresses = DB::table('addresses')
            ->select('address_zip', 'county', 'city', 'street')
            ->where('county', "=", $county)
            ->where('city', "=", $city)
            ->get();
        $cityData = [];
        foreach ($addresses as $v){
            $cityData[] = $v->city;
        }
//        dd($addresses);
        return $addresses;
    }
}
