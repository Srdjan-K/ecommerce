<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;      // QUERY BUILDER
use App\Models\Administrator;
use App\Models\Store;


class UserAuthController extends Controller
{
    function login(){
        return view('auth.login');
    }

    function register(){
        return view('auth.register');
    }

    function create_new_user(Request $request){
        
        // validation data from FORM
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:administrators',
            'password'=>'required|min:5|max:12'
            
        ]);
        

        $new_administrator = new Administrator;
        $new_administrator->name = $request->name;
        $new_administrator->email = $request->email;
        $new_administrator->password = Hash::make($request->password);

        $query = $new_administrator->save();


        // QUERY BUILDER
        // $query = DB::table('administrators')->insert([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'password'=>Hash::make($request->password)
        // ]);



        if($query){
            return back()->with('success','USPESNO registrovan administrator ! ');
        }else{
            return back()->with('fail','Administrator NIJE registrovan . Nesto je otislo po zlu ... ');
        }

        // return $request->input();

    }


    function check_login(Request $request){

        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
            
        ]);
        

        $current_administrator = Administrator::where('email','=',$request->email)->first();
        
        // QUERY BUILDER
        // $current_administrator = DB::table('administrators')->where('email',$request->email)->first();


        if( $current_administrator ){
            
            if( Hash::check($request->password, $current_administrator->password) ){

                $request->session()->put('LOGGED_ADMIN', $current_administrator->id);

                return redirect('profile');

            }else{
                $response_text = "Administrator postoji, ali ste uneli neispravnu sifru ... ";
                return back()->with('fail',$response_text);
            }


        }else{
            $response_text = "Nema administratora sa datim email-om : " . $request->email . " , u bazi ... ";
            return back()->with('fail',$response_text);
        }


        // return $request->input();

    }


    function profile(){
        
        if( session()->has("LOGGED_ADMIN") ){
            $current_administrator = Administrator::where( 'id', '=', session("LOGGED_ADMIN") )->first();
            
            // QUERY BUILDER
            // $current_administrator = DB::table('administrators')->where('id', session('LOGGED_ADMIN') )->first();
           
            $data = [
                'LOGGED_ADMIN_INFO' => $current_administrator
            ];

            return view("admin.profile", compact('data'));

        }
        
        // else{
            
        //     return redirect('login');

        // }
        
    
    }



    
    function logout(){
        if( session()->has('LOGGED_ADMIN') ){
            session()->pull('LOGGED_ADMIN');
            return redirect('login');
        }
    }



}   
