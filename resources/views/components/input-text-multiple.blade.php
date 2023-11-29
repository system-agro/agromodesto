
<style>
       .tag-input-container {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background-color: #FFF;
        }
        .tag {
            background-color: #007bff;
            color: white;
            padding: 5px;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        .remove-tag {
            cursor: pointer;
            margin-left: 5px;
        }
        .tag-input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 6px 0px;
            font-size:14px;
        }

        .btt {
            background:"red";
            height:"100%";
        }

</style>
<div class="row containerForm">
    <div class="row p-3 m-1">
        <div class="col-md-2">
            <label for="inputTipoMadeira">Tipo da madeira</label>
            <input type="text" class="form-control form-control-lg rounded inputTipoMadeira" data-mask=""  placeholder="Digite o tipo da madeira" >
        </div>
        <div class="col-md-2">
            <label for="inputValorMadeira">Valor Comprado</label>
            <input type="text" class="form-control form-control-lg rounded inputValorMadeira" data-mask="currency" placeholder="Digite o valor comprado" >
        </div>
        
        <div class="col-md-2">
            <label for="inputQuantidadeVenda">Quantidade Madeira Vendida</label>
            <input type="text" class="form-control form-control-lg rounded inputQuantidadeVenda" id="inputQuantidadeVenda" data-mask="decimal" placeholder="Digite a quantidade comprada" >
        </div>
        
        <div class="col-md-2">
            <label for="inputValorVenda">Valor da Venda</label>
            <input type="text" class="form-control form-control-lg rounded inputValorVenda" id="inputValorVenda" data-mask="currency" placeholder="Digite o valor da venda" >
        </div>
        
        <div class="col btt" style="
                display: flex;
                align-items: flex-end;
                justify-content: flex-start;
            ">
            <label for=""></label>
            <button id="addInput" class="btn btn-light" style="padding: 10px;">Adicionar +</button>
        </div>
    </div>
</div>




