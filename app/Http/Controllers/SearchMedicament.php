<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gmr;

class SearchMedicament extends Controller
{
    //
    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Gmr::where('CODE_EAN13', 'like', $query . '%')
            ->orWhere('Nom_Commercial', 'like', $query . '%')
            ->get();

        return response()->json($results);
    }



}
