<?php

namespace App\Http\Controllers;

use App\Models\Gmr;
use App\Models\Ordanance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class DashbaordController extends Controller
{
    public function dashdata(){
        $nbrMed = Gmr::all()->count();
        $medRemb = Gmr::where('remb',1)->get()->count();
        $medNonRemb = Gmr::where('remb',0)->get()->count();
        $medAnam = Gmr::where('is_anam',1)->get()->count();
        $medNonAnam = Gmr::where('is_anam',0)->get()->count();
        $ordCount = Ordanance::select('num_eng', Ordanance::raw('count(*) as count'))->groupBy('num_eng')->get()->count();


        $HRAordCount =  DB::select("
        SELECT COUNT(*) as result_count
        FROM (
            SELECT q1.num_eng, q1.count_code as count_code_query1, q2.count_code as count_code_query2
            FROM (
                SELECT ordanances.num_eng, COUNT(ordanances.code) as count_code
                FROM `ordanances`
                JOIN gmr ON ordanances.code = gmr.CODE_EAN13
                WHERE gmr.is_anam = 1
                GROUP BY ordanances.num_eng
            ) q1
            JOIN (
                SELECT ordanances.num_eng, COUNT(ordanances.code) as count_code
                FROM `ordanances`
                JOIN gmr ON ordanances.code = gmr.CODE_EAN13
                GROUP BY ordanances.num_eng
            ) q2 ON q1.num_eng = q2.num_eng AND q1.count_code = q2.count_code
        ) AS result_table
    ")[0]->result_count;

        $ANAMordCount = DB::select("
        SELECT COUNT(*) as result_count
        FROM (
            SELECT q1.num_eng, q1.count_code as count_code_query1, q2.count_code as count_code_query2
            FROM (
                SELECT ordanances.num_eng, COUNT(ordanances.code) as count_code
                FROM `ordanances`
                JOIN gmr ON ordanances.code = gmr.CODE_EAN13
                WHERE gmr.is_anam = 0
                GROUP BY ordanances.num_eng
            ) q1
            JOIN (
                SELECT ordanances.num_eng, COUNT(ordanances.code) as count_code
                FROM `ordanances`
                JOIN gmr ON ordanances.code = gmr.CODE_EAN13
                GROUP BY ordanances.num_eng
            ) q2 ON q1.num_eng = q2.num_eng AND q1.count_code = q2.count_code
        ) AS result_table
    ")[0]->result_count;



        
        $totalsByNumEng = DB::table('ordanances')
        ->select('num_eng', 'total')
        ->distinct()
        ->get();
        $ordSum = $totalsByNumEng->sum('total');

        // $medNoRem = DB::table('ordanances AS o')
        // ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        // ->select('o.code', 'g.PPV')
        // ->where('g.remb', 0)
        // ->get();
        // $medNoRem = $medNoRem->sum('PPV');


        // $medRem = DB::table('ordanances AS o')
        // ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        // ->select('o.code', 'g.PPV')
        // ->where('g.remb', 0)
        // ->get();
        // $medRem = $medRem->sum('PPV');

        // $userCountByNumEng = Ordanance::select('user_id', Ordanance::raw('COUNT(DISTINCT num_eng) as num_eng_count'))
        // ->groupBy('user_id')
        // ->get();


        $userCountByNumEng = Ordanance::select('ordanances.user_id', 'users.name','users.mle', Ordanance::raw('COUNT(DISTINCT ordanances.num_eng) as num_eng_count'))
        ->join('users', 'ordanances.user_id', '=', 'users.id')
        ->groupBy('ordanances.user_id', 'users.name', 'users.mle')
        ->get();

    

        $userCounts = Ordanance::select(
            'users.mle as Matricule',
            'users.name as Nom',
            DB::raw('COUNT(DISTINCT ordanances.num_eng) as Nombre_d_ordonnances'),
            DB::raw('COUNT(DISTINCT CASE WHEN DATE(ordanances.created_at) = CURDATE() THEN ordanances.num_eng END) as Nombre_d_Aujourd_hui')
        )
        ->join('users', 'ordanances.user_id', '=', 'users.id')
        ->groupBy('users.mle', 'users.name')
        ->get();
        // $codeCounts = DB::table('ordanances')
        // ->select('code', DB::raw('COUNT(*) as code_count'))
        // ->groupBy('code')
        // ->get();



        // $codeCountsAndTotal = DB::table('ordanances AS o')
        // ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        // ->select('o.code', 'g.Nom_Commercial', DB::raw('COUNT(*) as code_count'), DB::raw('SUM(g.PPV * 1) as total'))
        // ->groupBy('o.code','g.Nom_Commercial')
        // ->get();


        $AnamTotal = DB::table('ordanances AS o')
        ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        ->select('o.code', 'g.Nom_Commercial', DB::raw('COUNT(*) as code_count'), DB::raw('SUM(g.PPV * 1) as total'))
        ->where('is_anam',1)
        ->groupBy('o.code','g.Nom_Commercial')
        ->get()->sum('total');

        $HorsAnamTotal = DB::table('ordanances AS o')
        ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        ->select('o.code', 'g.Nom_Commercial', DB::raw('COUNT(*) as code_count'), DB::raw('SUM(g.PPV * 1) as total'))
        ->where('is_anam',0)
        ->groupBy('o.code','g.Nom_Commercial')
        ->get()->sum('total');

        $MNRTotal = DB::table('ordanances AS o')
        ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        ->select('o.code', 'g.Nom_Commercial', DB::raw('COUNT(*) as code_count'), DB::raw('SUM(g.PPV * 1) as total'))
        ->where('remb',0)
        ->groupBy('o.code','g.Nom_Commercial')
        ->get()->sum('total');
        //dd($MNRTotal);

        // dd($codeCountsAndTotal);
        // Sort the results by the 'total' column in descending order
        // $sortedCodeCounts = $codeCountsAndTotal->sortByDesc('total');
        
 
        // Get the code with the maximum total
        // $codeWithMaxTotal = $sortedCodeCounts->first();
        

        // Sort the results by the 'nombre' column in descending order
        $sortedbynbrCodeCounts = DB::table('ordanances AS o')
        ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        ->select('o.code', 'g.PPV', 'g.Nom_Commercial','g.remb','g.is_anam', DB::raw('COUNT(*) as code_count'), DB::raw('SUM(g.PPV * 1) as total'))
        ->groupBy('o.code', 'g.PPV', 'g.Nom_Commercial','g.remb','g.is_anam')
        ->orderBy('code_count', 'desc') // Sort by code_count in descending order
        ->take(10) // Limit to the top 10 records
        ->get();






        //nombre medicament and Boite in each ord
        $ordonanceMediandBoiteCounts = DB::table('ordanances')
        ->select('num_eng','total_r', DB::raw('COUNT(*) as ordinance_count'), DB::raw('COUNT(DISTINCT code) as medicament_count'))
        ->groupBy('num_eng','total_r')
        ->orderByDesc('medicament_count')
        ->limit(5)
        ->get();

        $ordonancesTopTotal = DB::table('ordanances')
        ->select('num_eng', 'total', 'total_r')
        ->groupBy('num_eng', 'total', 'total_r')
        ->orderByDesc('total')
        ->limit(5)
        ->get();
    


        // $totalsByNumEngType = DB::table('ordanances')
        // ->select('ordanances.num_eng', 'ordanances.total')
        // ->distinct()
        // ->join('gmr', 'ordanances.code', '=', 'gmr.CODE_EAN13')
        // ->where('gmr.is_anam', '=', 1) // Assuming is_anam is a boolean column
        // ->get();

        // $ordSumANAM = $totalsByNumEng->sum('total');
    //dd($ordSumANAM);

    $totalsByMonthYear = DB::table('ordanances')
    ->select(
        DB::raw('YEAR(ordanances.updated_at) AS ord_year'),
        DB::raw('MONTH(ordanances.updated_at) AS ord_month'),
        DB::raw('SUM(total) AS TOTAL'),
        DB::raw('SUM(CASE WHEN remb = 0 THEN total ELSE 0 END) AS MNR'),
        DB::raw('SUM(CASE WHEN remb = 1 THEN total ELSE 0 END) AS MR')
    )
    ->join('gmr', 'ordanances.code', '=', 'gmr.CODE_EAN13')
    ->groupBy('ord_year', 'ord_month')
    ->get();
//dd($totalsByMonthYear);
    

        return view('dashboard', [
            'nbrMed'=> $nbrMed,
            'medRemb'=> $medRemb,
            'medNonRemb'=> $medNonRemb,
            'ordCount'=> $ordCount,
            'ordSum'=>$ordSum,
            'MNRTotal'=>$MNRTotal,
            'medAnam'=>$medAnam,
            'medNonAnam'=>$medNonAnam,
            'sortedbynbrCodeCounts'=>$sortedbynbrCodeCounts,
            'AnamTotal'=>$AnamTotal,
            'HorsAnamTotal'=>$HorsAnamTotal,
            'userCountByNumEng'=>$userCountByNumEng,
            'userCounts'=>$userCounts,
            'HRAordCount'=>$HRAordCount,
            'ANAMordCount'=>$ANAMordCount,
            'ordonanceMediandBoiteCounts'=>$ordonanceMediandBoiteCounts,
            'totalsByMonthYear'=>$totalsByMonthYear,
            'ordonancesTopTotal'=>$ordonancesTopTotal
        ]);
    }


// --------------------with cache---------------------------------

}
