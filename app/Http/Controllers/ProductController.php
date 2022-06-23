<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\FrontCategory;
use App\Models\FrontProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

class ProductController extends Controller
{
    private \Illuminate\Contracts\View\Factory $viewFactory;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Update product
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function update(UpdateProductRequest $productRequest, FrontProduct $product): \Illuminate\Contracts\View\View
    {
        $upload = $productRequest->file('image');
        $file = $upload ? $this->getFileName($upload->store('public')) : $product->getImageSrc();
        $input = $productRequest->input();
        $input['imageSrc'] = $file ;

        $product->fill($input)->update();

        return $this->viewFactory->make('admin.success', []);
    }


    /**
     * Show page to edit product
     *
     * @return Application|Factory|View
     */
    public function edit(FrontProduct $product): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.productUpdate', ['product' => $product, 'categories' => FrontCategory::all()]);
    }

    /**
     * Destroy product
     *
     * @return Application|Factory|View
     */
    public function destroy(DeleteProductRequest $deleteProductRequest, FrontProduct $product): \Illuminate\Contracts\View\View
    {
        $product->delete();

        return $this->viewFactory->make('admin.success', []);
    }


    /**
     * Create new product
     *
     * @param ProductRequest $productRequest
     * @return Application|Factory|View
     */
    public function store(ProductRequest $productRequest): \Illuminate\Contracts\View\View
    {
        $product = new FrontProduct();
        $input = $productRequest->only(['productId', 'name', 'description', 'price', 'categoryId']);
        $fileName = $this->getFileName($productRequest->file('image')->store('public'));
        $input['imageSrc'] = $fileName;

        $product->fill($input)->save();

        return $this->viewFactory->make('admin.success');
    }


    /**
     * Show page with product
     *
     * @return Application|Factory|View
     */
    public function show(FrontProduct $product): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('product', ['product' => $product]);
    }
}
