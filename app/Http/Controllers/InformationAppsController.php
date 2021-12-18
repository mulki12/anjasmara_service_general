<?php

namespace App\Http\Controllers;

use App\Models\InformationApps;
use Illuminate\Http\Request;

class InformationAppsController extends Controller
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
            'section_information' => 'required',
            'content_information' => 'required'
        ]);

        $information_insert = InformationApps::create([
            'platform' => $request->platform ?? null,
            'scope' => $request->scope ?? null,
            'section_information' => $request->section_information,
            'content_information' => $request->content_information
        ]);

        if ($information_insert) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $information_insert
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'something is wrong'
            ]);
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
        $platform = $request->get('platform') ?? null;
        $scope = $request->get('scope') ?? null;
        $section = $request->get('section_information');

        if ($section != null) {

            if ($platform == null && $scope == null) {
                $info = InformationApps::where('section_information', $section)->get();
            } else {
                $info = InformationApps::where('platform', $platform)->where('scope', $scope)->where('section_information', $section)->get();
            }

        } else {
            $info = InformationApps::all();
        }

        return response()->json([
            'status' => true,
            'message' => 'found',
            'data' => $info
        ]);

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
        $information_update = InformationApps::find($id);
        $information_update->platform = $request->platform ?? null;
        $information_update->scope = $request->scope ?? null;
        $information_update->section_information = $request->section_information;
        $information_update->content_information = $request->content_information;
        $update = $information_update->save();

        if ($update) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => InformationApps::find($id)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'something is wrong'
            ]);
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
        $delete = InformationApps::find($id)->delete($id);

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'deleted success'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'something is wrong'
            ], 500);
        }
    }
}
