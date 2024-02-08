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
        $nbrMed = Gmr::count();
        $medRemb = Gmr::where('remb',1)->count();
        $medNonRemb = Gmr::where('remb',0)->count();
        $medAnam = Gmr::where('is_anam',1)->count();
        $medNonAnam = Gmr::where('is_anam',0)->count();
        $ordCount = Ordanance::select('num_eng', Ordanance::raw('count(*) as count'))->groupBy('num_eng')->count();


        // $HRAordCount = 0 ;

        // Ordanance::all()->groupBy("num_eng")->map(function($ordcolec) use($HRAordCount) {

        //     $nbrMedord= $ordcolec->count();


        //     $HRAordCount = $nbrMedord == $ordcolec->where("gmr.is_anam",1)->count() ? $HRAordCount++: 0 ;



        // });



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


        

        // Sort the results by the 'nombre' column in descending order
        $sortedbynbrCodeCounts = DB::table('ordanances AS o')
        ->join('gmr AS g', 'o.code', '=', 'g.CODE_EAN13')
        ->select('o.code', 'g.PPV', 'g.Nom_Commercial','g.remb','g.is_anam', DB::raw('COUNT(*) as code_count'), DB::raw('SUM(g.PPV * 1) as total'))
        ->groupBy('o.code', 'g.PPV', 'g.Nom_Commercial','g.remb','g.is_anam')
        ->orderBy('code_count', 'desc') // Sort by code_count in descending order
        ->take(10) // Limit to the top 10 records
        ->get();



        //nombre medicament in each ord
        $ordonanceCounts = DB::table('ordanances')
        ->select('num_eng','total','total_r', DB::raw('COUNT(*) as ordinance_count'))
        ->groupBy('num_eng','total','total_r')
        ->orderBy('ordinance_count', 'desc')
        ->take(5)
        ->get();






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
            'ordonanceCounts'=>$ordonanceCounts,
            'totalsByMonthYear'=>$totalsByMonthYear
        ]);
    }


}
