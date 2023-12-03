<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura de Venda de Madeira</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            line-height: 1.2;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: auto;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .section {
            margin: 15px 0px;
        }
        .section-title {
            text-decoration: underline;
            font-weight: bold;
        }
        .information {
            display: flex;
            justify-content: space-between;
        }
        .information div {
            flex-basis: 48%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid black;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }

    </style>
</head>
@php

$tipoPayment = $madeira['tipo_pagamento'] === 'cheque_parcelado' ? "cheque parcelado" : $madeira['tipo_pagamento'];
$valorParcela = number_format($madeira['valor_total_venda'] / $madeira['total_parcela'], 2, ',', '.');

@endphp
<body>
    <div class="invoice-container">
        <div class="text-center">
            <p><strong>Modesto Representações</strong></p>
        </div>

        <div class="section text-center">
            <span class="section-title">FATURA DE VENDA</span>
        </div>

        <div class="information">
            <div>
                <p>Cliente: {{ $madeira['data_cliente']['name'] }}</p>
                <p>Endereço: {{ $madeira['data_cliente']['cidade'] . ', ' . $madeira['data_cliente']['bairro'] . ', ' . $madeira['data_cliente']['estado'] }}</p>
            </div>
            <div class="text-right">
                <p>Nota: {{$madeira['id']}}</p>
            </div>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Tipo da madeira</th>
                        <th>Quantidade</th>
                        <th>Preço da venda</th>

                    </tr>
                </thead>
                <tbody>
                @foreach ($madeira['compras_madeira'] as $compra)
                    <tr>
                        <td>{{ $compra['tipo_madeira'] }}</td>
                        <td>{{ $compra['quantidade_venda'] }}</td>
                        <td>R$ {{ number_format($compra['valor_venda'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                    <!-- Adicione mais linhas conforme necessário -->
                </tbody>
            </table>
        </div>
        <div>
            <p>Data da Venda: {{ \Carbon\Carbon::parse($madeira['data_venda'])->format('d/m/Y') }}</p>
            <div class="tipoPagamento" style="display: flex; justify-content: space-between;">
                <div>
                    <p>Tipo Pagamento: {{$tipoPayment}}, {{$madeira['total_parcela']}} x R$ {{$valorParcela}}</p>
                </div>
            </div>
            <p>Valor Total da Venda: R$ {{ number_format($madeira['valor_total_venda'], 2, ',', '.') }}</p>
        </div>
        <div class="footer">
            <!-- <p>Comentários ou perguntas devem ser dirigidos para o endereço acima.</p> -->
        </div>

    </div>
</body>
</html>
