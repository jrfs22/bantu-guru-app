<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\KompetensiModel;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\KompetensiResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KompetensiController extends BaseController
{
    public function index()
    {
        try{
            $kompetensi = KompetensiModel::all();
            $data = KompetensiResource::collection($kompetensi->loadMissing('peserta:kompetensi_id'));
            if(count($data) == 0){
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
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function getById($id)
    {
        try{
            $kompetensi = KompetensiModel::findOrFail($id);
            return $this->sendResponse(
                new KompetensiResource($kompetensi->loadMissing('peserta:kompetensi_id')),
                'Get kompetensi successfully' 
            );
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Id '. $id .' not found',
                $exception->getMessage()
            );
        }
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tipe' => 'required',
            'max_peserta' => 'required|integer',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:4096'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error found',
                $validated->errors()
            );
        }

        $newNameOfImage = $request->gambar->hashName();
        try{
            $kompetensi = KompetensiModel::create([
                'nama' => $request->nama,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'tipe' => $request->tipe,
                'max_peserta' => $request->max_peserta,
                'deskripsi' => $request->deskripsi,
                'gambar' => $newNameOfImage
            ]);
    
            if($kompetensi){
                $request->gambar->move('storage/image/kompetensi', $newNameOfImage);
                return $this->sendResponse(
                    new KompetensiResource($kompetensi->loadMissing('peserta:kompetensi_id')),
                    'Insert kompetensi successfully'
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
            $kompetensi = KompetensiModel::findOrFail($id);
            $oldImage = $kompetensi->gambar;
            $validated = Validator::make($request->all(), [
                'nama' => 'required',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'tipe' => 'required',
                'max_peserta' => 'required|integer',
                'deskripsi' => 'required'
            ]);
            
            if($validated->fails()){
                return $this->sendError(
                    'Validate error found',
                    $validated->errors()
                );
            }

            $updateKompetensi = [
                'nama' => $request->nama,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'tipe' => $request->tipe,
                'max_peserta' => $request->max_peserta,
                'deskripsi' => $request->deskripsi
            ];

            if(!$request->exists('gambar')){
                $kompetensi->update($updateKompetensi);
            }else{
                $validated = Validator::make($request->all(), [
                    'gambar' => 'required|image|mimes:jpeg,jpg,png|max:4096'
                ]);

                if($validated->fails()){
                    return $this->sendError(
                        'Validate error found',
                        $validated->errors()
                    );
                }

                $newNameOfImage = $request->gambar->hashName();
                $updateKompetensi['gambar'] = $newNameOfImage;
                $kompetensi->update($updateKompetensi);
                if($kompetensi){
                    $request->gambar->move('storage/image/kompetensi', $newNameOfImage);
                    $path = 'storage/image/kompetensi/' . $oldImage;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                }
            }

            return $this->sendResponse(
                new KompetensiResource($kompetensi->loadMissing('peserta:kompetensi_id')),
                'Update kompetensi successfully'
            );
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try{
            $kompetensi = KompetensiModel::findOrFail($id);
            $image = $kompetensi->gambar;
            $kompetensi->delete();
            return $this->sendResponse(
                $path = 'storage/image/kompetensi/' . $image;
                if(File::exists($path)){
                    File::delete($path);
                }
                new KompetensiResource($kompetensi->loadMissing('peserta:kompetensi_id')),
                'Delete kompetensi successfully'
            );
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Delete failed & id not found',
                $exception->getMessage()
            );
        }
    }
}
