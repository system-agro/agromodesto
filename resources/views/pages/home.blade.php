<div class="card box-default">
    <!-- Cabeçalho e outros elementos... -->
    <div class="card-header with-border">
        <h3 class="card-title">Gestão de Natalidade</h3>

        <div class="card-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-bs-toggle="collapse" href="#environment" role="button" aria-expanded="true" aria-controls="environment">
                <i class="icon-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body collapse show" id="environment">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Numeracao Animal</th>
                        <th>Data Inseminacao</th>
                        <th>Data Gestacao</th>
                        <!-- Outras colunas conforme necessário -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $natalidade)
                    <tr> 
                        <td>{{ $natalidade->numeracao_animal }}</td>
                        <td>{{ $natalidade->data_inseminacao }}</td>
                        <td>{{ $natalidade->data_gestacao }}</td>
                        <!-- Outras células conforme necessário -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
</div>
