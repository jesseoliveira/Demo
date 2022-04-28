<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedor;

class VendedorController extends Controller
{

    /**
     * Show the sales
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   

        try {

            $vendedores = Vendedor::LeftJoin('vendas', 
                        function($join){ 
                            $join->on('vendedores.id', '=', 'vendas.vendedor_id'); 
                        })
                        ->selectRaw('vendedores.id, vendedores.name, vendedores.email,'. 
                                    'case when sum(vendas.comissao) is null then 0 else sum(vendas.comissao) end as comissao')
                        ->groupBy('vendedores.id','vendedores.name','vendedores.email')
                        ->get();


            return response()->json(array('state' => 'SUCCESS', 'data' => $vendedores));

        } catch (\Exception $e) {

            if(config('app.debug') == true){
            
                return response()->json(array('state' => 'ERROR', 'data' => [], 'errors' => $e->getMessage()));
            
            }else{
            
                return response()->json(array('state' => 'ERROR', 'data' => []));
            
            }

        }

    }


    /**
     * Create new seller record in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   

        try {

            $validator = Validator($request->all(), [
                'name'  => 'required|string|min:3|max:60',
                'email' => 'required|string|email|max:60|unique:vendedores',
            ]);

            if($validator->fails()){
                return response()->json(array('state' => 'ERROR', 'errors' => $validator->errors()->all()));
            }

            $vendedor = new Vendedor();
            $vendedor->name  = $request->name;
            $vendedor->email = $request->email;
            $vendedor->save();

            return response()->json(array('state' => 'SUCCESS', 'data' => $vendedor));

        } catch (\Exception $e) {

            if(config('app.debug') == true){

                return response()->json(array('state' => 'ERROR', 'errors' => $e->getMessage()));
            
            }else{

                return response()->json(array('state' => 'ERROR'));

            }
        
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $validator = Validator($request->all(), [
                'id' => 'required|integer|min:1',
            ]);

            if($validator->fails()){
                return response()->json(array('state' => 'ERROR', 'errors' => $validator->errors()->all()));
            }

            $result = Vendedor::where('id', $request->id)->delete();

            if($result){

                return response()->json(array('state' => 'SUCCESS'));

            }else{

                return response()->json(array('state' => 'ERROR', 'errors' => ['Não foi possível excluir este registro, por favor, atualize a página e tente novamente!']));

            }

        } catch (\Exception $e) {

            return response()->json(array('state' => 'ERROR', 'errors' => $e->getMessage()));

        }

    }

}
