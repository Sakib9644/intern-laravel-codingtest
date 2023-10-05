<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
        public function searchProduct(Request $request)
        {
            // Get the search keyword from the request
            $keyword = $request->input('keyword');
        
            // Initialize the query builder
            $query = Product::query();
        
            // Check if a keyword was provided
            if ($keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                          ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            }
        
            // Get the filtered products
            $products = $query->get();
        
            // Return the search results to the view
            return view('product.search', compact('products', 'keyword'));
        }
    }