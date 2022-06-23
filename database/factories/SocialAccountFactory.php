<?php

namespace Database\Factories;

use App\Models\FrontUser;
use App\Models\SocialNetworkType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nickName' => $this->faker->name,
            'email' => $this->faker->email,
            'socialNetworkUserId' => mt_rand(),
            'socialNetworkId' => SocialNetworkType::factory(),
            'userId' => FrontUser::factory()
        ];
    }
}
