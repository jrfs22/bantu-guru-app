<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\api\MenuKaryaTulisModel;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MenuKaryaTulisResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuKaryaTulisController extends BaseController
{
    public function index()
    {
        try {
            $menuKaryaTulis = MenuKaryaTulisModel::all();
            $data = MenuKaryaTulisResource::collection($menuKaryaTulis->loadMissing('pembimbing:pembimbing_menu_id'));
            if(count($menuKaryaTulis) == 0){
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
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function getById($id)
    {
        try {
            $menuKaryaTulis = MenuKaryaTulisModel::findOrFail($id);
            return $this->sendResponse(
                new MenuKaryaTulisResource($menuKaryaTulis->loadMissing('pembimbing:id')),
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
            'nama' => 'required|unique:menu_pembimbing_karya_tulis,nama',
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
            $menuKaryaTulis = MenuKaryaTulisModel::create([
                'nama' => $request->nama,
                'gambar' => $newNameOfImage
            ]);

            if($menuKaryaTulis){
                $request->gambar->move('storage/image/karya-tulis/menu', $newNameOfImage);
                return $this->sendResponse(
                    new MenuKaryaTulisResource($menuKaryaTulis->loadMissing('pembimbing:id')),
                    'Created menu pembimbing karya tulus successfully'
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
        $validated = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        try {
            $menuKaryaTulis = MenuKaryaTulisModel::findOrFail($id);
            $oldImage = $menuKaryaTulis->gambar;
            $updateMenu = [
                'nama' => $request->nama
            ];
            if(!$request->hasFile('gambar')){
                $menuKaryaTulis->update($updateMenu);
            }else{
                $newNameOfImage = $request->gambar->hashName();
                $validated = Validator::make($request->all(), [
                    'gambar' => 'required|image|mimes:jpeg,jpg,png|max:250'
                ]);
    
                if($validated->fails()){
                    return $this->sendError(
                        'Validate error',
                        $validated->errors()
                    );
                }

                $updateMenu['gambar'] = $newNameOfImage;
                $menuKaryaTulis->update($updateMenu);
                if($menuKaryaTulis){
                    $path = 'storage/image/karya-tulis/menu/' . $oldImage;
                    if(File::exists($path)){
                        File::delete($path);
                        $request->gambar->move('storage/image/karya-tulis/menu', $newNameOfImage);
                    }
                }
            }

            return $this->sendResponse(
                'Update successfully',
                new MenuKaryaTulisResource($menuKaryaTulis->loadMissing('pembimbing:id'))
            );
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Error found',
                $exception->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $menuKaryaTulis = MenuKaryaTulisModel::findOrFail($id);
            $oldImage = $menuKaryaTulis->gambar;
            $menuKaryaTulis->delete();

            if($menuKaryaTulis){
                $path = 'storage/image/karya-tulis/menu/' . $oldImage;
                if(File::exists($path)){
                    File::delete($path);
                }
            }

            return $this->sendResponse(
                'Delete successfully',
                new MenuKaryaTulisResource($menuKaryaTulis->loadMissing('pembimbing:id'))
            );
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Id not found',
                $exception->getMessage()
            );
        }
    }
}
