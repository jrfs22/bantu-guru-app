<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\api\MateriBimbelModel;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MateriBimbelResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MateriBimbelController extends BaseController
{
    public function getById($list_bimbel_id, $user_id)
    {
        try {
            $materi = MateriBimbelModel::where('list_bimbel_id', $list_bimbel_id)->where('user_id', $user_id)->get();
            
            return $this->sendResponse(
                MateriBimbelResource::collection($materi->loadMissing('author:id,nama_lengkap,npa_pgri,instansi')),
                'Data found'
            );
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'List bimbel id & user id not found',
                $exception->getMessage()
            );
        }
    }

    public function store(Request $request, $list_bimbel_id, $user_id)
    {
        $validated = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'list_bimbel_id' => 'required|exists:list_bimbel,id',
            'user_id' => 'required|exists:users,id',
            'file' => 'required|mimes:pdf,docs,pptx,word'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        $newNameOfFile = $request->file->hashName();
        try {
            $materi = MateriBimbelModel::create([
                'deskripsi'=> $request->deskripsi,
                'list_bimbel_id' => $request->list_bimbel_id,
                'user_id' => $request->user_id,
                'file' => $newNameOfFile
            ]);

            if($materi){
                $request->file->move('storage/file/materi-bimbel', $newNameOfFile);
                return $this->sendResponse(
                    new MateriBimbelResource($materi->loadMissing('author:id,nama_lengkap,npa_pgri,instansi')),
                    'Create new data successfully'
                );
            }
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Failed to create materi',
                $exception->getMessage()
            );
        }
    }
    
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'deskripsi' => 'required',
            'list_bimbel_id' => 'required|exists:list_bimbel,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        $updateMateri = [
            'deskripsi' => $request->deskripsi,
            'list_bimbe_id' => $request->list_bimbel_id,
            'user_id' => $request->user_id
        ];
        try {
            $materi = MateriBimbelModel::findOrFail($id);
            $oldFile = $materi->file;
            if(!$request->hasFile('file')){
                $materi->update($updateMateri);
            }else{
                $validated = Validator::make($request->all(), [
                    'file' => 'required|mimes:pdf,docs,pptx,word'
                ]);
        
                if($validated->fails()){
                    return $this->sendError(
                        'Validate error',
                        $validated->errors()
                    );
                }

                $newNameOfFile = $request->file->hashName();
        
                $updateMateri['file'] = $newNameOfFile;
                $materi->update($updateMateri);
                if($materi){
                    $request->file->move('storage/file/materi-bimbel', $newNameOfFile);
                    $path = 'storage/file/materi-bimbel/' . $oldFile;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                }
            }

            return $this->sendResponse(
                new MateriBimbelResource($materi->loadMissing('author:id,nama_lengkap,npa_pgri,instansi')),
                'Update data successfully'
            );
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'No data found',
                $exception->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $materi = MateriBimbelModel::findOrFail($id);
            $materi->delete();

            if($materi){
                return $this->sendResponse(
                    new MateriBimbelResource($materi->loadMissing('author:id,nama_lengkap,npa_pgri,instansi')),
                    'Delete data successfully'
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
