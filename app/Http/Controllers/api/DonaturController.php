<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
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
        try{
            $donatur = DonaturModel::create([
                'user_id' => '2IFmIsMuOWWNyfbYE02xozhyZSY2',
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
                    'Create data successfully'
                );
            }
        }catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Something wrong with your data',
                $exception->getMessage()
            );
        }
    }
}
