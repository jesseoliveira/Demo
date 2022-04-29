<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Tray :: Aplicação</title>
        <style>table {width: 100%;}table tr th, table tr td {background-color: #f8f9fa!important; border: 1px solid #ccc; text-align: left;}.nav{width: 100%; background: #383737; color: #fff; padding-left: 15px; padding-top: 0.75rem; padding-bottom: 0.75rem; font-size: 1rem;}
        </style>
    </head>
    <body style="margin: 0; font-family: monospace;">
        <div class="nav">TRAY :: RELÁTORIO DE VENDAS DIÁRIO</div>
        <table border="0" cellpadding="5px" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Comissão</th>
                    <th>Valor da Venda</th>
                    <th>Data da Venda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendas as $venda)
                <tr>
                    <td>{{$venda->id}}</td>
                    <td>{{$venda->name}}</td>
                    <td>{{$venda->email}}</td>
                    <td>{{number_format((float)$venda->comissao, 2, ',', '.')}}</td>
                    <td>{{number_format((float)$venda->valor, 2, ',', '.')}}</td>
                    <td>{{$venda->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>