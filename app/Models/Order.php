<?php

namespace App\Models;

use App\Models\Product\IProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * Модель заказа
 */
class Order extends Model
{

    public const MAX_ORDERS_SHOW_COUNT = 6;
    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name', 'productId', 'userId'
        ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(FrontUser::class, 'userId', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(FrontProduct::class, 'productId', 'id');
    }

    /**
     * Receive total price of products in user basket
     *
     * @param  int $userId
     * @return int
     */
    public static function getGeneralPrice(int $userId): int
    {
        $price = DB::selectOne(
            sprintf(
                'SELECT SUM(products.price) as generalPrice
                           FROM orders JOIN products ON orders.productId = products.id
                              WHERE userId = %s', $userId
            )
        );

        return !isset($price->generalPrice) ? 0 : $price->generalPrice;

    }
}
