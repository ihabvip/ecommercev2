<?php

namespace App\Http\Controllers\Admin;
use App\Admin;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use DB;
use Mail;


class AdminAuth extends Controller
{
    //
    public function login(){
        return view('admin.login');
    }
    
    public function dologin(Request $request){
        $rememberme = request('rememberme') == 1 ? true: false;
        if(admin()->attempt(['email'=>request('email'),'password'=>request('password')],$rememberme))
        {
           return redirect('admin');
         
        }else{
            $request->session()->flash('error',trans('admin.incorrect_info_login'));

            return redirect('admin/login');
        }
    }

    public function logout(){
        auth()->guard('admin')->logout();
        return redirect('admin/login');
    }

    public function forgot_password(){
        return view('admin.forgot_password');
    }

	public function forgot_password_post() {
		$admin = Admin::where('email', request('email'))->first();
		if (!empty($admin)) {
            //$token = app('auth.password.broker')->createToken($admin);
            $token = str_random(64);
			$data  = DB::table('password_resets')->insert([
					'email'      => $admin->email,
					'token'      => $token,
					'created_at' => Carbon::now(),
				]);
			//return new AdminResetPassword(['data' => $admin, 'token' => $token]);
                Mail::to($admin->email)->send(new AdminResetPassword(['data' => $admin, 'token' => $token]));
                session()->flash('success', trans('admin.the_link_reset_sent'));
                return back();
		}
		return back();
    }
    
    public function reset_password($token){
        $check_token= DB::table('password_resets')
        ->where('token',$token)
        ->where('created_at','>',Carbon::now()->subHours(2))
        ->first();
        //return dd($check_token);
        if(!empty($check_token)){

            return view('admin.reset_password',['data'=>$check_token]);
        }else{
            return redirect('forgot/password');
        }
    }

    public function reset_password_post($token){
        //return request();
        $this->validate(request(),[
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ],[],[
                'password'=>'Password',
                'password_confirmation'=> 'Confirmation Password',

        ]);
        $check_token= DB::table('password_resets')
        ->where('token',$token)
        ->where('created_at','>',Carbon::now()->subHours(2))
        ->first();

        //return dd($check_token);
        if(!empty($check_token)){

           $admin = admin::where('email',$check_token->email)
           ->update([
               'password'=>bcrypt(request('password'))
               ]);

            $check_token= DB::table('password_resets')
               ->where('email',request('email'))->delete();
               admin()->attempt(['email'=>$check_token->email,'password'=>request('password')],true);
               return redirect(aurl());

        }else{
            return redirect(aurl('forgot/password'));
        }        
    }
}
