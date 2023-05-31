<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\api\DonaturModel;
use App\Http\Resources\DonaturResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class DonaturController extends BaseController
{
    public function store(Request $request, $donasi_id)
    {
        $validated = Validator::make($request->all() ,[
            'catatan' =>'required',
            'nominal' => 'required',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:250'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $newNameOfImage = $request->bukti_pembayaran->hashName();
        $donatur = DonaturModel::create([
            'user_id' => '994b4893-154a-42f2-8b35-1730b8263706',
            'donasi_id' => $donasi_id,
            'catatan' => $request->catatan,
            'nominal' => $request->nominal,
            'bukti_pembayaran' => $newNameOfImage
        ]);

        if($donatur){
            $request->bukti_pembayaran->move('storage/image/donatur', $newNameOfImage);
            return $this->sendResponse(
                new DonaturResource($donatur->loadMissing([
                    'user:id,nama_lengkap,gelar_depan,gelar_belakang',
                    'donasi:id,nama'
                ])),
                ''
            );
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Something wrong with your data'
            ], 504);
        }
    }
}
