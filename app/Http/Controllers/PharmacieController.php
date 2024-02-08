<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use Illuminate\Http\Request;
 

class PharmacieController extends Controller
{
    public function index(Request $request){

        $num = session()->pull('num')[0];

        return view("pharmacie",["num"=>$num]);
    }


    public function fetchByNum(Request $request){
       $gmr =  Gmr::where('CODE_EAN13',$request->post('barcode'))->firstOrFail();
       
       return $gmr?->toJson(JSON_PRETTY_PRINT);
       
    }
public function checkNum(Request $request) {

    $rules = [
        'num' => 'required|max:7|min:7',
    ];

    $customMessages = [
        'num.min' => "Le champ Num d'enregistrement doit comporter au moins 7 caractères.",
        'num.max' => "Le champ Num d'enregistrement  ne doit pas dépasser 7 caractères.",
    ];
   
    $this->validate($request, $rules, $customMessages);
    
    session()->push('num',$request->input('num'));


    return redirect()->route('phar');

    
}

}
