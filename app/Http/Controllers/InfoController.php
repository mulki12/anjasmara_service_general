<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
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
            'image_info'    => 'required|image|mimes:jpeg,png,gif,svg|max:2048',
            'keterangan'    => 'required',
            'expired_date'  => 'required|date',
            'is_active'     => 'required',
            'set_priority'  => 'required'
        ]);

        if ($request->hasFile('image_info')) {

            $path = 'storage/info';

            $imageName = 'info_' . time() . '.' .$request->image_info->extension();
            $request->image_info->move(public_path($path), $imageName);

            $image_info = $path . '/' . $imageName;
        }

        $insert = Info::create([
            'image_info'    => $image_info ?? null,
            'keterangan'    => $request->keterangan,
            'expired_date'  => $request->expired_date,
            'is_active'     => $request->is_active ?? 0,
            'set_priority'  => $request->set_priority
        ]);

        if ($insert) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $insert
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'something is wrong'
            ], 500);
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
        if ($request->get('scope') == null) {
            $info = Info::paginate();

            return response()->json([
                'status' => true,
                'message' => 'info is found',
                'data' => $info
            ]);
        } else {
            $info = Info::where('is_active', '!=', '0')->whereBetween('set_priority', ['1', '9'])->orderBy('set_priority', 'DESC')->get();

            if (count($info) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'info is found',
                    'data' => $info
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'info is not found'
                ]);
            }
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
        $info = Info::find($id);
        $info->keterangan   = $request->keterangan;
        $info->expired_date = $request->expired_date;
        $info->is_active    = $request->is_active;
        $info->set_priority = $request->set_priority;

        if ($request->hasFile('image_info')) {

            @unlink(public_path($info->image_info));

            $path = 'storage/info';

            $imageName = 'info_' . time() . '.' .$request->image_info->extension();
            $request->image_info->move(public_path($path), $imageName);

            $image_info = $path . '/' . $imageName;

            $info->image_info = $image_info;
        }

        $update = $info->save();

        if ($update) {
            return response()->json([
                'status' => true,
                'message' => 'updated success',
                'data' => Info::find($id)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'something is wrong',
            ], 500);
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
        $info = Info::find($id);
        @unlink(public_path($info->image_info));

        $delete = Info::destroy($id);

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'success deleted'
            ]);
        }
    }
}
