<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\api\LowonganKerjaModel;
use Illuminate\Support\Facades\File; 
use App\Http\Resources\LowonganKerjaDetailResource;

class LowonganKerjaController extends Controller
{
    public function index()
    {
        $lowongan_kerja = LowonganKerjaModel::all();
        return LowonganKerjaDetailResource::collection($lowongan_kerja->loadMissing([
            'user:id,nama_lengkap,gelar_depan,gelar_belakang',
            'validasi:id,nama_lengkap,gelar_depan,gelar_belakang'
        ]));
    }

    public function show($id)
    {
        $lowongan_kerja = LowonganKerjaModel::findOrFail($id);
        if($lowongan_kerja){
            return new LowonganKerjaDetailResource($lowongan_kerja->loadMissing([
                'user:id,nama_lengkap,gelar_depan,gelar_belakang',
                'validasi:id,nama_lengkap,gelar_depan,gelar_belakang'
            ]));
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:250'
        ]);

        $newNameOfImage = $request->image->hashName();

        $loker = LowonganKerjaModel::create([
            'nama' => $request->nama,
            'image' => $newNameOfImage,
            'user_id' => 1,
            'status' => 0,
            'validasi_by' => 1,
            'view' => 0
        ]);

        if($loker){
            $request->image->move('storage/image/loker', $newNameOfImage);
            return new LowonganKerjaDetailResource($loker->loadMissing('user:id,nama_lengkap'));
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Insert data invalid'
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
        ]);

        $loker = LowonganKerjaModel::findOrFail($id);
        $oldImage = $loker->image;
        if(empty($request->image)){
            $loker->update([
                'nama' => $request->nama
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Update successfully'
            ], 200);
        }else{
            $newNameOfImage = $request->image->hashName();
            $loker->update([
                'nama' => $request->nama,
                'image' => $newNameOfImage
            ]); 

            if($loker){
                $request->image->move('storage/image/loker', $newNameOfImage);
                $path = 'storage/image/loker/' . $oldImage;
                if(File::exists($path)){
                    File::delete($path);
                }
            }
            return new LowonganKerjaDetailResource($loker->loadMissing('user:id,nama_lengkap'));
        }
    }

    public function destroy($id)
    {
        $loker = LowonganKerjaModel::findOrfail($id);
        $loker->delete();

        return new LowonganKerjaDetailResource($loker->loadMissing('user:id,nama_lengkap'));
    }
}
