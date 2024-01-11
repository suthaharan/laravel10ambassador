<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create($request->only('title', 'description', 'image', 'price'));
        return response($product, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only('title', 'description', 'image', 'price'));
        return response($product, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
       //Product::desctroy();
       $product->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    public function frontend(){
        // Now we are going to cache the products
        if($products = \Cache::get('products_frontend')){
            return $products;
        }
       // sleep(2); //to make it slow

        $products = Product::all();
        \Cache::set('products_frontend', $products, 30*60); //30 minutes cache
        return Product::all();
    }

    public function backend(Request $request){
        $page = $request->input('page', 1);
        // \Cache::forget('products_backend'); // docker-compose exec redis sh and then redis-cli , flushall
        // return \Cache::remember('products_backend', 30 * 60, function(){
        //     return Product::paginate();
        // });

        $products = \Cache::remember('products_backend', 30 * 60, fn() => Product::all());

        if($s = $request->input('s')){
            $products = $products->filter(
                fn(Product $product) => Str::contains($product->title, $s) || Str::contains($product->description, $s)
            );
        }
        if($sort = $request->input('sort')){
            if($sort === 'asc'){
                $products = $products->sortBy([
                    fn($a, $b) => $a['price']  <=> $b['price'] // -1   0   1
                ]);
            }else if($sort === 'desc'){
                $products = $products->sortBy([
                    fn($b, $a) => $a['price']  <=> $b['price'] // -1   0   1
                ]);
            }
        }

        $total = $products->count();
        return [
            'data' => $products->forPage($page, 9)->values(),
            'meta' => [
                'total' => $total,
                'page' => $page,
                'last_page' => ceil($total/9)
            ]
            ];
    }
}
