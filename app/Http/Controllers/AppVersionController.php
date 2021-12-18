<?php

namespace App\Http\Controllers;

use App\Models\AppVersion;
use Illuminate\Http\Request;

class AppVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required',
            'scope' => 'required',
            'code_version' => 'required',
            'app_version' => 'required'
        ]);

        $app_insert = AppVersion::create($request->input());

        if ($app_insert) {
            return response()->json([
                "status" => true,
                "message" => 'success',
                "data" => $app_insert
            ],200);
        } else {
            return response()->json([
                "status" => false,
                "message" => 'failed'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        if ($request->get('platform') && $request->get('scope')) {
            $app_version = AppVersion::where('platform', $request->get('platform'))->where('scope', $request->get('scope'))->first();

            if ($app_version) {
                return response()->json([
                    "status" => true,
                    "message" => "app version found",
                    "data" => $app_version
                ],200);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "app version not found"
                ],404);
            }
        } else {

            $app_version = AppVersion::paginate();

            return response()->json([
                "status" => true,
                "message" => 'app verson found',
                "data" => $app_version
            ] ,200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'platform' => 'required',
            'scope' => 'required',
            'code_version' => 'required',
            'app_version' => 'required'
        ]);

        $app_insert = AppVersion::find($id)->update($request->input());

        if ($app_insert) {
            return response()->json([
                "status" => true,
                "message" => 'success',
                "data" => AppVersion::find($id)
            ],200);
        } else {
            return response()->json([
                "status" => false,
                "message" => 'failed'
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $app_version = AppVersion::destroy($id);

        if ($app_version) {
            return response()->json([
                "status" => true,
                "message" => 'success'
            ],200);
        } else {
            return response()->json([
                "status" => false,
                "message" => 'failed'
            ],500);
        }
    }
}
