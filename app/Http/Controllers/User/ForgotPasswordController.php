<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordForm(){
        return view('user.forgot-password');
    }

    public function doForgotPasswordForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ],[
            'email.required' => 'Email harus di isi',
            'email.email' => 'Format email tidak Valid',
            'email.exists' => 'Email yang anda masukkan tidak terdaftar',
        ]);

        // Hapus Email lama di forgot password_reset_tokens
        UserVerify::where('email',$request->input('email'))->delete();

        $token = Str::uuid();
        $data = [
            'email' => $request->input('email'),
            'token' => $token
        ];

        UserVerify::create($data);
        Mail::send('user.email-reset-password',['token'=>$token],function($message) use ($request){
            $message->to($request->input('email'));
            $message->subject('Reset Password');
        });

        return redirect()->route('forgotpassword')->with('success','Instruksi Reset Password sudah di kirim ke Email anda!')->withInput();

    }

    public function resetPassword($token){
        $data =[
            'token' => $token
        ];
        return view('user.reset-password',$data);
    }

    public function doResetPassword(Request $request){
        $request->validate(
            [
                'password' => 'required|string|min:6',
                'password-confirm' => 'required_with:password|same:password'
            ],
            [
                'password.required' => 'Password harus diisi',
                'password.string' => 'Password wajib String',
                'password.min' => 'Minimal untuk Password adalah 6 karakter',
                'password-confirm.required_with' => 'Password Konfirmasi wajib diisi',
                'password-confirm.same' => 'Password Konfirmasi tidak sama dengan password yang di masukkan'
            ]
        );
        $dataUser = UserVerify::where('token',$request->input('token'))->first();
        if(!$dataUser){
            return redirect()->back()->withInput()->withErrors('Token tidak Valid');
        }

        $email = $dataUser->email;
        $data = [
            'password' => bcrypt($request->input('password')),
            'email_verified_at' => Carbon::now()
        ];

        User::where('email',$email)->update($data);
        UserVerify::where('email',$email)->delete();
        return redirect()->route('login')->with('success','Password sudah berganti, Silakan Login menggunakan Password baru anda');
    }


}
