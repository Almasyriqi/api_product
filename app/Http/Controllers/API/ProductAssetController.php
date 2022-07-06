<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_asset;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductAssetController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'image' => 'required',
        ]);

        $product = Product::where('id', $request->product_id)->first();

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
                $product_asset->product_id = $request->product_id;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_asset = Product_asset::find($id);
        try {
            $product_asset->delete();
            return $this->apiSuccess(['Product asset Deleted'], 200, 'Success Delete Product asset');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }
}
