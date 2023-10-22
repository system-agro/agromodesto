@extends('admin::index', ['header' => strip_tags($header)])

@section('content')

    @foreach ($css_files as $css_file)
        <link rel="stylesheet" href="{{ $css_file }}">
    @endforeach
    @isset($css)
        <style type="text/css">{{ $css }}</style>
    @endisset

    <section class="content-header clearfix">
        <h1>
            {!! $header ?: trans('admin.title') !!}
            <small>{!! $description ?: trans('admin.description') !!}</small>
        </h1>

        @include('admin::partials.breadcrumb')

    </section>

    <!-- Adicione um ID à div com o ID "app" -->
    <div id="app" class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        @if($_view_)
            @include($_view_['view'], $_view_['data'])
        @else
            {!! $_content_ !!}
        @endif

    </div>

    <!-- Adicione o botão personalizado usando JavaScript -->
    <script>
        var customButton = document.createElement('a');
        customButton.href = '#';
        customButton.className = 'btn btn-primary';
        customButton.innerText = 'Botão Personalizado';

        var appDiv = document.getElementById('app');
        appDiv.appendChild(customButton);
    </script>
@endsection
