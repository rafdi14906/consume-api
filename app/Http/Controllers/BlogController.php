<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $data['title'] = 'Blog';

        $data['blogs'] = [];

        $url = $this->apiHelper->url("blog");
        $response = $this->apiHelper->hit($url, "GET", $this->token);
        if ($response->status == "success") {
            $data['blogs'] = $response->data;
        } else {
            Log::error($response->message);
        }

        return view('blog.index')->with($data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast.warning', $validator->getMessageBag()->first());
        }

        try {
            $url = $this->apiHelper->url("blog");
            $response = $this->apiHelper->hit($url, "POST", $this->token, $request->all());

            if ($response->status == "failed") {
                Log::error($response->message);
                return redirect()->back()->withInput()->with('toast.warning', $response->message);
            } else {
                return redirect()->route('blog.index')->with('toast.success', 'Data saved!');
            }
        } catch (\Throwable $th) {
            Log::error($th->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast.warning', $validator->getMessageBag()->first());
        }

        try {
            $url = $this->apiHelper->url("blog/{$id}");
            $response = $this->apiHelper->hit($url, "PUT", $this->token, $request->all());

            if ($response->status == "failed") {
                Log::error($response->message);
                return redirect()->back()->withInput()->with('toast.warning', $response->message);
            } else {
                return redirect()->route('blog.index')->with('toast.success', 'Data updated!');
            }
        } catch (\Throwable $th) {
            Log::error($th->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $url = $this->apiHelper->url("blog/{$id}");
            $response = $this->apiHelper->hit($url, "DELETE", $this->token);

            if ($response->status == "failed") {
                Log::error($response->message);
                return redirect()->back()->withInput()->with('toast.warning', $response->message);
            } else {
                return redirect()->route('blog.index')->with('toast.success', 'Data deleted!');
            }
        } catch (\Throwable $th) {
            Log::error($th->getTraceAsString());

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
