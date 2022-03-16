<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $apiHelper;
    protected $token;

    public function __construct()
    {
        $this->apiHelper = new ApiHelper();
        $this->middleware(function($request, $next) {
            if ($request->session()->has('login_session')) {
                $this->token = $request->session()->get('login_session')->token;
            } else {
                $this->token = null;
            }

            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            if (session('warning')) {
                Alert::warning(session('warning'));
            }

            if (session('errorForm')) {
                $html = "<ul style='list-style: none;'>";
                foreach (session('errorForm') as $error) {
                    $html .= "<li>".$error[0]."</li>";
                }
                $html .= "</ul>";

                Alert::html('Validation Failed', $html, 'warning');
            }

            if (session('toast.warning')) {
                Alert::toast(session('toast.warning'), 'warning')->position('bottom-end')->timerProgressBar();
            }

            if (session('toast.error')) {
                Alert::toast(session('toast.error'), 'error')->position('bottom-end')->timerProgressBar();
            }

            if (session('toast.success')) {
                Alert::toast(session('toast.success'), 'success')->position('bottom-end')->timerProgressBar();
            }

            return $next($request);
        });
    }
}
