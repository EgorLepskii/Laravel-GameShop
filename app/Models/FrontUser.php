<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin Model
 * @mixin Collection
 */
class FrontUser extends Authenticatable implements MustVerifyEmail, User
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public $table = 'users';
    /**
     * Override email confirmation to use queue
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\Auth\QueuedVerifyEmail);
    }


    protected Order $order;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'isAdmin', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'userId', 'id');
    }

    /**
     * Get user products
     *
     * @return array
     */
    public function products(): array
    {
        $products = [];

        foreach ($this->orders()->get() as $order) {
            $this->order = $order;
            $products[] = $this->order->product()->first();
        }

        return $products ?? [];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id') ?? -1;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name') ?? "";
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getAttribute('email') ?? "";
    }
}
