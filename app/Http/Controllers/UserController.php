<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    public function index(){

        $data['users'] = User::select('id','name','email','role_id','status','created_at')
            ->where('role_id','!=',1)
            ->orderBy('id','DESC')
            ->get();
        $data['count']=1;
        return view('users.user-list', $data);

    }

    public function add(){
        return view('users.user-add');
    }

    public function save(Request $request){

        if ($request->all()) {
            $this->validate($request, [
                'name'             => 'required',
                'email'            => 'required|unique:users,email',
                'role'             => 'required|not_in:0',
                'phoneno_1'        => 'required',
                'phoneno_2'        => 'required',
                'address'          =>  'required',
                'billing_address'  => 'required',
                'shipping_address' => 'required',
                //'working_hours'    =>  'required',
                'monday_timing'    =>  'required',
                'tuesday_timing'    =>  'required',
                'wednesday_timing'    =>  'required',
                'thursday_timing'    =>  'required',
                'friday_timing'    =>  'required',
                'saturday_timing'    =>  'required',
                'sunday_timing'    =>  'required',

            ]);
            DB::beginTransaction();
            try {

                $user = User::create(
                    [
                        'name'                => $request->name,
                        'email'               => $request->email,
                        'role_id'             => $request->role,
                        'status'              => $request->status,
                        'phoneno_1'           => $request->phoneno_1,
                        'phoneno_2'           => $request->phoneno_2,
                        'address'             => $request->address,
                        'billing_address'     => $request->billing_address,
                        'shipping_address'    => $request->shipping_address,
                        //'working_hours'       => $request->working_hours,
                        'monday_timing'       =>  $request->monday_timing,
                        'tuesday_timing'      =>  $request->tuesday_timing,
                        'wednesday_timing'    =>  $request->wednesday_timing,
                        'thursday_timing'     =>  $request->thursday_timing,
                        'friday_timing'       =>  $request->friday_timing,
                        'saturday_timing'     =>  $request->saturday_timing,
                        'sunday_timing'       =>  $request->sunday_timing,
                        'uuid'                => (string) Str::uuid(),
                    ]
                );
                $userDetail = User::find($user->id);
                $userUuid = $userDetail->uuid;
                $baseUrl = url("/add-password/$userUuid");




                // send email to user
                $randomString = Str::random(6);
                //check user is added or not
                if ($user->id) {
                    Mail::to($user->email)->send(new UserCreatedMail($baseUrl));
                    // add user password
//                    $newdata = [
//                        'password' => Hash::make($randomString),
//                    ];
//                    User::where('id', $user->id)->update($newdata);
                }
                DB::commit();

                return redirect('/users-list')->with('status', 'User created successfully');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/users-list')->with('status', $e);
            }

        }
    }


    public function edit($id){
        $data['user'] = User::find($id);
        return view('users.user-edit', $data);

    }

    public function update(Request $request){
        if ($request->all()) {
            $this->validate($request, [
                'name'    => 'required',
                'phoneno_1'        => 'required',
                'phoneno_2'        => 'required',
                'address'          =>  'required',
                'billing_address'  => 'required',
                'shipping_address' => 'required',
                //'working_hours'    =>  'required',
                'monday_timing'    =>  'required',
                'tuesday_timing'    =>  'required',
                'wednesday_timing'    =>  'required',
                'thursday_timing'    =>  'required',
                'friday_timing'    =>  'required',
                'saturday_timing'    =>  'required',
                'sunday_timing'    =>  'required',
            ]);
            DB::beginTransaction();
            try {
                $newdata = [
                    'name'                => $request->name,
                    'status'              => $request->status,
                    'phoneno_1'           => $request->phoneno_1,
                    'phoneno_2'           => $request->phoneno_2,
                    'address'             => $request->address,
                    'billing_address'     => $request->billing_address,
                    'shipping_address'    => $request->shipping_address,
                    //'working_hours'       => $request->working_hours,
                    'monday_timing'       =>  $request->monday_timing,
                    'tuesday_timing'      =>  $request->tuesday_timing,
                    'wednesday_timing'    =>  $request->wednesday_timing,
                    'thursday_timing'     =>  $request->thursday_timing,
                    'friday_timing'       =>  $request->friday_timing,
                    'saturday_timing'     =>  $request->saturday_timing,
                    'sunday_timing'       =>  $request->sunday_timing,

                ];
                User::where('id', $request->recordid)->update($newdata);
                DB::commit();

                return redirect('/users-list')->with('status', 'User updated successfully');
            }
            catch (\Exception $e) {
                DB::rollback();
                // Redirect to users page with an error message
                return redirect('/users-list')->with('status', $e);
            }

        }

    }

    public function changePassword($id)
    {
        $user = User::find($id);
        $userUuid = $user->uuid;
        $baseUrl = url("/add-password/$userUuid");

        //check user is found
        if ($user->id) {

            Mail::to($user->email)->send(new UserCreatedMail($baseUrl));

            return redirect('/users-list')->with('status', 'Email sent to user for password change');

        }
        return redirect('/users-list')->with('status', 'Something went wrong');

    }

    public function editProfile(){
        return view('profile.edit-profile');
    }

    public function updateProfile(Request $request){
        return redirect('/dashboard');
    }
}
