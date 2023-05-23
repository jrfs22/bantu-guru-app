<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\DonasiModel;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonasiResource;

class DonasiController extends Controller
{
    public function index()
    {
        $donasi = DonasiModel::all();
        return DonasiResource::collection($donasi->loadMissing('donatur:id,user_id,nominal'));
    }

    public function show($id)
    {
        $donasi = DonasiModel::findOrFail($id);
        return response()->json(['data' => $donasi]);
    }
}
