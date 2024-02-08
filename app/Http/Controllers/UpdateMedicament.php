<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use Illuminate\Http\Request;

class UpdateMedicament extends Controller
{
     public function updateMed(Request $request){
      $codeEan = $request->post('codeEan');
      $mediUp = Gmr::where("CODE_EAN13","$codeEan")->first();
  
        return $mediUp;
     }



     public function Update(Request $request){
      $ID = $request->post('id');
      Gmr::where('id', $ID)->update([
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
      // dd($ID);

      return response()->json([
         'status' =>'success',
         'message' => 'Medicament modifiér avec succès!'
         ]
     );
     }
}
