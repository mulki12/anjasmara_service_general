<?php

namespace App\Http\Controllers;

use App\Models\KategoriPPOB;
use Illuminate\Http\Request;

class KategoriPPOBController extends Controller
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
            'kode_ppob'     => 'required',
            'nama_ppob'     => 'required',
            'is_published'  => 'required',
            'set_priority'  => 'required',
        ]);

        if ($request->hasFile('icon_ppob')) {

            $request->validate([
                'icon_ppob' => 'required|image|mimes:jpeg,png,gif,svg|max:2048',
            ]);

            $path = 'storage/kategori_ppob';

            $imageName = 'kategori_ppob_' . time() . '.' .$request->icon_ppob->extension();
            $request->icon_ppob->move(public_path($path), $imageName);

            $icon_ppob = $path . '/' . $imageName;
        }

        $insert = KategoriPPOB::create([
            'kode_ppob'     => $request->kode_ppob,
            'nama_ppob'     => $request->nama_ppob,
            'icon_ppob'     => $icon_ppob ?? null,
            'action'        => $request->action,
            'is_published'  => $request->is_published,
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
            $kategori_ppob = KategoriPPOB::paginate();

            return response()->json([
                'status' => true,
                'message' => 'kategori jasa is found',
                'data' => $kategori_ppob
            ]);
        } else {
            $kategori_ppob = KategoriPPOB::where('is_published', '!=', '0')->get();

            if (count($kategori_ppob) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'kategori jasa is found',
                    'data' => $kategori_ppob
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'kategori jasa is not found'
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
        $kategori_ppob = KategoriPPOB::find($id);
        $kategori_ppob->kode_ppob       = $request->kode_ppob;
        $kategori_ppob->nama_ppob       = $request->nama_ppob;
        $kategori_ppob->action          = $request->action;
        $kategori_ppob->is_published    = $request->is_published;
        $kategori_ppob->set_priority    = $request->set_priority;

        if ($request->hasFile('icon_ppob')) {

            @unlink(public_path($kategori_ppob->icon_ppob));

            $request->validate([
                'icon_ppob' => 'required|image|mimes:jpeg,png,gif,svg|max:2048',
            ]);

            $path = 'storage/kategori_ppob';

            $imageName = 'kategori_ppob_' . time() . '.' .$request->icon_ppob->extension();

            $request->icon_ppob->move(public_path($path), $imageName);

            $kategori_ppob->icon_ppob = $path . '/' . $imageName;

        }

        $update = $kategori_ppob->save();

        if ($update) {
            return response()->json([
                'status' => true,
                'message' => 'updated success',
                'data' => KategoriPPOB::find($id)
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
        $kategori_ppob = KategoriPPOB::find($id);
        @unlink(public_path($kategori_ppob->icon_ppob));

        $delete = KategoriPPOB::destroy($id);

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'success deleted'
            ]);
        }
    }
}
