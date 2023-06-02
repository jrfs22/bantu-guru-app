<?php

namespace App\Http\Controllers\api;

use App\Models\api\AlamatModel;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\api\DataReferensiModel;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends BaseController
{
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required',
            'email' => 'required|email'
        ]);

        // Check email at databases
        $user = User::where('email', $request->email)->where('id', $request->id)->first();
        if(empty($user)){
            
        }else{
            return $user->createToken('login')->plainTextToken();
        }
    }

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|unique:users,id',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|uuid|exists:data_referensi,id',
            'nik' => 'required|min:16|max:16|unique:users,nik',
            'nama_lengkap' => 'required',
            'no_hp' => 'required|min:11',
            'gambar' => 'required',
            'jenis_kelamin_id' => 'required|uuid|exists:data_referensi,id',
            'provinsi_id' => 'required|exists:provinsi,id',
            'kota_id' => 'required|exists:kota,id',
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'kode_pos' => 'required|min:5|max:5'
        ]);

        if($validated->fails()){
            return $this->sendError(
                'Validate error',
                $validated->errors()
            );
        }

        // Variabel tu store data
        $userData = [
            'id' => $request->id,
            'email' => $request->email,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
            'jenis_kelamin_id' => $request->jenis_kelamin_id,
            'role_id' => $request->role_id,
            'gambar' => $request->gambar
        ];

        if($request->exists('gelar_depan')){                        
            $userData['gelar_depan'] = $request->gelar_depan;
        }
        
        if($request->exists('gelar_belakang')){
            $userData['gelar_belakang'] = $request->gelar_belakang;
        }

        $role_id = DataReferensiModel::where('id', $request->role_id)->where('key', 'role_id')->first();
        if(!empty($role_id)){
            if(strtolower($role_id->value) == 'guru'){
                $validated = Validator::make($request->all(), [
                    'instansi' => 'required',
                    'npa_pgri' => 'required|unique:users,npa_pgri',
                    'nuptk' => 'required|unique:users,nuptk|min:16|max:16',
                    'status_pegawai_id' => 'required|uuid|exists:data_referensi,id',
                    'jenis_pegawai_id' => 'required|uuid|exists:data_referensi,id'
                ]);

                if($validated->fails()){
                    return $this->sendError(
                        'Validate error',
                        $validated->errors()
                    );
                }

                // Cek status pegawai id
                if($request->exists('status_pegawai_id')){
                    $statusPegawaiId = DataReferensiModel::where('id', $request->status_pegawai_id)->first();
                    if(!empty($statusPegawaiId)){  
                        if($statusPegawaiId->value == 'PNS'){
                            $validated = Validator::make($request->all(), [
                                'nip' => 'required|min:16|max:16',
                                'golongan_id' => 'required|uuid|exists:data_referensi,id'
                            ]);

                            if($validated->fails()){
                                return $this->sendError(
                                    'Validate error',
                                    $validated->errors()
                                );
                            }

                            // Check golongan ID
                            $golongan_id = DataReferensiModel::where('id', $request->golongan_id)->where('key' ,'golongan_id')->first();

                            if(empty($golongan_id)){
                                return $this->sendError(
                                    'Golongan id not found',
                                );
                            }
                        }
                    }else{
                        return $this->sendError(
                            'status_pegawai_id not found or data not uuid'
                        );
                    }
                }
                // Check jenis_pegawai_id
                if($request->exists('jenis_pegawai_id')){
                    $jenisPegawaiId = DataReferensiModel::where('id', $request->jenis_pegawai_id)->where('key', 'jenis_pegawai_id')->first();
                    
                    if(empty($jenisPegawaiId)){
                        return $this->sendError(
                            'jenis pegawai not found'
                        );
                    }
                }

                $userData += [
                    'npa_pgri' => $request->npa_pgri,
                    'nip' => $request->nip,
                    'nuptk' => $request->nuptk,
                    'status_pegawai_id' => $request->status_pegawai_id,
                    'jenis_pegawai_id' => $request->jenis_pegawai_id,
                    'golongan_id' => $request->golongan_id,
                    'instansi' => $request->instansi,
                    'no_hp' => $request->no_hp
                ];                
            }

            try{
                $newUser = User::create($userData);
                if($newUser){
                    // Create alamat
                    $alamat = AlamatModel::create([
                        'user_id'=> $request->id,
                        'kecamatan_id'=> $request->kecamatan_id,
                        'kota_id'=> $request->kota_id,
                        'provinsi_id'=> $request->provinsi_id,
                        'detail_alamat'=> $request->detail_alamat,
                        'kode_pos'=> $request->kode_pos
                    ]);
                }

                return $this->sendResponse(
                    $newUser,
                    Response::HTTP_OK
                );
            }catch(QueryException $exception){
                return $this->sendError(
                    'Create new user failde',
                    $exception->getMessage()
                );
            }
        }else{
            return $this->sendError(
                'Role id not found'
            );
        }
    }
}
