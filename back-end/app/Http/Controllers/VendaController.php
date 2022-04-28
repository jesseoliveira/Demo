<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use App\Models\Venda;

class VendaController extends Controller
{

    private function vendas(Request $request)
    {
        try {

            $vendas = Venda::Join('vendedores', 
                        function($join){ 
                            $join->on('vendedores.id', '=', 'vendas.vendedor_id'); 
                        })
                        ->select(
                            'vendas.id',
                            'vendedores.name',
                            'vendedores.email', 
                            'vendas.comissao',
                            'vendas.valor',
                            'vendas.created_at'
                        );

            $filters = $request->only('id', 'vendedor_id');
            foreach ($filters as $key => $value) {
                if($value > 0){
                    $vendas->where("vendas.{$key}", '=', $value);
                }
            }

            if($request->date){
                $vendas->where("vendas.created_at", '>=', $request->date.' 00:00:00');
                $vendas->where("vendas.created_at", '<=', $request->date.' 23:59:59');
            }

            return $vendas->get();

        } catch (\Exception $e) {

            return [];

        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   

        try { 
           
            return response()->json(array('state' => 'SUCCESS', 'data' => $this->vendas($request)));

        } catch (\Exception $e) {

            if(config('app.debug') == true){
            
                return response()->json(array('state' => 'ERROR', 'data' => [], 'errors' => $e->getMessage()));
            
            }else{
            
                return response()->json(array('state' => 'ERROR', 'data' => []));
            
            }

        }

    }


    /**
     * Create new sales record in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try {

            $validator = Validator($request->all(), [
                'vendedor_id' => 'required|integer|min:1',
                'valor'       => 'required|regex:/^\d*(\.\d{0,2})?$/',
            ]);

            if($validator->fails()){
                return response()->json(array('state' => 'ERROR', 'errors' => $validator->errors()->all()));
            }

            $venda = new Venda();
            $venda->vendedor_id = $request->vendedor_id;
            $venda->comissao    = round(($request->valor*$venda->comissao_venda()/100), 2);
            $venda->valor       = round($request->valor, 2);
            $venda->save();

            $request = new Request();   
            $request->initialize(['id' => $venda->id]);

            return response()->json(array('state' => 'SUCCESS', 'data' => $this->vendas($request)));

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

            $result = Venda::where('id', $request->id)->delete();

            if($result){

                return response()->json(array('state' => 'SUCCESS'));

            }else{

                return response()->json(array('state' => 'ERROR', 'errors' => ['Não foi possível excluir este registro, por favor, atualize a página e tente novamente!']));

            }

        } catch (\Exception $e) {

            return response()->json(array('state' => 'ERROR', 'errors' => $e->getMessage()));

        }

    }


    /**
     * Create new sales record in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendmail($date = '')
    {
        try {

            $request = new Request();   
            $request->initialize(['date' => date('Y-m-d')]);
            $vendas = $this->vendas($request);
            
            $mail = new PHPMailer(true);
            $mail->isSMTP(); 
            $mail->Host     = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->setLanguage('pt_br', base_path('vendor/phpmailer/phpmailer/language'));
            $mail->isHTML(true);
            $mail->CharSet = 'utf-8';
            $mail->addAddress(config('mail.to.address'), config('mail.to.name'));
            $mail->Subject = 'RELATÓRIO DE VENDAS '.date('Y').' - TRAY';
            $mail->Body    = view('mail', ['vendas'=>$vendas]);
            $mail->send();

            return response()->json(array('state' => 'SUCCESS'));

        } catch (Exception $e) {            
            
            if(config('app.debug') == true){
            
                return response()->json(array('state' => 'ERROR', 'errors' => $e->getMessage()));
            
            }else{
            
                return response()->json(array('state' => 'ERROR'));
            
            }
        
        }
    }

}
