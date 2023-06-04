<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\api\PembimbingKaryaTulisModel;
use App\Http\Resources\PembimbingKaryaTulisResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PembimbingKaryaTulisController extends BaseController
{
    public function index()
    {
        try {
            $pembimbing = PembimbingKaryaTulisModel::all();
            $dataPembimbing = PembimbingKaryaTulisResource::collection($pembimbing);
            if(count($pembimbing) == 0){
                return $this->sendResponse(
                    $dataPembimbing,
                    'Table has no data'
                );
            }else{
                return $this->sendResponse(
                    $dataPembimbing,
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

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pembimbing_menu_id' => 'required|exists:menu_pembimbing_karya_tulis,id'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        try {
            // Check double data
            if(PembimbingKaryaTulisModel::where('user_id', $request->user_id)->where('pembimbing_menu_id', $request->pembimbing_menu_id)->exists()){
                return $this->sendError(
                    'Data exists'
                );
            }
            $pembimbing = PembimbingKaryaTulisModel::create([
                'user_id' => $request->user_id,
                'pembimbing_menu_id' => $request->pembimbing_menu_id
            ]);

            if($pembimbing){
                return $this->sendResponse(
                    new PembimbingKaryaTulisResource($pembimbing),
                    'Created data successfully'
                );
            }
        } catch (ModelNotFoundException | QueryException $exception) {
            return $this->sendError(
                'Failed to create pembimbing',
                $exception->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $pembimbing = PembimbingKaryaTulisModel::findOrFail($id);
            $pembimbing->delete();
            if($pembimbing){
                return $this->sendResponse(
                    new PembimbingKaryaTulisResource($pembimbing),
                    'Delete successfully'
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
