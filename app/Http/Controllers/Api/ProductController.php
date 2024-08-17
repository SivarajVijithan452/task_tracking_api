<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\ProductUpdated;
use App\Events\ProductCreated;
use App\Events\ProductDeleted;
class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * 
     */
    public function index()
{
    try {
        // Retrieve all products from the database
        $products = Product::all();

        // Return a JSON response containing the list of products
        // Use ProductResource to format the output
        return response()->json([
            'data' => ProductResource::collection($products)
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that occur during the retrieval
        return response()->json([
            'message' => 'An error occurred while retrieving products',
            'error' => $e->getMessage()
        ], 500);
    }
}



    /**
     * Store a newly created product in storage.
     *
     * 
     */

    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|max:255',
                'product_category' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'product_price' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                // Return validation errors if any
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create a new product
            $product = Product::create([
                'product_name' => $request->product_name,
                'product_category' => $request->product_category,
                'description' => $request->description,
                'product_price' => $request->product_price,
            ]);

            broadcast(new ProductCreated($product));


            

            // Return a success message with the created product
            return response()->json([
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
            ], 201);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified product.
     *
     * 
     */
    public function show(Product $product)
    {
        try {
            // Return the found product with ProductResource formatting
            return new ProductResource($product);
        } catch (ModelNotFoundException $e) {
            // Return a 404 response if the product is not found
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while retrieving the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified product in storage.
     *
     * 
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|max:255',
                'product_category' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'product_price' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                // Return validation errors if any
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
    
            // Find the product by ID
            $product = Product::find($id);
    
            if (!$product) {
                // Return error if product not found
                return response()->json([
                    'message' => 'Product not found'
                ], 404);
            }
    
            // Update the product details
            $product->update([
                'product_name' => $request->product_name,
                'product_category' => $request->product_category,
                'description' => $request->description,
                'product_price' => $request->product_price,
            ]);

            // Dispatch the ProductUpdated event
            broadcast(new ProductUpdated($product));
    
            // Return a success message with the updated product
            return response()->json([
                'message' => 'Product updated successfully',
                'data' => new ProductResource($product)
            ], 200);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove the specified product from storage.
     *
     * 
     */
    public function destroy(Product $product)
    {
        try {
            // Store the product ID before deleting
            $productId = $product->id;
            // Delete the product
            $product->delete();
            broadcast(new ProductDeleted($productId));
            // Return a success message
            return response()->json([
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Return a 404 response if the product is not found
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while deleting the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
