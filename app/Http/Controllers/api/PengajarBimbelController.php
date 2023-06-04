<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\PengajarBimbelModel;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PengajarBimbelResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PengajarBimbelController extends BaseController
{
    public function index()
    {
        try{
            $pengajarBimbel = PengajarBimbelModel::all();
            $data = PengajarBimbelResource::collection($pengajarBimbel->loadMissing([
                'materi:id,list_bimbel_id,user_id',
                'user:id,nama_lengkap,no_hp,npa_pgri'
            ]));
            if(count($pengajarBimbel) == 0){
                return $this->sendResponse(
                    $data,
                    'Table has no data'
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

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id|unique:pengajar_bimbel,user_id',
            'list_bimbel_id' => 'required|exists:list_bimbel,id|unique:pengajar_bimbel,list_bimbel_id'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        try {
            $pengajarBimbel = PengajarBimbelModel::create([
                'user_id' => $request->user_id,
                'list_bimbel_id' => $request->list_bimbel_id
            ]);

            if($pengajarBimbel){
                return $this->sendResponse(
                    new PengajarBimbelResource($pengajarBimbel->loadMissing([
                        'materi:id,list_bimbel_id,user_id',
                        'user:id,nama_lengkap,no_hp,npa_pgri'
                    ])),
                    'Create new pengajar successfully'
                );
            }
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pengajarBimbel = PengajarBimbelModel::findOrFail($id);
            $pengajarBimbel->update([
                'list_bible_id' => $id
            ]);

            if($pengajarBimbel){
                return $this->sendResponse(
                    'Update successfully',
                    new PengajarBimbelResource($pengajarBimbel->loadMissing([
                        'materi:id,list_bimbel_id,user_id',
                        'user:id,nama_lengkap,no_hp,npa_pgri'
                    ]))
                );
            }
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Id not found',
                $exception->getMessage()
            );
        }
    }
}
