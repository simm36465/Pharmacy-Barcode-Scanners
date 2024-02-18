<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        try {

            $user = auth()->user();

            if (auth()->check()) {
                $forbidenroutes = [
                /* standard */   
                'acc_type_0' => ['updatemedicament', 'deletemedicament',"profile.destroy",'register','exportmedidata','exportdata','dashboard','utilisateur','addmedicament'],
                /* Superviseur */ 
                'acc_type_1' => ['exportmedidata', 'updatemedicament', 'deletemedicament','register','utilisateur'],
                ];
        
                $allowedRoutesForAccType = $forbidenroutes['acc_type_' . $user->acc_type] ?? [];
                $currentRouteName = $request->route()->getName();
               
        

                switch($user->acc_type) {

                    case 0:
                    case 1:
                         return in_array($currentRouteName, $allowedRoutesForAccType)? redirect()->route('num') : $next($request); // Unauthorized
                    case 2:
                        break;
                           

                }
            } 

            //code...
        } catch (\Exception $th) {
            abort('403');
        }
        


         return $next($request); 

        
        
      
    }
}
