<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\FrontCategory;
use App\Models\FrontProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use function view;

/**
 * Controller for working with categories
 */
class CategoryController extends Controller
{

    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Routing\Redirector $redirector;

    private \Illuminate\Routing\UrlGenerator $urlGenerator;

    public function __construct(\Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Routing\Redirector $redirector, \Illuminate\Routing\UrlGenerator $urlGenerator)
    {
        $this->viewFactory = $viewFactory;
        $this->redirector = $redirector;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Create new category
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function store(CreateCategoryRequest $createCategoryRequest, FrontCategory $category): \Illuminate\Contracts\View\View
    {
        $input = $createCategoryRequest->only(['name']);
        $category->fill($input)->save();

        return $this->viewFactory->make('admin.success');
    }

    /**
     * Update category
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateCategoryRequest $updateCategoryRequest, FrontCategory $category): \Illuminate\Http\RedirectResponse
    {
        $input = $updateCategoryRequest->only(['name']);
        $category->fill($input)->update();

        return $this->redirector->to($this->urlGenerator->route('home.index'));
    }

    /**
     * Show page to update category
     *
     * @return Application|Factory|View
     */
    public function edit(FrontCategory $category): \Illuminate\Contracts\View\View
    {
        return $this->viewFactory->make('admin.categoryUpdate', ['categoryId' => $category->getAttribute('id')]);
    }


    /**
     * Delete category and products with this category
     *
     * @return Application|Factory|View
     */
    public function destroy(CategoryDeleteRequest $categoryDeleteRequest, FrontCategory $category): \Illuminate\Contracts\View\View
    {
        FrontProduct::query()->where('categoryId', '=', $category->getAttribute('id'))->delete();
        $category->delete();
        return $this->viewFactory->make('admin.success', []);
    }
}
