<?php

namespace App\Http\Controllers;

use App\Mail\ConviteClinica;
use App\Models\UserInvites;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;

class UserInviteController extends Controller
{
    public function envioConviteClinica(Request $request)
    {
        try {
            $userInvite = new UserInvites();

            $userInvite->name = $request->name;
            $userInvite->email = $request->email;
            $userInvite->role = $request->role;
            $userInvite->expires_at = Carbon::now()->addDay();
            $userInvite->token = Str::random(30);
            $userInvite->clinica_id = auth()->user()->clinica->id;
            $userInvite->save();

            Mail::to($userInvite->email)->send(
                new ConviteClinica(
                    $userInvite->name,
                    auth()->user()->clinica->nome_clinica,
                    config('app.url') . "/criar-conta-convite/$userInvite->token",
                    $userInvite->expires_at->format('d/m/Y H:i')
                )
            );
            return back()->with('success',"Convite enviado com sucesso!");
        } catch (\Exception $th) {
            return back()->with("error",$th->getMessage());
        }
    }
}
