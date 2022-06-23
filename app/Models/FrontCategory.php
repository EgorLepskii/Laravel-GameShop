<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель категории
 */
class FrontCategory extends Model implements Category
{
    use HasFactory;
    public const MAX_SHOW_COUNT = 10;

    public const MAX_NAME_LENGTH = 20;

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'id'
        ];

    /**
     * @var string
     */
    public $table = "categories";

    public function getName(): string
    {
        return $this->getAttribute('name') ?? "";
    }
}
