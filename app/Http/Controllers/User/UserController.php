<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function login(){
        return view('user.login');
    }

    function doLogin(Request $request){
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($data)){
            if(Auth::user()->email_verified_at == ''){
                Auth::logout();
                return redirect()->route('login')->withErrors('Email Belum terverifikasi. Silakan Cek email anda kembali.')->withInput();
            }else{
                return redirect()
                ->route('todo');
            }
        }
        else{
            return redirect()
            ->route('login')
            ->withErrors('Username or password not Correct')
            ->withInput();
        }

    }

    function register() {
        return view('user.register');
    }

    function doRegister(Request $request){
        $request->validate(
            [
                'email' => 'required|string|email:rfc,dns|max:100|unique:users,email',
                'name' => 'required|min:3|max:25',
                'password' => 'required|string|min:6',
                'password-confirm' => 'required_with:password|same:password'
            ],
            [
                'email.required' => 'Email harus di isi',
                'email.string' => 'Email harus dalam tipe String',
                'email.email' => 'Format email harus valid',
                'email.max' => 'Maksimum karakter untuk email adalah 100 karakter',
                'email.unique'=> 'Nama email yang kamu masukkan sudah di gunakan',
                'name.required' => 'Nama Wajib Diisi',
                'name.min' => 'Minimal karakter untuk nama adalah 3 Karakter',
                'name.max' => 'Maksimal karakter untuk nama adalah 25 karakter',
                'password.required' => 'Password harus diisi',
                'password.string' => 'Password wajib String',
                'password.min' => 'Minimal untuk Password adalah 6 karakter',
                'password-confirm.required_with' => 'Password Konfirmasi wajib diisi',
                'password-confirm.same' => 'Password Konfirmasi tidak sama dengan password yang di masukkan'
            ]
        );

        $data = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ];

        User::create($data);
        $cekToken = UserVerify::where('email',$request->input('email'))->first();
        if($cekToken){
            UserVerify::where('email',$request->input('email'))->delete();
        }
        $token = Str::uuid();
        $data=[
            'email' => $request->input('email'),
            'token' => $token
        ];

        UserVerify::create($data);

        Mail::send('user.email-verification',['token'=>$token],function($message) use ($request){
            $message->to($request->input('email'));
            $message->subject('Email verification');
        });

        return redirect()->route('register')->with('success','Email Verifikasi telah di kirimkan Silakan cek terlebih dahulu')->withInput();
    }

    function updateData() {
        return view('user.update-data');
    }

    function doUpdateData(Request $request){
        $request->validate(
            [
                'name' => 'required|min:3|max:25',
                'password' => 'nullable|string|min:6',
                'password-confirm' => 'required_with:password|same:password'
            ],
            [
                'name.required' => 'Nama Wajib Diisi',
                'name.min' => 'Minimal karakter untuk nama adalah 3 Karakter',
                'name.max' => 'Maksimal karakter untuk nama adalah 25 karakter',
                'password.string' => 'Password wajib String',
                'password.min' => 'Minimal untuk Password adalah 6 karakter',
                'password-confirm.required_with' => 'Password Konfirmasi wajib diisi',
                'password-confirm.same' => 'Password Konfirmasi tidak sama dengan password yang di masukkan'
            ]
        );
        $data = [
            'name' => $request->input('name'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : Auth::user()->password,
        ];

        User::where('id',Auth::user()->id)->update($data);

        return redirect()->route('user.updateData')->with('success','Data berhasil di ubah');
    }

    function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    function verifyAccount($token){
        $cekUser = UserVerify::where('token',$token)->first();
        if(!is_null($cekUser)){
            $email = $cekUser->email;

            $dataUser = User::where('email',$email)->first();
            if($dataUser->email_verified_at){
                $message = "Akun ada sudah terverifikasi sebelumnya";
            }
            else{
                $data = [
                    'email_verified_at' => Carbon::now()
                ];
                User::where('email',$email)->update($data);
                UserVerify::where('email',$email)->delete();
                $message = "Akun ada sudah terverifikasi, Silakan Login";
            }
            return redirect()->route('login')->with('success', $message);
        }
        else{
            return redirect()->route('login')->withErrors('Link Token tidak Valid');
        }
    }

}
