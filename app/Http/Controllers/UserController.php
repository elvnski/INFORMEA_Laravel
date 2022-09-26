<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  ProductController extends Controller{

    //create new user
    public function createProduct(Request $request){
        $product = Product::create($request->all());
        return response()->json($product);
    }
    
    //update user details
    
    public function updateProduct(Request $request, $id){
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->price =  $request->input('price');
        $product->description = $request->input('description');
        $product->save();
        return response()->json($product);
    }


    //view user
    public function viewProduct($id){
     $product =  Product::find($id);
            return response()->json($product);
    }


    //delete user(
    public function deleteProduct($id){
        $product =  Product::find($id);
        $product->delete();

        return response()->json('Removed successfully');
    }

    //list users
    public function index(){
        $product =Product::all();
        return response()->json($product);
    }

} 
?>