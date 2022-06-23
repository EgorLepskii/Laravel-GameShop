<?php

namespace App\Http\Controllers;

use App\Models\FrontProduct;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    public function index(Request $request)
    {
        $productName = $request->input('productName');

        $data = FrontProduct::query()->where('name','like', "%$productName%")->get();

        return response()->json([$data->toArray()]);
    }
}
