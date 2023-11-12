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
            margin-bottom: 15px;
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
<body>
    <div class="invoice-container">
        <div class="text-center">
            <p><strong>DIV IND. COM. E EXP. DE MADEIRAS EIRELI</strong></p>
            <p>16.956.012/0001-85</p>
            <p>Av. do Trabalhador, São Miguel do Guama - PA</p>
            <p>dlfdmadeiras@gmail.com</p>
        </div>

        <div class="section text-center">
            <span class="section-title">FATURA DE VENDA</span>
        </div>

        <div class="information">
            <div>
                <p>Cliente: {{ $madeira->cliente }}</p>
                <p>Endereço: [Endereço do cliente]</p>
                <p>Cidade/UF: [Cidade/Estado do cliente]</p>
            </div>
            <div class="text-right">
                <p>Nota: [Número da Nota]</p>
                <p>Data: {{ $madeira->data_venda}}</p>
            </div>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                        <th>Preço Unitário</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $madeira->quantidade_venda }}</td>
                        <td>{{ $madeira->tipo_madeira }}</td>
                        <td>R$ {{ number_format($madeira->valor_venda, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($madeira->quantidade_venda * $madeira->valor_venda, 2, ',', '.') }}</td>
                    </tr>
                    <!-- Adicione mais linhas conforme necessário -->
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Comentários ou perguntas devem ser dirigidos para o endereço acima.</p>
        </div>

        <div class="page-break"></div>
    </div>
</body>
</html>
