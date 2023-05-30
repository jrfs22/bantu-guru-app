<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\api\DonasiModel;
use App\Http\Resources\DonasiResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DonasiDetailResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DonasiController extends BaseController
{
    public function index()
    {
        try{
            $donasi = DonasiModel::all();
            return $this->sendResponse(
                DonasiResource::collection($donasi->loadMissing('donatur:id,user_id,donasi_id,nominal')),
                'Data found'
            );
        }catch(ModelNotFoundException $exception){
            return $this->sendError(
                'Data not found',
                $exception->getMessage(),
                404
            );
        }
    }

    public function getById($id)
    {
        try{
            $donasi = DonasiModel::with('donatur:id,donasi_id,nominal,user_id')->findOrFail($id);
            return $this->sendResponse(
                new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id')),
                'Data found'
            );
        }catch(ModelNotFoundException $exception){
            return $this->sendError(
                'Data not found',
                $exception->getMessage(),
                404
            );
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'tanggal' => 'required|date',
            'gambar' => 'required|image|mimes:jpeg,jpeg,png|max:250'
        ]);
        
        if($validator->fails()){
            return $this->sendError(
                'Error found',
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $newNameOfImage = $request->gambar->hashName();
        $donasi = DonasiModel::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'gambar' => $newNameOfImage,
            'tanggal' => $request->tanggal,
            'status' => 0
        ]);

        if($donasi){
            $request->gambar->move('storage/image/donasi', $newNameOfImage);
            return $this->sendResponse(
                new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id')),
                'Data uploaded successfully'
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'required|max:1000',
            'tanggal' => 'required'
        ]);
        try{
            $donasi = DonasiModel::findOrFail($id);
            if(empty($request->gambar)){
                $donasi->update([
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'tanggal' => $request->tanggal
                ]);
            }else{
                $oldImage = $donasi->gambar;
                $newNameOfImage = $request->gambar->hashName();
                $validated = $request->validate([
                    'gambar' => 'required|image|mimes:jpeg,jpeg,png|max:250'
                ]);
    
                $donasi->update([
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => $newNameOfImage,
                    'tanggal' => $request->tanggal
                ]);
    
                if($donasi){
                    $request->gambar->image('storage/image/donasi', $newNameOfImage);
                    $path = 'storage/image/loker/' . $oldImage;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                }
            }
            
            return new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id'));
        }catch(ModelNotFoundException $exception){
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try{
            $donasi = DonasiModel::findOrFail($id);
            $donasi->delete();
            return new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id'));
        }catch(ModelNotFoundException $exception){
            return response()->json([
                'status' => false,
                'message' => 'Id not found'
            ], 404);
        }
    }
}
