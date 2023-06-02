<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\api\ListBimbelModel;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ListBimbelResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ListBimbelController extends BaseController
{
    public function index()
    {
        try{
            $list_bimbel = ListBimbelModel::all();
            $data = ListBimbelResource::collection($list_bimbel);
            if(count($list_bimbel) == 0){
                return $this->sendResponse(
                    $data,
                    'table has no data'
                );
            }else{
                return $this->sendResponse(
                    $data,
                    'Data list bimbel found'
                );
            }
        } catch(ModelNotFoundException | QueryException $exception){
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function getById($id)
    {
        try {
            $list_bimbel = ListBimbelModel::findOrFail($id);
            return $this->sendResponse(
                new ListBimbelResource($list_bimbel),
                'Data found'
            );
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Id not found',
                $exception->getMessage()
            );
        }
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:250'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        try {
            $newNameOfImage = $request->gambar->hashName();
            $list_bimbel = ListBimbelModel::create([
                'nama' => $request->nama,
                'gambar' => $newNameOfImage
            ]);

            if($list_bimbel){
                $request->gambar->move('storage/image/list-bimbel', $newNameOfImage);
                return $this->sendResponse(
                    new ListBimbelResource($list_bimbel),
                    'Create list bimbel successfully'
                );
            }
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Failed to create list bimbel',
                $exception->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $list_bimbel = ListBimbelModel::findOrFail($id);
            $image = $list_bimbel->gambar;
            $list_bimbel->delete();
            if($list_bimbel){
                $path = 'storage/image/list-bimbel/' . $image;
                if(File::exists($path)){
                    File::delete($path);
                }
                return $this->sendResponse(
                    new ListBimbelResource($list_bimbel),
                    'Delete list bimbel successfully'
                );
            }
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Failed to delete list bimbel',
                $exception->getMessage()
            );
        }
    }
}
