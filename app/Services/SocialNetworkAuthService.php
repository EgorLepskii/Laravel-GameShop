<?php

namespace App\Services;


use App\Models\SocialAccount;
use App\Models\FrontUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SocialNetworkAuthService
{

    protected ?SocialAccount $socialAccount;


    /**
     * This function divide logic to situations, if social account with
     * received social network user id and social network type exists or not exists
     *
     * @param  \Laravel\Socialite\Contracts\User $socialNetworkUser
     * @param  int                               $socialNetworkTypeId
     * @return FrontUser|Builder|Model|HasOne|object|null
     */
    public function login(\Laravel\Socialite\Contracts\User $socialNetworkUser, int $socialNetworkTypeId)
    {
        $email = $socialNetworkUser->getEmail();
        $id = $socialNetworkUser->getId();
        $nickName = $socialNetworkUser->getNickname();

        $this->socialAccount = SocialAccount::query()
            ->where('socialNetworkUserId', '=', $id)
            ->where('socialNetworkId', '=', $socialNetworkTypeId)
            ->first();

        if ($this->socialAccount) {
            return $this->loginIfExists($email, $nickName);
        }

        return $this->loginIfNotExists($nickName, $id, $email, $socialNetworkTypeId);
    }

    /**
     * Logic for situations, if received social account exists.
     * If received email is empty, function will return user for login.
     * If received email is not empty, function will check, if user with
     * this social account have email. If user doesn't have email, received email
     * will be set to this user. If user already have email, his data will not be updated
     *
     * @param  string|null $email
     * @return FrontUser|Builder|Model|HasOne|object|null
     */
    protected function loginIfExists(?string $email)
    {
        $user = $this->socialAccount->user()->first();

        if (!empty($email)) {
            $userEmail = $user->getAttribute('email');

            if (!$userEmail) {
                $user->update(['email' => $email, 'email_verified_at' => time()]);
                return $user;
            }
        }


        return $user;

    }

    /**
     * Function for situations, if social account with received social network user id is not exists.
     * If received email is empty, user with empty email will be created. Social account will be linked to him.
     * If received email is not empty, function will check, if user with such email exists.
     * If user exists, new social account will be linked to him. If user does not exist,
     * it will be created and social account will be linked to him.
     *
     * @param  string      $nickName
     * @param  string      $socialNetworkUserId
     * @param  string|null $email
     * @param  int         $socialNetworkTypeId
     * @return FrontUser|Builder|Model|object|null
     */
    protected function loginIfNotExists(
        string  $nickName,
        string  $socialNetworkUserId,
        ?string $email,
        int     $socialNetworkTypeId
    ) {
        $this->socialAccount = new SocialAccount(
            [
                'nickName' => $nickName,
                'socialNetworkUserId' => $socialNetworkUserId,
                'socialNetworkId' => $socialNetworkTypeId,
                'email' => $email
            ]
        );


        if ($email) {
            $user = FrontUser::query()->where('email', '=', $email)->first();

            if (!$user) {
                $user = new FrontUser(['email' => $email, 'email_verified_at' => time()]);
                $user->save();

            }

            $this->socialAccount->setAttribute('userId', $user->getAttribute('id'));
            $this->socialAccount->save();
            return $user;
        }

        $user = new FrontUser();
        $user->save();
        $this->socialAccount->setAttribute('userId', $user->getAttribute('id'));
        $this->socialAccount->save();

        return $user;
    }


}
