<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class GeneralController extends Controller
{
    public function addPassword($uuid){

        $data['user'] = User::where('uuid',$uuid)->first();
        if($data['user']){
            return view('users.general.create-password',$data);
        }
        else{
            return redirect('/')->with('status', 'Request do not exist');

        }

    }

    public function savePassword(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'password' => ['required', 'confirmed', Rules\Password::defaults()],

            ]);
            DB::beginTransaction();
            try {
                $newdata = [
                    'password'   => Hash::make($request->password),


                ];
                User::where('uuid', $request->recordid)->update($newdata);

                // change uuid of user so that page cannot be accessed once password is added
                $newdata = [
                    'uuid'   => (string) Str::uuid(),


                ];
                User::where('uuid', $request->recordid)->update($newdata);
                DB::commit();

                return redirect('/')->with('status', 'Please Login');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/add-password/'.$request->recordid)->with('status', $e);
            }
        }
    }
}
