<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddMedicament extends Controller
{
    public function newMedicament(Request $request){
   
        Gmr::create([
            'CODE_EAN13' => $request->post('codeEan'),
            'Nom_Commercial' => $request->post('nomcomer'),
            'DCI' => $request->post('dmc'),
            'Dosage' => $request->post('dosage'),
            'Presentation' => $request->post('presentation'),
            'PPV' => $request->post('ppv'),
            'PBR' => $request->post('pbr'),
            'PH' => $request->post('ph'),
            'PBRH' => $request->post('pbrh'),
            'Classe' => $request->post('classe'),
            'remb' => $request->post('isremb'),
            'is_anam' => $request->post('isanam'),
        ]);

        // dd($request->post('codeEan'));
        return response()->json([
            'status' =>'success',
            'message' => 'Nouveau medicament ajouté avec succès!'
            ]
        );

    }
}
