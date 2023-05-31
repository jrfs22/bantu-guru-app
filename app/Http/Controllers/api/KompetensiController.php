<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\KompetensiModel;
use App\Http\Controllers\BaseController;
use App\Http\Resources\KompetensiResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KompetensiController extends BaseController
{
    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try{
            $kompetensi = KompetensiModel::all();
            return KompetensiResource::collection($kompetensi->loadMissing('peserta:kompetensi_id'));
        }catch(ModelNotFoundException $exception){
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }

    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jam_mulai' => 'required|time',
            'jam_selesai' => 'required|time',
            'tipe' => 'required',
            'max_peserta' => 'required|integer',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpeg,jpg,png|max:250'
        ]);

        $newNameOfImage = $request->poster->hashName();
        $kompetensi = KompetensiModel::create([
            'nama' => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tipe' => $request->tipe,
            'max_peserta' => $request->max_peserta,
            'deskripsi' => $request->deskripsi,
            'poster' => $request
        ]);

        if($kompetensi){
            $request->poster->image('/storage/image/kompetensi', $newNameOfImage);
            return KompetensiResource::collection($kompetensi->loadMissing('peserta:kompetensi_id'));
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Something wrong with your data'
            ], 504);
        }
    }
}
