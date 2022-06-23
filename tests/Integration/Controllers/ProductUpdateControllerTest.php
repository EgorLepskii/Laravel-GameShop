<?php

namespace Tests\Integration\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Admin;
use App\Models\Category;
use App\Models\FrontCategory;
use App\Models\FrontProduct;
use App\Models\FrontUser;
use App\Models\Product;
use App\Models\User;
use Facade\FlareClient\Truncation\AbstractTruncationStrategy;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductUpdateControllerTest extends \Tests\TestCase
{
    protected $faker;

    protected Model $product;

    protected Model $category;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();

        DB::beginTransaction();

        $this->category = FrontCategory::factory()->create();
        $this->category->save();

        $this->product = self::createProduct($this->category->getAttribute('id'));
        $this->product->save();

        $this->user = FrontUser::factory()->create(['isAdmin' => true]) ?? new FrontUser();

    }


    /**
     * @dataProvider updateIncorrectDataProvider
     * @param        $image
     */
    public function test_update_with_incorrect_data(array $data, ?\Illuminate\Http\Testing\File $file, array $expectedErrors): void
    {
        $this->withoutMiddleware();

        $data['product'] = $this->product->getId();
        $this->post(route('product.update', $data), ['image' => $file])->assertSessionHasErrors($expectedErrors);
    }

    /**
     * @return array{empty_fields: array{name: string, description: string, price: string, categoryId: null}[]|string[][]|null[], incorrect_price_type: array{price: string}[]|string[][]|null[], overpricing: array{price: int}[]|string[][]|null[], name_over_length: array{name: string}[]|string[][]|null[], description_over_length: array{description: string}[]|string[][]|null[], incorrect_image_type: \Illuminate\Http\Testing\File[]|never[][]|string[][], incorrect_category_id: array{categoryId: int}[]|string[][]|null[]}
     */
    public function updateIncorrectDataProvider(): array
    {
        $faker = Factory::create();
        return [
            'empty_fields' => [
                [
                    'name' => '',
                    'description' => '',
                    'price' => '',
                    'categoryId' => null

                ],
                null,
                [
                    'name', 'description', 'price', 'categoryId'
                ]
            ],

            'incorrect_price_type' => [
                [
                    'price' => $faker->text(self::STR_LEN_FOR_TESTS)
                ],
                null,
                [
                    'price'
                ]
            ],
            'overpricing' => [
                [
                    'price' => FrontProduct::MAX_PRICE + 1
                ],
                null,
                [
                    'price'
                ]
            ],

            'name_over_length' => [
                [
                    'name' => $faker->lexify(str_repeat('?', FrontProduct::MAX_NAME_LENGTH + 1))
                ],
                null,
                [
                    'name'
                ]
            ],

            'description_over_length' => [
                [
                    'description' => $faker->lexify(str_repeat('?', FrontProduct::MAX_DESCRIPTION_LENGTH + 1))
                ],
                null,
                [
                    'description'
                ]
            ],
            'incorrect_image_type' => [
                [
                ],
                null,//UploadedFile::fake()->image('test.cvf', 600, 600),
                [
                    'image'
                ]
            ],

            'incorrect_category_id' => [
                [
                    'categoryId' => -1
                ],
                null,
                [
                    'categoryId'
                ]
            ],

        ];
    }


    /**
     * Assert, that product model will be updated in database
     * and image will be saved in public storage
     *
     * @dataProvider correctDataProvider
     * @param        array<string, string>|array<string, int>|array<string, float> $data
     */
    public function testUpdateWithCorrectData(array $data, string $fileName): void
    {

        auth()->login($this->user); // cannot unable middleware for admin
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');
        $file = UploadedFile::fake()->image($fileName, 600, 600);

        $data['categoryId'] = $this->category->getAttribute('id');
        $data['product'] = $this->product->getId();
        $data['image'] = $file;

        $this->post(route('product.update', ['product' => $data['product']]), $data);

        $product = FrontProduct::query()->where('name', '=', $data['name'])->first();

        $this->assertEquals($data['name'], $product->getAttribute('name'));

        $fileName = $product->getAttribute('imageSrc');

        //$this->assertFileExists(FrontProduct::PATH_TO_IMAGE . "/" . $fileName);

        //unlink(FrontProduct::PATH_TO_IMAGE . "/" . $fileName);

    }

    /**
     * @return array{correct_data: array{name: string, description: string, price: int}[]|string[], price_as_float: array{name: string, description: string, price: float}[]|string[]}
     */
    public function correctDataProvider(): array
    {
        $faker = Factory::create();

        return
            [
                'correct_data' => [
                    [
                        'name' => $faker->text(self::STR_LEN_FOR_TESTS),
                        'description' => $faker->text(self::STR_LEN_FOR_TESTS),
                        'price' => FrontProduct::MAX_PRICE,
                    ],
                    'test.png'

                ],

                'price_as_float' => [
                    [
                        'name' => $faker->text(FrontProduct::MAX_NAME_LENGTH),
                        'description' => $faker->text(FrontProduct::MAX_NAME_LENGTH),
                        'price' => $faker->randomFloat(1, 0, FrontProduct::MAX_PRICE),
                    ],
                    'test.png'
                ],

            ];
    }

    /**
     * Assert, that there will not be error during updating product with name, that
     * correspond to current model name
     *
     * @return void
     */
    public function test_if_name_is_same()
    {
        auth()->login($this->user); // cannot unable middleware for admin
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $product = self::createProduct($this->category->getAttribute('id'));
        $product->save();
        $fileName = "test.png";

        Storage::fake('public');
        $file = UploadedFile::fake()->image($fileName, 600, 600);

        $data = [
            'name' => $product->getName(),
            'description' => $this->faker->text(FrontProduct::MAX_DESCRIPTION_LENGTH),
            'price' => FrontProduct::MAX_PRICE,
            'categoryId' => $this->category->getAttribute('id'),
            'image' => $file
        ];


        $this->post(route('product.update', ['product' => $product->getId()]), $data)
            ->assertSessionDoesntHaveErrors();
    }

    /**
     * Assert, that session will have errors if received product name will already exist in database
     *
     * @return void
     */
    public function test_if_name_exists()
    {
        auth()->login($this->user); // cannot unable middleware for admin
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $product = self::createProduct($this->category->getAttribute('id'));
        $product->save();
        $otherProduct = self::createProduct($this->category->getAttribute('id'));
        $otherProduct->save();


        $fileName = "test.png";

        Storage::fake('public');
        $file = UploadedFile::fake()->image($fileName, 600, 600);

        $data = [
            'name' => $otherProduct->getName(),
            'description' => $this->faker->text(FrontProduct::MAX_DESCRIPTION_LENGTH),
            'price' => FrontProduct::MAX_PRICE,
            'categoryId' => $this->category->getAttribute('id'),
            'image' => $file,
            'product' => $product->getId()
        ];

        $this->post(route('product.update', ['product' => $product->getId()]), $data)
            ->assertSessionHasErrors();

    }


    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

}
