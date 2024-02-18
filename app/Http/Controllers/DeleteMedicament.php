<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use Illuminate\Http\Request;

class DeleteMedicament extends Controller
{
    public function delMedicament(Request $request){
        $codeEan = $request->post('codeEan');
        // dd($request->all());
        Gmr::where('CODE_EAN13', $codeEan)->delete();
        return response()->json([
            'status' =>'success',
            'message' => 'Medicament supprimé avec succès!'
            ]
        );
    }
    

}
