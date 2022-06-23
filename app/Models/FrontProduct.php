<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Collection
 */
class FrontProduct extends Model implements Product
{
    use HasFactory;

    public const MAX_PRODUCT_COUNT = 6;

    public const MAX_NAME_LENGTH = 30;

    public const MAX_DESCRIPTION_LENGTH = 200;

    public const MAX_PRICE = 5000;

    public const PATH_TO_IMAGE = '/var/www/storage/app/public';

    public const MAX_IMAGE_SIZE = 2048;

    /**
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name', 'categoryId', 'imageSrc', 'description', 'price'
        ];

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
    public function getImageSrc(): string
    {
        return $this->getAttribute('imageSrc') ?? "";
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->getAttribute('price') ?? 0;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getAttribute('description') ?? "";
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->getAttribute('categoryId') ?? -1;
    }

    /**
     * @var string
     */
    public $table = 'products';

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FrontCategory::class, 'categoryId', 'id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'productId', 'id');
    }

    /**
     * Receive all products considering category and page number
     *
     * @param  int $offset
     * @param  int $categoryId
     * @return Builder[]|Collection
     */
    public function getAll(int $offset, int $categoryId = -1)
    {
        if ($categoryId == -1) {
            return self::query()->offset($offset * self::MAX_PRODUCT_COUNT)
                ->limit(self::MAX_PRODUCT_COUNT)->get();
        }

        return self::query()->offset($offset * self::MAX_PRODUCT_COUNT)
            ->limit(self::MAX_PRODUCT_COUNT)->where('categoryId', '=', $categoryId)->get();
    }

    /**
     * Receive general amount of products
     *
     * @param  int $categoryId
     * @return int
     */
    public function getCount(int $categoryId = -1): int
    {
        if ($categoryId != -1) {
            return self::query()->where('categoryId', '=', $categoryId)->count();
        }

        return self::query()->count();
    }

}
