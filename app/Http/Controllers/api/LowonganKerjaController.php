<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\api\LowonganKerjaModel;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\LowonganKerjaDetailResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LowonganKerjaController extends BaseController
{
    public function index()
    {
        try{
            $lowongan_kerja = LowonganKerjaModel::all();
            $data = LowonganKerjaDetailResource::collection($lowongan_kerja->loadMissing([
                'user:id,nama_lengkap,gelar_depan,gelar_belakang',
                'validasi:id,nama_lengkap,gelar_depan,gelar_belakang'
            ]));
            if(count($lowongan_kerja) == 0){
                return $this->sendResponse(
                    'table has no data',
                    $data
                );
            }else{
                return $this->sendResponse(
                    'Data found',
                    $data
                );
            }
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function getById($id)
    {
        try{
            $lowongan_kerja = LowonganKerjaModel::findOrFail($id);
            return $this->sendResponse(
                new LowonganKerjaDetailResource($lowongan_kerja->loadMissing([
                    'user:id,nama_lengkap,gelar_depan,gelar_belakang',
                    'validasi:id,nama_lengkap,gelar_depan,gelar_belakang'
                ])),
                'Data found'
            );
        }catch(ModelNotFoundException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }        
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required|max:255',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:1024'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        $newNameOfImage = $request->gambar->hashName();

        try{
            $loker = LowonganKerjaModel::create([
                'nama' => $request->nama,
                'gambar' => $newNameOfImage,
                'user_id' => '2IFmIsMuOWWNyfbYE02xozhyZSY2'
            ]);
    
            if($loker){
                $request->gambar->move('storage/image/loker', $newNameOfImage);
                return $this->sendResponse(
                    new LowonganKerjaDetailResource($loker->loadMissing('user:id,nama_lengkap')),
                    'Insert data successfully'
                );
            }
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required|max:255'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        $updateLoker = [
            'nama' => $request->nama
        ];
        try {
            $loker = LowonganKerjaModel::findOrFail($id);
            $oldImage = $loker->gambar;
            if(!$request->hasFile('gambar')){
                $loker->update($updateLoker);
            }else{
                $validated = Validator::make($request->all(), [
                    'gambar' => 'required|image|mimes:jpeg,jpg,png|max:1024'
                ]);

                if($validated->fails()){
                    return $this->sendError(
                        'Validate error',
                        $validated->errors()
                    );
                }

                $newNameOfImage = $request->gambar->hashName();
                $updateLoker['gambar'] =$newNameOfImage;
                $loker->update($updateLoker); 
    
                if($loker){
                    $request->gambar->move('storage/image/loker', $newNameOfImage);
                    $path = 'storage/image/loker/' . $oldImage;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                }
            }

            return $this->sendResponse(
                new LowonganKerjaDetailResource($loker->loadMissing('user:id,nama_lengkap')),
                'Update has succesfully'
            );
        }catch(ModelNotFoundException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }
    
    public function destroy($id)
    {
        try{
            $loker = LowonganKerjaModel::findOrfail($id);
            $loker->delete();
            return $this->sendResponse(
                new LowonganKerjaDetailResource($loker->loadMissing('user:id,nama_lengkap')),
                'Delete Lowongan Kerja successfully'
            );
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Delete failed & id not found',
                $exception->getMessage()
            );
        }
    }
}
