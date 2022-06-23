<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SocialAccount extends Model
{
    use HasFactory;

    public $table = 'social_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickName',
        'email',
        'socialNetworkUserId',
        'socialNetworkId',
        'userId'
    ];

    /**
     * @return HasOne
     */
    public function user(): hasOne
    {
        return $this->hasOne(FrontUser::class, 'id', 'userId');
    }

}
