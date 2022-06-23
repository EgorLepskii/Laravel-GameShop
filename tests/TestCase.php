<?php

namespace Tests;

use App\Models\FrontCategory;
use App\Models\Order;
use App\Models\FrontProduct;
use App\Models\Recipient;
use App\Models\SocialAccount;
use App\Models\SocialNetworkType;
use App\Models\FrontUser;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var int
     */
    protected const STR_LEN_FOR_TESTS = 20;

    protected  $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Factory::create();
    }

    /**
     * Create FrontProduct entry with random attributes(except category id)
     */
    public function createProduct(int $categoryId): FrontProduct
    {
        return new FrontProduct(
            [
                'name' => $this->faker->text(self::STR_LEN_FOR_TESTS),
                'description' => $this->faker->text(self::STR_LEN_FOR_TESTS),
                'categoryId' => $categoryId,
                'imageSrc' => '',
                'price' => FrontProduct::MAX_PRICE
            ]
        );
    }

    public function creatreOrder(int $userId, int $productId): Order
    {
        return new Order(
            [
                'userId' => $userId,
                'productId' => $productId
            ]
        );
    }

    public function createRecipient(int $roleId): \App\Models\Recipient
    {
        return new Recipient(
            [
              'email' => $this->faker->email,
              'roleId' => $roleId
            ]
        );
    }

    /**
     * Get SocialAccount instance with random attributes
     *
     * @param  int $socialNetworkId
     * @param  int $userId
     * @return SocialAccount
     */
    public function createSocialAccount(
        int $socialNetworkId,
        int $userId
    ) {
        $nickName = $this->faker->name;
        $email = $this->faker->email;
        $socialNetworkUserId = mt_rand(0, PHP_INT_MAX);

        return new SocialAccount(
            [
                'nickName' => $nickName,
                'email' => $email,
                'socialNetworkUserId' => $socialNetworkUserId,
                'socialNetworkId' => $socialNetworkId,
                'userId' => $userId
            ]
        );
    }

    /**
     * @return SocialNetworkType
     */
    public function createSocialNetworkType()
    {
        $name = $this->faker->name;

        return new SocialNetworkType(
            [
                'name' => $name
            ]
        );
    }

}
