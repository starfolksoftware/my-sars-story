<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use DB;

class ProductController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse
  {
    $publishedCount = Product::published()->count();
    $draftCount = Product::draft()->count();
    $approvedCount = Product::approved()->count();
    $submittedCount = Product::submitted()->count();

    $results = [
      'products' => [],
      'draftCount' => $draftCount,
      'publishedCount' => $publishedCount,
      'submittedCount' => $submittedCount,
      'approvedCount' => $approvedCount,
    ];

    if (request()->query('productType') == 'draft') {
      $products = Product::draft();
    } else if (request()->query('productType') == 'forApproval') {
      $products = Product::submitted();
    } else if (request()->query('productType') == 'approved') {
      $products = Product::approved();
    } else {
      $products = Product::published();
    }

    $results['products'] = $products->latest()
      ->with('user')
      ->with('approvedBy')
      ->paginate();

    return response()->json($results, 200);
  }

  /**
   * Get a single product or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    $containsId = Product::pluck('id')->contains($id);

    if ($containsId || $this->isNewProduct($id)) {
      if ($this->isNewProduct($id)) {
        $statement = DB::select("SHOW TABLE STATUS LIKE 'products'");
        return response()->json([
          'product' => Product::make([
            'id' => $statement[0]->Auto_increment,
            'name' => '',
            'description' => '',
            'user_id' => '',
          ])
        ], 200);
      } else {
        $product = Product::with('user')->find($id);

        return response()->json([
          'product' => $product
        ], 200); 
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a product.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'description' => request('description'),
      'marketing' => request('marketing'),
      'features' => request('features'),
      'logo' => request('logo'),
      'external_link' => request('external_link'),
      'submitted_at' => request('submitted_at'),
      'approved_at' => request('approved_at'),
      'approved_by' => request('approved_by'),
      'published_at' => request('published_at'),
      'user_id' => $id === 'create' ? request()->user()->id : request('user_id'),
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'user_id' => 'required'
    ], $messages)->validate();

    $product = Product::firstOrNew([
      'id' => $id
    ]);

    $product->fill($data);
    $product->save();

    return response()->json($product->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $product = Product::find($id);

    if ($product) {
      $product->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new product.
   *
   * @param string $id
   * @return bool
   */
  private function isNewProduct(string $id): bool
  {
    return $id === 'create';
  }
}
