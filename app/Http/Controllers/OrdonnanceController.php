<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use App\Models\Ordanance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdonnanceController extends Controller
{
        public function new( Request $request) {

            $user = Auth::user();

            $ords = $request->post("ord");
            // $medlist = collect($ords)->map(function(string $ord){
            //     $code = Gmr::where("CODE_EAN13", $ord)->first()->Nom_Commercial;
            //     return ["$ord"=>$code];
            // })->toArray();
            $medlist = collect($ords)->each(function(string $ord) use ($request, $user) {

                $ord = Ordanance::create([
                    //'code' => $request->post('ord') ,
                    'code' =>  $ord ,
                    'num_eng' => $request->post('num_eng') ,
                    'total' => $request->post('total_ppv') ,
                    'total_r' => $request->post('total_res') ,
                ]);
                
                
                $ord->user()->associate($user);
                $ord->saveOrFail();
            });

         //dd($medlist);

        // dd($user);

            //dd($request->all());
 
            return redirect()->route('num');
        }
}
