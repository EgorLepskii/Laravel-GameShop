<?php

namespace Tests\Integration\Controllers;

use App\Models\Category;
use App\Models\FrontCategory;
use App\Models\FrontProduct;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductStoreControllerTest extends \Tests\TestCase
{
    use WithoutMiddleware;

    protected $faker;

    protected Product $product;

    protected Model $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        DB::beginTransaction();

        $this->category = FrontCategory::factory()->create();
        $this->product = FrontProduct::factory()->create() ?? new FrontProduct();
    }


    /**
     * @dataProvider storeIncorrectDataProvider
     * @param        $image
     */
    public function test_store_with_incorrect_data(array $data, ?\Illuminate\Http\Testing\File $file, array $expectedErrors): void
    {
        $this->post(route('product.store', $data), ['image' => $file])->assertSessionHasErrors($expectedErrors);
    }

    /**
     * @return array{empty_fields: array{name: string, description: string, price: string, categoryId: null}[]|string[][]|null[], incorrect_price_type: array{price: string}[]|string[][]|null[], overpricing: array{price: int}[]|string[][]|null[], name_over_length: array{name: string}[]|string[][]|null[], description_over_length: array{description: string}[]|string[][]|null[], incorrect_image_type: \Illuminate\Http\Testing\File[]|never[][]|string[][], incorrect_category_id: array{categoryId: int}[]|string[][]|null[]}
     */
    public function storeIncorrectDataProvider(): array
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
                    'price' => $faker->lexify('???')
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
                null,// UploadedFile::fake()->image('test.cvs', 600, 600),
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
     * Assert, that product model will be stored in database
     * and image will be saved in public storage
     *
     * @dataProvider correctDataProvider
     * @param        $file
     */
    public function testStoreWithCorrectData(array $data, string $fileName): void
    {
        Storage::fake('public');
        $data['categoryId'] = $this->category->getAttribute('id');

        $file = UploadedFile::fake()->image($fileName, 600, 600);

        $this->post(route('product.store', $data), ['image' => $file]);

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
                        'name' => $faker->text(self::STR_LEN_FOR_TESTS),
                        'description' => $faker->text(self::STR_LEN_FOR_TESTS),
                        'price' => $faker->randomFloat(1, 0, FrontProduct::MAX_PRICE),
                    ],
                    'test.png'
                ],

            ];
    }


    public function test_if_entry_already_exists(): void
    {
        $this
            ->post(route('product.store', ['name' => $this->product->getName()]), ['image' => null])
            ->assertSessionHasErrors('name');
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

}
