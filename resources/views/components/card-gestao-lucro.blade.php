<div class="card box-default">
    <div class="card-header with-border">
        <h3 class="card-title">Lucro {{$produto}}</h3>
        <div class="card-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-bs-toggle="collapse" href="#environment" role="button" aria-expanded="true" aria-controls="environment">
                <i class="icon-minus"></i>
            </button>
        </div>
        <!-- Botão de colapso e outros elementos... -->
    </div>
    <div class="card-body collapse show" id="environment">
        <div class="table-responsive">
            <p>Mês atual: <strong>{{$mesAtual}}</strong></p>
            <p>Lucro Total: <strong>R$ {{ number_format($lucroTotal, 2, ',', '.') }}</strong></p>
        </div>
    </div>
</div>

