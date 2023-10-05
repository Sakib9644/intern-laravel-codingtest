<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

         if ($request->filled('search')) {
             $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->get();

        return view('product.view', compact('products'));
    }

    
    
     // Existing methods...
    
        /**
         * Search for products based on a keyword.
         *
         * @param  Request  $request
         * @return \Illuminate\Http\Response
         */
       

        // ...
        
        public function filterProducts(Request $request): JsonResponse
        {
            $keyword = $request->input('keyword');
        
            $query = Product::query();
        
            if ($keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            }
        
            $products = $query->get();
        
            return response()->json(['products' => $products]);
        }
        
    }