<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use App\Models\Ordanance;
use App\Models\User;


use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportdata(Request $request){

        //User::where('id', '1')->first();
        $data = Ordanance::all()->map(function(Ordanance $ordanance){
        $gmr = Gmr::where("CODE_EAN13", $ordanance->code)->first(["Nom_Commercial", "PPV"]);
        
        return [
            "ord" => $ordanance,
            "gmr" => $gmr
        ];
        });


        return view('exportdata', ['exportdata' => $data]);
        // $data = DB::table('ordanances')->get();
        // foreach ($data as $item) {
        //     $user_id = $item->user_id;
        //     // Do something with the $user_id here (e.g., print, store, or manipulate).
        //     echo $user_id . PHP_EOL;
        // }
        // Fetch all 'ean' numbers from the 'ordanances' table
        // $eanNumbers = DB::table('ordanances')->pluck('code');

        // //dd($eanNumbers);

     
       
    }
}
