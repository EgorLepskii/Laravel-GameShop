<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderRecipientRole extends Role
{
    /**
     * Get model from roles that describe recipient role
     *
     * @return Builder|Model|object|null
     */
    public static function get()
    {
        return self::query()->where('type', '=', self::ROLES['RECIPIENT_ROLE'])->first();
    }

    /**
     * @return int
     */
    public static function getType(): int
    {
        return self::ROLES['RECIPIENT_ROLE'];
    }
}
