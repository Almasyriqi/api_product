<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_asset;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = Product::with('product_asset')->get();
            return $this->apiSuccess($products, 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->name);
        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required',
            'price' => 'required|integer',
        ]);

        $product = new Product($request->all());
        $category = Category::where('id', $request->category_id)->first();
        $product->category()->associate($category);

        $product->save();

        if (!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $allowedfileExtension = ['pdf', 'jpg', 'png'];
        $files = $request->file('image');

        foreach ($files as $file) {

            $extension = $file->getClientOriginalExtension();

            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $path = $file->store('public/images');
                $name = $file->getClientOriginalName();

                //store image file into directory and db
                $product_asset = new Product_asset();
                $product_asset->product_id = $product->id;
                $product_asset->image = $name;
                $product_asset->save();
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
        }
        try {
            return $this->apiSuccess($product->load('product_asset'), 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('product_asset')->where('id', $id)->get();
        try {
            return $this->apiSuccess($product, 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $request['slug'] = Str::slug($request->name);
        $request->validate([
            'category_id' => 'integer',
            'name' => 'string',
            'price' => 'integer',
        ]);

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->price = $request->price;

        $category = Category::where('id', $request->category_id)->first();
        $product->category()->associate($category);

        try {
            $product->save();
            return $this->apiSuccess($product, 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Product_asset::where('product_id', $id)->delete();
        $product = Product::find($id);
        $product->delete();

        try {
            return $this->apiSuccess(['Product Deleted'], 200, 'Success Delete Product');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }

    public function orderByPrice()
    {
        try {
            $products = Product::orderBy('price', 'desc')->get();
            return $this->apiSuccess($products, 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }
}
