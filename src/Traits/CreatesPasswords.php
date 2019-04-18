<?php

namespace App\Traits;

use App\Mail\UserConfirmAdmin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

trait CreatesPasswords
{
    /**
     * Reset the given user's password.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function createPassword(Request $request)
    {
        $request->validate(
            [
                'token'    => 'required',
                'password' => 'required|confirmed|min:6',
            ],
            $this->validationErrorMessages()
        );

        $reset = DB::table('password_resets')->where('email', $request->email)->first();
        $token = $request->token;

        if (Hash::check($token, $reset->token)) {
            $user = User::where('email', $request->email)->first();
            $this->resetPassword($user, $request->password, false);
            $this->makeUserVerified($user);
            $this->sendAdminEmail($user);
        }

        return redirect('/');
    }

    /**
     * @param User $user
     *
     */
    public function makeUserVerified($user)
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function sendAdminEmail($user)
    {
        $userCreated = $user->createdBy;

        if (!$userCreated) {
            return false;
        }

        $operator = $user->villages->first()->operator;

        Mail::to($userCreated)
            ->send(
                new UserConfirmAdmin(
                    $userCreated->first_name,
                    $user->fullName(),
                    ($operator) ? $operator->name : ''
                )
            );
    }
}
