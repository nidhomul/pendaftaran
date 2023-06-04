<?php

namespace App\Http\Controllers;

use App\Models\MstrKridaSakaMilenial;
use App\Models\MstrKwarran;
use App\Models\TrParticipants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            // * Admin
            return view('pages.admin.profile.profile', [
                'sb_open' => '',
                'sb_active' => ''
            ]);
        }
        // * User

        $mstrKwarran = MstrKwarran::where('is_deleted',0)->get();
        $mstrKridaSakaMilenial = MstrKridaSakaMilenial::where('is_deleted',0)->get();

        $trParticipants = TrParticipants::select('pangkalan_gudep','kwarran_id','krida_saka_milenial_id','phone_number') 
        ->where('id',auth()->user()->participant_id)
        ->first();

        return view('pages.user.profile.profile', [
            'sb_open' => '',
            'sb_active' => '',
            'kwarran' => $mstrKwarran,
            'krida_saka_milenial' => $mstrKridaSakaMilenial,
            'participants' => $trParticipants
        ]);
    }

    public function updateUser(Request $request)
    {
        try {
            if ($request->password) {
                // * update password
                User::where('id',auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                // * don't update password
                User::where('id',auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
            }

            // * update participants data
            if (auth()->user()->participant_id) {
                TrParticipants::where('id',auth()->user()->participant_id)
                ->update([
                    'full_name' => $request->name,
                    'email' => $request->email,
                    'pangkalan_gudep' => $request->pangkalan_gudep,
                    'kwarran_id' => $request->kwarran,
                    'krida_saka_milenial_id' => $request->krida_saka_milenial,
                    'phone_number' => $request->phone_number,
                    'updated_by' => auth()->user()->email
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateAdmin(Request $request)
    {
        try {
            if ($request->password) {
                // * update password
                User::where('id',auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                // * don't update password
                User::where('id',auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
            }

            // * update participants data
            if (auth()->user()->participant_id) {
                TrParticipants::where('id',auth()->user()->participant_id)
                ->update([
                    'full_name' => $request->name,
                    'email' => $request->email,
                    'updated_by' => auth()->user()->email
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
