<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use Aws\S3\Exception\S3Exception;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%$query%")
                    ->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $productData = $request->except('image');
        $productData['category_id'] = $request->input('category_id');

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imagePath = $image->storeAs('images', $image->getClientOriginalName(), 's3');
                $productData['image'] = $imagePath;
            } catch (S3Exception $e) {
                return redirect()->route('products.index')->with('error', 'Failed to upload image to AWS S3');
            }
        }

        Product::create($productData);

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $productData = $request->except('image');
        $productData['category_id'] = $request->input('category_id');

        if ($request->hasFile('image')) {
            try {
                if ($product->image) {
                    Storage::disk('s3')->delete($product->image);
                }

                $image = $request->file('image');
                $imagePath = $image->storeAs('images', $image->getClientOriginalName(), 's3');
                $productData['image'] = $imagePath;
            } catch (S3Exception $e) {
                return redirect()->route('products.index')->with('error', 'Failed to update image in AWS S3');
            }
        }

        $product->update($productData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('s3')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function productListing(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%$query%")
                    ->paginate(3);
        return view('frontend.pages.listing', compact('products'));
    }

    public function addComment(Request $request, $productId)
    {
        $user = Auth::guard('user');
        $userId = $user->id();

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($productId);
        
        if ($product->comments()->where('user_id', $userId)->exists()) {
            return back()->withErrors(['error' => 'You have already commented on this product.']);
        }

        $product->comments()->create([
            'comment' => $request->comment,
            'user_id' => $userId,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }
}
