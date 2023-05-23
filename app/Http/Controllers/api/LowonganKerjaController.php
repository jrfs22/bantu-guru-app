<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\api\LowonganKerjaModel;
use App\Http\Resources\LowonganKerjaDetailResource;

class LowonganKerjaController extends Controller
{
    public function index()
    {
        $lowongan_kerja = LowonganKerjaModel::all();
        // return response()->json(['data'=>$lowongan_kerja]);
        return LowonganKerjaDetailResource::collection($lowongan_kerja->loadMissing(['user:user_id,user_npa_pgri,user_nama_lengkap','validasi:user_id,user_npa_pgri,user_nama_lengkap']));
    }
}
