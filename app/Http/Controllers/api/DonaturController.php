<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\DonaturModel;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonaturResource;

class DonaturController extends Controller
{
    public function store(Request $request, $donasi_id)
    {
        $validated = $request->validate([
            'catatan' =>'required',
            'nominal' => 'required',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:250'
        ]);

        $newNameOfImage = $request->bukti_pembayaran->hashName();
        $donatur = DonaturModel::create([
            'user_id' => 1,
            'donasi_id' => $donasi_id,
            'catatan' => $request->catatan,
            'nominal' => $request->nominal,
            'bukti_pembayaran' => $newNameOfImage,
            'valid' => 0,
            'status' => 0
        ]);

        if($donatur){
            $request->bukti_pembayaran->move('storage/image/donatur', $newNameOfImage);
            return new DonaturResource($donatur->loadMissing([
                'user:id,nama_lengkap,gelar_depan,gelar_belakang',
                'donasi:id,nama'
            ]));
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Something wrong with your data'
            ], 504);
        }
    }
}
