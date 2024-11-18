<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Userauth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //Registration
    public function registration()
    {
        return view('auth.registration');
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email:userauth',
            'password'=>'required|min:6|max:12'
        ]);

        $user = new Userauth();
        $user->user_fullname = $request->name;
        $user->user_email = $request->email;
        $user->user_status = 0;
        $user->password = Hash::make($request->password);

        $result = $user->save();
        if($result){
            return back()->with('success','You have registered successfully.');
        } else {
            return back()->with('fail','Something wrong with passowrd or email!');
        }
    }
    ////Login
    public function login()
    {
        return view('auth.login');
    }
    public function loginUser(Request $request)
    {
        $request->validate([            
            'email'=>'required|email:users',
            'password'=>'required|min:8|max:12'
        ]);

        $user = Userauth::where('user_email','=',$request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put('loginId', $user->user_id);
                return redirect('dashboard');
            } else {
                return back()->with('fail','Password not match!');
            }
        } else {
            return back()->with('fail','This email is not register.');
        }        
    }
    //// Dashboard
    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = Userauth::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->user_id.'" id ="task_add" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" data-id="'.$row->user_id.'" id ="task_dell" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // return "Welcome to your dashabord.";
        $data = array();
        if(Session::has('loginId')){
            $data = Userauth::where('user_id','=',Session::get('loginId'))->first();
        }
        return view('dashboard',compact('data'));
    }
    ///Logout
    public function logout()
    {
        $data = array();
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }

    public function user_new(Request $request)
    {
        if ($request->ajax()) {
        $user = new Userauth();
        $user->user_fullname = $request->name;
        $user->user_email = $request->email;
        $user->user_status = 0;
        $user->password = Hash::make($request->password);
        return response()->json(['data' => 'Ok', 200]);
        } 
    }
    
    
    public function user_edit(Request $request)
    {
        if ($request->ajax()) {

            $users = DB::table('user_auth')
            ->select('*')
            ->where('user_id',$request->id);

            
            return response()->json(['data' => $users->get(), 200]);
        }    
    } 

    public function user_delete(Request $request)
    {
        if ($request->ajax()) {
       
            Userauth::where('user_id', $request->id)->delete();
            
            return response()->json(['data' =>'Ok', 200]);
        }    
    }     
    
    public function user_update(Request $request)
    {
        if ($request->ajax()) {

            Userauth::where('user_id', $request->id)
             ->update([
                    'user_fullname' => $request->name,
                    'user_email' => $request->email,
                    'user_status' => $request->status,
             ]);

            return response()->json(['data' => $request->id, 200]);
        }    
    }      
    
}