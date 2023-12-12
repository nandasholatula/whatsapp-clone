<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Models\User;
use App\Models\UserCred;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function userApproval()
    {
        $users = User::role('user')->get();
        $creds = Credential::all();
        $userCreds = [];
        foreach ($users as $usr) {
            $userc = UserCred::with('user', 'credential')->where('user_id', $usr->id)->first();
            $usr->cred = isset($userc->credential_id) ? $userc->credential_id : null;
            $usr->active = isset($userc->active) ? $userc->active : null;
            array_push($userCreds, $usr);
        }

        return response()->json(['creds' => $creds, 'users' => $userCreds]);
    }

    public function assignUser(Request $request)
    {
        $user = UserCred::updateOrCreate([
            "user_id" => isset($request->user) ? $request->user : auth()->id()
        ], [
            "credential_id" => $request->cred,
            "active" => false
        ]);
        return response($user, 201);
    }

    public function requestCred(Request $request)
    {
        $user = UserCred::updateOrCreate([
            "user_id" => isset($request->user) ? $request->user : auth()->id()
        ], [
            "credential_id" => $request->cred,
            "active" => false
        ]);
        return back();
    }

    public function activeUser($id)
    {
        $user = UserCred::where('user_id', $id)->first();
        $user->update(['active' => !$user->active]);
        return response($user, 200);
    }
}
