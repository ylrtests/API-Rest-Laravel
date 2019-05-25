<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'name' => 'required|unique:products|max:60',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        //return response()->json(['temp'=> 'after validator ']);
                
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
                'error'=> $ex->getMessage()
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

        if($product == null){
            return response()->json([
                'success'=> false, 
                'error'=> 'No se pudo encontrar el producto. Verifique el id del producto.'
                ]);
        }
               
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
        //return response()->json(['temp'=> $data]);

        $rules = [
            'name' => ['required','max:60',Rule::unique('products')->ignore($id)],
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
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
                'error'=> $ex->getMessage()
                ]);
        }

        return response()->json([
            'success'=> true, 
            'message'=> 'Se actualizó el producto con éxito.'
            ]);
    }

    /**
     * Update status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatusProduct($id)
    {
        try{
           $product = Product::find($id);
           
           if(!$product){
                return response()->json([
                    'success'=> false, 
                    'error'=> 'No se encontró el producto.'
                    ]);
           }

           $valorEstado = $product['status'] == 1 ? 0 : 1;
           $product->update(['status' => $valorEstado]);
        }

        catch(Exception $ex){
            return response()->json([
                'success'=> false, 
                'error'=> $ex->getMessage()
                ]);
        }
        if($valorEstado == 1){
            return response()->json([
                'success'=> true, 
                'message'=> 'Se ha activado el producto con éxito.'
                ]);
        }
        else{
            return response()->json([
                'success'=> true, 
                'message'=> 'Se ha dado de baja el producto con éxito.'
                ]);
        }
    }

}
