<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\QueryException;
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
            $data = DonasiResource::collection($donasi->loadMissing('donatur:id,user_id,donasi_id,nominal'));
            if(count($donasi) == 0){
                return $this->sendResponse(
                    $data,
                    'table has no data'
                );
            }else{
                return $this->sendResponse(
                    $data,
                    'Data found'
                );
            }
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Data not found',
                $exception->getMessage()
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
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Table has no data and id not found',
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
                'Validate Error',
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $newNameOfImage = $request->gambar->hashName();
        try{
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
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $donasi = DonasiModel::findOrFail($id);
            $oldImage = $donasi->gambar;
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'deskripsi' => 'required|max:1000',
                'tanggal' => 'required'
            ]);
            
            if($validator->fails()){
                return $this->sendError(
                    'Error found',
                    $validator->errors(),
                    Response::HTTP_BAD_REQUEST
                );
            }
            // Variabel data
            $updateDonasi = [
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal
            ];
            if(!$request->hasFile('gambar')){
                $donasi->update($updateDonasi);
            }else{
                $newNameOfImage = $request->gambar->hashName();
                $validatorGambar = Validator::make($request->all(), [
                    'gambar' => 'required|image|mimes:jpeg,jpeg,png|max:250'
                ]);
    
                if($validatorGambar->fails()){
                    return $this->sendError(
                        'Error found',
                        $validatorGambar->errors(),
                        Response::HTTP_BAD_REQUEST
                    );
                }
                $updateDonasi['gambar'] = $newNameOfImage;
                $donasi->update($updateDonasi);
                
                if($donasi){
                    $request->gambar->move('storage/image/donasi', $newNameOfImage);
                    $path = 'storage/image/donasi/' . $oldImage;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                }
            }
            
            return $this->sendResponse(
                new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id')),
                'Update data successfully'
            ); 
        }catch(ModelNotFoundException $exception){
            return $this->sendError(
                'Update failed & id not found',
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function destroy($id)
    {
        try{
            $donasi = DonasiModel::findOrFail($id);
            $donasi->delete();
            return $this->sendResponse(
                new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id')),
                'Data deleted successfully'
            );
        }catch(ModelNotFoundException $exception){
            return $this->sendError(
                'Delete failed & id not found',
                $exception->getMessage()
            );
        }
    }
}
