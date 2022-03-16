<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->session()->has('login_session')) {
            return redirect()->back();
        }

        $title = 'Login';

        return view('auth.login', compact('title'));
    }

    public function doLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast.warning', $validator->getMessageBag()->first());
        }

        try {
            $url = $this->apiHelper->url("login");
            $response = $this->apiHelper->hit($url, "POST", '', $request->all());

            if ($response->status == "failed") {
                Log::error($response->message);
                return redirect()->back()->withInput()->with('toast.warning', $response->message);
            } else {
                $request->session()->put('login_session', $response->data);

                return redirect()->route('blog.index');
            }
        } catch (\Throwable $th) {
            Log::error($th->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function register(Request $request)
    {
        if ($request->session()->has('login_session')) {
            return redirect()->back();
        }

        $title = 'Register';

        return view('auth.register', compact('title'));
    }

    public function doRegister(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast.warning', $validator->getMessageBag()->first());
        }

        try {
            $url = $this->apiHelper->url("register");
            $response = $this->apiHelper->hit($url, "POST", '', $request->all());

            if ($response->status == "failed") {
                Log::error($response->message);
                return redirect()->back()->withInput()->with('toast.warning', $response->message);
            } else {
                $request->session()->put('login_session', $response->data);

                return redirect()->route('blog.index');
            }
        } catch (\Throwable $th) {
            Log::error($th->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $url = $this->apiHelper->url("logout");
            $response = $this->apiHelper->hit($url, 'POST', $this->token);
            if ($response->status == 'failed') {
                return redirect()->back()->with('toast.warning', $response->message);
            }

            $request->session()->flush();

            return redirect()->route('login');
        } catch (\Throwable $th) {
            Log::error($th->getTraceAsString());

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
