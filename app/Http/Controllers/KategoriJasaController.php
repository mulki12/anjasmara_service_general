<?php

namespace App\Http\Controllers;

use App\Models\KategoriJasa;
use Illuminate\Http\Request;

class KategoriJasaController extends Controller
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
            'kode_jasa'     => 'required',
            'nama_jasa'     => 'required',
            'is_published'  => 'required',
            'set_priority'  => 'required',
        ]);

        if ($request->hasFile('icon_jasa')) {

            $request->validate([
                'icon_jasa' => 'required|image|mimes:jpeg,png,gif,svg|max:2048',
            ]);

            $path = 'storage/kategori_jasa';

            $imageName = 'kategori_jasa_' . time() . '.' .$request->icon_jasa->extension();
            $request->icon_jasa->move(public_path($path), $imageName);

            $icon_jasa = $path . '/' . $imageName;
        }

        $insert = KategoriJasa::create([
            'kode_jasa'     => $request->kode_jasa,
            'nama_jasa'     => $request->nama_jasa,
            'icon_jasa'     => $icon_jasa ?? null,
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
            $kategori_jasa = KategoriJasa::paginate();

            return response()->json([
                'status' => true,
                'message' => 'kategori jasa is found',
                'data' => $kategori_jasa
            ]);
        } else {
            $kategori_jasa = KategoriJasa::where('is_published', '!=', '0')->get();

            if (count($kategori_jasa) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'kategori jasa is found',
                    'data' => $kategori_jasa
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

        $kategori_jasa = KategoriJasa::find($id);
        $kategori_jasa->kode_jasa       = $request->kode_jasa;
        $kategori_jasa->nama_jasa       = $request->nama_jasa;
        $kategori_jasa->action          = $request->action;
        $kategori_jasa->is_published    = $request->is_published;
        $kategori_jasa->set_priority    = $request->set_priority;

        if ($request->hasFile('icon_jasa')) {

            @unlink(public_path($kategori_jasa->icon_jasa));

            $request->validate([
                'icon_jasa' => 'required|image|mimes:jpeg,png,gif,svg|max:2048',
            ]);

            $path = 'storage/kategori_jasa';

            $imageName = 'kategori_jasa_' . time() . '.' .$request->icon_jasa->extension();

            $request->icon_jasa->move(public_path($path), $imageName);

            $kategori_jasa->icon_jasa = $path . '/' . $imageName;

        }

        $update = $kategori_jasa->save();

        if ($update) {
            return response()->json([
                'status' => true,
                'message' => 'updated success',
                'data' => KategoriJasa::find($id)
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
        $kategori_jasa = KategoriJasa::find($id);
        @unlink(public_path($kategori_jasa->icon_jasa));

        $delete = KategoriJasa::destroy($id);

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'success deleted'
            ]);
        }
    }
}
