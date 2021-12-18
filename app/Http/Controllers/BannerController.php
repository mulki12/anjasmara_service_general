<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
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
            'banner_image' => 'required|image|mimes:jpeg,png,gif,svg|max:2048',
            'scope' => 'required'
        ]);

        $path = 'storage/banner';

        $imageName = 'banner_' . time() . '.' .$request->banner_image->extension();

        $moved_file = $request->banner_image->move(public_path($path), $imageName);

        if ($moved_file) {
            $banner_insert = Banner::create([
                'image_url' => $path . '/' . $imageName,
                'is_active' => $request->is_active ?? '0',
                'set_priority' => $request->set_priority ?? '0',
                'scope' => $request->scope
            ]);

            if ($banner_insert) {
                return response()->json([
                    'status' => true,
                    'message' => 'success',
                    'data' => $banner_insert
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'something is wrong',
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => 'something is wrong'
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
            $banners = Banner::paginate();

            if ($banners) {
                return response()->json([
                    'status' => true,
                    'message' => 'banner is found',
                    'data' => $banners
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'banner is not found'
                ], 404);
            }
        } else {
            $banners = Banner::where('is_active', '1')->where('scope', $request->get('scope'))->where('set_priority', '!=', '0')->orderBy('set_priority', 'DESC')->get();

            if ($banners) {
                return response()->json([
                    'status' => true,
                    'message' => 'banner is found',
                    'data' => $banners
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'banner is not found'
                ], 404);
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
        $banner_find = Banner::find($id);
        $banner_find->is_active     = $request->is_active;
        $banner_find->set_priority  = $request->set_priority;

        $has_file = $request->hasFile('image_banner');

        if ($has_file) {

            @unlink(public_path($banner_find->image_url));

            $path = 'storage/banner';
            $imageName = 'banner_' . time() . '.' .$request->image_banner->extension();

            $moved_file = $request->image_banner->move(public_path($path), $imageName);

            if ($moved_file) {
                $banner_find->image_url = ($path . '/' . $imageName);
            }
        }

        $update = $banner_find->save();

        if ($update) {
            return response()->json([
                "status" => true,
                "message" => "update success"
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
        $banner = Banner::find($id);
        $delete = Banner::destroy($id);

        if ($delete) {
            unlink(public_path($banner->image_url));

            return response()->json([
                'status' => true,
                'message' => 'success'
            ]);
        }
    }
}
