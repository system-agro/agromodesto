<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <script src="{{ asset('js/tabs.js')}}"></script>
    <div id="tabs"> <ul class="nav nav-tabs" id="customTabs" role="tablist"> 
    <li class="nav-item">
        <a aria-selected="true" class="nav-link active" id="tab3-tab" data-toggle="tab" role="tab" aria-controls="tab3"
            data-route="{{ route('loadClientData', ['database' => 'database'])}}" href="{{ route('loadClientData', ['database' => 'database'])}}">Clientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2"
            aria-selected="false">Fornecedores</a>
    </li>
    </ul >
            <div class="tab-content" id="customTabsContent">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- Conteúdo para a tab de Clientes -->
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    <!-- Conteúdo para a tab de Fornecedores -->
                </div>
            </div>
</div >