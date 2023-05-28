<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\DonasiModel;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonasiResource;
use App\Http\Resources\DonasiDetailResource;

class DonasiController extends Controller
{
    public function index()
    {
        $donasi = DonasiModel::all();
        return DonasiResource::collection($donasi->loadMissing('donatur:id,donasi_id,nominal'));
    }

    public function getById($id)
    {
        $donasi = DonasiModel::with('donatur:id,donasi_id,nominal,user_id')->findOrFail($id);
        return new DonasiDetailResource($donasi->loadMissing('donatur:id,donasi_id,nominal,user_id'));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'catatan' => 'required'
        // ]);
    }
}
