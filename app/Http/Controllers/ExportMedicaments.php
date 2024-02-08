<?php

namespace App\Http\Controllers;
use App\Models\Gmr;
use Illuminate\Http\Request;

class ExportMedicaments extends Controller
{
    //
    public function ExportMedi(Request $request){

        $mediAnamValues = $request->input('mediAnamValues');
        $medirembValues = $request->input('medirembValues');
        $nomMediValue = $request->input('nomMediValue');
        $query = Gmr::query();

        // Check mediAnamValues and add conditions
        if (in_array('1', $mediAnamValues) && in_array('0', $mediAnamValues)) {
            // Do nothing, fetch all records
        } elseif (in_array('1', $mediAnamValues)) {
            $query->where('is_anam', 1);
        } elseif (in_array('0', $mediAnamValues)) {
            $query->where('is_anam', 0);
        }
    
        // Check medirembValues and add conditions
        if (in_array('1', $medirembValues) && in_array('0', $medirembValues)) {
            // Do nothing, fetch all records
        } elseif (in_array('1', $medirembValues)) {
            $query->where('remb', 1);
        } elseif (in_array('0', $medirembValues)) {
            $query->where('remb', 0);
        }
    
        // Check nomMediValue and add condition
        if (!empty($nomMediValue)) {
            $query->where('Nom_Commercial', 'like', $nomMediValue . '%');
        }
    
        // Fetch the data
        $data = $query->get();
    
        return response()->json($data);
        //dd(response()->json($data));
}
}
