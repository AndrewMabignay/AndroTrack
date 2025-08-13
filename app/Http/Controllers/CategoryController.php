<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    // CATEGORY INDEX
    public function index()
    {
        return view('products.category');
    }

    // // CATEGORY LIST
    // public function categoryList() 
    // {
    //     $categories = Category::all()->map(function ($category) {
    //         $category->encrypted_id = encrypt($category->id);
    //         $category->created_date = $category->created_at->format('Y-m-d'); // <-- Date only
    //         return $category;
    //     });

    //     return response()->json([
    //         'categories' => $categories
    //     ]);
    // }

    // CATEGORY LIST
    public function categoryList(Request $request) 
    {
        $perPage = $request->get('per_page', 5); // DEFAULT 5 PAGE
        $search  = $request->get('search', null);
        $status  = $request->get('status', null);        

        $query = Category::query();

        // SEARCH FILTER
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($status && in_array($status, ['active', 'inactive'])) {
            $query->where('status', $status);
        }

        $categories = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->through(function ($category) {
                $category->encrypted_id = encrypt($category->id);
                $category->created_date = $category->created_at->format('Y-m-d');
                return $category;
            });

        return response()->json($categories);
    }


    // CATEGORY EDIT FORM
    public function edit($encryptedId) {
        try {
            $id = decrypt($encryptedId);
            $category = Category::findOrFail($id);

            return response()->json([
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([ 'error' => 'Invalid ID' ], 400);
        }
    }

    // CATEGORY STORE/UPDATE
    public function store(Request $request) 
    {
        $isUpdate = $request->filled('id'); // CHECK IF IT HAS AN ID OR NOT.

        $categoryId = $isUpdate ? decrypt($request->id) : null;
        $category = $isUpdate ? Category::findOrFail($categoryId) : new Category();

        // CATEGORY VALIDATION RULES
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $categoryId],
            'status' => ['required', 'in:active,inactive'],
        ];
        
        $request->validate($rules);

        $slug = Str::slug($request->name); // CATEGORY SLUG

        // SAVE CATEGORY DATA
        $category->name = $request->name;
        $category->slug = $slug;
        $category->status = $request->status;

        $category->save();

        return response()->json([
            'res' => $category->name . ' has been successfully added.'
        ]);
    }
}
