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

        //return response()->json(['exportdata' => $data]);
     
       
    }
}
