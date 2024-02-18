<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

    class UserListes extends Controller
    {
        //
        public function getUserList(Request $request){
            $GetallUser = User::all();
            // return $GetallUser;

            return view('utilisateur', ['Users' => $GetallUser]);
        }

        public function DeleteUser($id)
        {
        
            try {
                $user = User::findOrFail($id);
                $user->delete();
    
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        }

        public function resetPassword($id)
        {
            try {
                $user = User::find($id);
    
                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'User not found.']);
                }
    
                // Generate a new random password
                $newPassword = User::where('id', $id)->value('mle');
            

                // Update the user's password
                $user->password = Hash::make($newPassword);
                $user->save();
    
                return response()->json(['success' => true, 'message' => 'Password reset successfully.', 'newPassword' => $newPassword]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'An error occurred while resetting the password.']);
            }
        }
    }
        
    
