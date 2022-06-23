<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Message recipient model
 */
class Recipient extends Model
{

    public const MAX_EMAIL_LENGTH = 30;

    public $table = 'recipients';

    /**
     * @var string[]
     */
    protected $fillable = [
        'role', 'email', 'orderId', 'roleId'
    ];

    protected int $role;

    /**
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'roleId');
    }
}
