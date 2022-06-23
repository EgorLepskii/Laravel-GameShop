<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public $table = 'roles';

    protected int $role;

    public const MAX_NAME_LENGTH = 30;

    public const ROLES = [
        'RECIPIENT_ROLE' => 0
    ];

    public $fillable = [
        'name', 'type'
    ];

    /**
     * @return HasMany
     */
    public function recipients():hasMany
    {
        return $this->hasMany(Recipient::class, 'roleId', 'id');
    }
}
