<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function editProfile(){
        $data['userProfile'] = User::find(Auth::user()->id);
        return view('profile.edit-profile', $data);
    }

    public function updateProfile(Request $request){

        if ($request->all()) {
            $this->validate($request, [
                'name'             => 'required',
                'user_image'        => 'nullable|mimes:jpeg,jpg,png,gif',
                'password'         => ['nullable', 'confirmed', Rules\Password::defaults()],

            ]);
            $oldDetail = User::find(Auth::user()->id);
            DB::beginTransaction();
            try {
                #----------- inverter image----------------------#
                if ($request->file('user_image')) {
                    $image = $request->file('user_image');
                    // Get the original filename and replace spaces with underscores
                    $originalName = $image->getClientOriginalName();
                    $sanitizedImageName = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
                    $extension = $image->getClientOriginalExtension();

                    // Combine the sanitized name with the current time and file extension for uniqueness
                    $userImageName = $sanitizedImageName . '_' . time() . '.' . $extension;
                    $image->move(public_path('files/profilepics'), $userImageName);

                }
                else{
                    $userImageName =$request->old_image;
                }

                if($request->password){
                    $newPassword = Hash::make($request->password);
                }
                else{
                    $newPassword = $oldDetail->password;
                }
                $newdata = [
                    'name'                => $request->name,
                    'phoneno_1'           => $request->phoneno_1,
                    'phoneno_2'           => $request->phoneno_2,
                    'address'             => $request->address,
                    'billing_address'     => $request->billing_address,
                    'shipping_address'    => $request->shipping_address,
                    'profile_pic'         => $userImageName,
                    'password'            => $newPassword

                ];
                User::where('id', Auth::user()->id)->update($newdata);
                DB::commit();

                return redirect('/edit-profile')->with('status', 'Profile updated successfully');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/edit-profile')->with('status', $e);
            }

        }

        return redirect('/dashboard');
    }
}
