<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Validator, Exception;


class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        foreach ($products as $product){
            $product->category;
        }


        return response()->json([
            'success'=> true, 
            'products'=> $products
            ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required|unique:product|max:60',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id',
            'name' => 'required|unique:product|max:60',
            'quantity' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return response()->json([
                'success'=> false, 
                'error'=> $validator->messages()
                ]);
        }

        try{
            Product::create($data);
        }
        catch(Exception $ex){
            return response()->json([
                'success'=> false, 
                'error'=> $ex->messages()
                ]);
        }

        return response()->json([
            'success'=> true, 
            'message'=> 'Se registro producto con éxito.'
            ]);

       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id',$id)->first();
        $product->category;
    

        return response()->json([
            'success'=> true, 
            'product'=> $product
            ]);
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
        $data = $request->all();

        $rules = [
            'name' => 'required|unique:product|max:60',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id',
            'name' => 'required|unique:product|max:60',
            'quantity' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            return response()->json([
                'success'=> false, 
                'error'=> $validator->messages()
                ]);
        }

        try{
           $product = Product::find($id);

           if(!$product){
                return response()->json([
                    'success'=> false, 
                    'error'=> 'No se encontró el producto.'
                    ]);
           }

           $product->update($data);
        }

        catch(Exception $ex){
            return response()->json([
                'success'=> false, 
                'error'=> $ex->messages()
                ]);
        }

        return response()->json([
            'success'=> true, 
            'message'=> 'Se actualizó el producto con éxito.'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
           $product = Product::find($id);
           
           if(!$product){
                return response()->json([
                    'success'=> false, 
                    'error'=> 'No se encontró el producto.'
                    ]);
           }

           $product->update(['estado' => 0]);
        }

        catch(Exception $ex){
            return response()->json([
                'success'=> false, 
                'error'=> $ex->messages()
                ]);
        }

        return response()->json([
            'success'=> true, 
            'message'=> 'Se ha dado de baja el producto con éxito.'
            ]);
    }

    /**
     * Activate the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        try{
           $product = Product::find($id);
           
           if(!$product){
                return response()->json([
                    'success'=> false, 
                    'error'=> 'No se encontró el producto.'
                    ]);
           }

           $product->update(['estado' => 1]);
        }

        catch(Exception $ex){
            return response()->json([
                'success'=> false, 
                'error'=> $ex->messages()
                ]);
        }

        return response()->json([
            'success'=> true, 
            'message'=> 'Se ha activado el producto con éxito.'
            ]);
    }
}
