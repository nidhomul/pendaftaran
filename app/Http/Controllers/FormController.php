<?php

namespace App\Http\Controllers;

use App\Models\MstrKridaSakaMilenial;
use App\Models\MstrKwarran;
use App\Models\MstrScoutLevel;
use App\Models\TrParticipants;
use App\Models\TrParticipantsRegistrationStatus;
use App\Models\User;
use Illuminate\Http\Request;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            // * Admin

            $trParticipants = TrParticipants::with('trParticipantsRegistrationStatus')
            ->orderBy('created_at','DESC')
            ->get();

            return view('pages.admin.form.form', [
                'sb_open' => '',
                'sb_active' => 'form',
                'participants' => $trParticipants
            ]);
        }
        // * User

        $trParticipants = TrParticipants::with('mstrKwarran','mstrScoutLevel','mstrKridaSakaMilenial','trParticipantsRegistrationStatus')
        ->where('id',auth()->user()->participant_id)
        ->first();

        return view('pages.user.form.form', [
            'sb_open' => '',
            'sb_active' => 'form',
            'participants' => $trParticipants
        ]);
    }

    public function detail($id)
    {
        $trParticipants = TrParticipants::with('mstrKwarran','mstrScoutLevel','mstrKridaSakaMilenial','trParticipantsRegistrationStatus')
        ->where('id',$id)
        ->first();

        $mstrKwarran = MstrKwarran::where('is_deleted',0)->get();
        $mstrScoutLevel = MstrScoutLevel::where('is_deleted',0)->get();
        $mstrKridaSakaMilenial = MstrKridaSakaMilenial::where('is_deleted',0)->get();

        return view('pages.admin.form.detail', [
            'sb_open' => '',
            'sb_active' => 'form',
            'participants' => $trParticipants,
            'kwarran' => $mstrKwarran,
            'scout_level' => $mstrScoutLevel,
            'krida_saka_milenial' => $mstrKridaSakaMilenial
        ]);
    }

    public function accept(Request $request)
    {
        try {
            try {
                $id = Uuid::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
            }

            $trParticipantsRegistrationStatus = TrParticipantsRegistrationStatus::where('participant_id',$request->id)->first();

            if ($trParticipantsRegistrationStatus) {
                // * Update
                TrParticipantsRegistrationStatus::where('participant_id',$request->id)
                ->update([
                    'status' => 1,
                    'updated_by' => auth()->user()->email
                ]);
            } else {
                // * Insert
                TrParticipantsRegistrationStatus::create([
                    'id' => $id,
                    'participant_id' => $request->id,
                    'status' => 1,
                    'created_by' => auth()->user()->email
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Peserta pendaftaran berhasil diterima'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function reject(Request $request)
    {
        try {
            try {
                $id = Uuid::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);
            }

            $trParticipantsRegistrationStatus = TrParticipantsRegistrationStatus::where('participant_id',$request->id)->first();

            if ($trParticipantsRegistrationStatus) {
                // * Update
                TrParticipantsRegistrationStatus::where('participant_id',$request->id)
                ->update([
                    'status' => 0,
                    'updated_by' => auth()->user()->email
                ]);
            } else {
                // * Insert
                TrParticipantsRegistrationStatus::create([
                    'id' => $id,
                    'participant_id' => $request->id,
                    'status' => 0,
                    'created_by' => auth()->user()->email
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Peserta pendaftaran berhasil ditolak'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $trParticipants = TrParticipants::where('id',$id)->first();

            $data1 = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'gender' => (int)$request->gender,
                'birth_place' => $request->birth_place,
                'birth_date' => date('Y-m-d', strtotime($request->birth_date)),
                'pangkalan_gudep' => $request->pangkalan_gudep,
                'kwarran_id' => $request->kwarran,
                'nik' => $request->nik,
                'nta_pramuka_nis_nim' => $request->nta_pramuka_nis_nim,
                'scout_level_id' => $request->scout_level,
                'krida_saka_milenial_id' => $request->krida_saka_milenial,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'facebook' => $request->facebook,
                'tiktok' => $request->tiktok,
                'updated_by' => auth()->user()->email
            ];

            $updateArray = $data1;

            $kk_original_filename = null;
            $kk_filename = null;
            $ktp_original_filename = null;
            $ktp_filename = null;

            if ($request->hasFile('kk_file')) {
                $kk_file = $request->file('kk_file');
                $kk_original_filename = $kk_file->getClientOriginalName();
                $kk_filename = date('YmdHis').'_kk_'.$kk_original_filename;
                $kk_file->storeAs('public/registration/', $kk_filename);

                try {
                    unlink(public_path('storage/registration/'.$trParticipants->kk_filename));
                } catch (\Throwable $th) {
                }

                $updateArray = array_merge($data1, [
                    'kk_original_filename' => $kk_original_filename,
                    'kk_filename' => $kk_filename,
                ]);
            }

            if ($request->hasFile('ktp_file')) {
                $ktp_file = $request->file('ktp_file');
                $ktp_original_filename = $ktp_file->getClientOriginalName();
                $ktp_filename = date('YmdHis').'_ktp_'.$ktp_original_filename;
                $ktp_file->storeAs('public/registration/', $ktp_filename);

                try {
                    unlink(public_path('storage/registration/'.$trParticipants->ktp_filename));
                } catch (\Throwable $th) {
                }

                $updateArray = array_merge($data1, [
                    'ktp_original_filename' => $ktp_original_filename,
                    'ktp_filename' => $ktp_filename,
                ]);
            }

            TrParticipants::where('id',$id)
            ->update($updateArray);

            User::where('participant_id',$id)
            ->update([
                'name' => $request->full_name,
                'email' => $request->email
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
