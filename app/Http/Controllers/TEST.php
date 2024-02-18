<?php

use Illuminate\Support\Facades\Cache;

class DashbaordController extends Controller
{
    public function dashdata()
    {
        // Check if data is already in the current cache
        $currentData = Cache::get('dashboard_data');

        // Check if data is already in the update cache
        $updateData = Cache::get('dashboard_data_update');

        // If data is in the update cache, compare and update the current cache
        if ($updateData && $currentData !== $updateData) {
            // Update the current cache with the new data
            Cache::put('dashboard_data', $updateData, now()->addMinutes(5));
            // Clear the update cache
            Cache::forget('dashboard_data_update');
            // Redirect to force a refresh and avoid resubmission of the form
            return redirect()->route('dashboard');
        }

        // If data is in the current cache, return the cached data
        if ($currentData) {
            return view('dashboard', $currentData);
        }

        // If data is not in the cache, perform the queries
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

        // Store the result in the update cache for comparison
        Cache::put('dashboard_data_update', [
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
        ], now()->addMinutes(5));

        // Store the result in the current cache
        Cache::put('dashboard_data', [
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
        ], now()->addMinutes(5));

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
