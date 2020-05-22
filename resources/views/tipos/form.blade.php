@extends('template')

@section('content')
@if ($errors->any())
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>
    <div class="media">
        <div class="media-body">
            <ul>
                @foreach($errors->all() as $error)
                <li>
                    <h2>{{ $error }}</h2>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        Novo {{substr_replace("Tipos", "", -1)}}
    </h2>

    {!! Form::open(['route' => [$url, $tipo->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])) !!}
            {!! Form::text('nome', $tipo->nome, ['class' => 'form-control','required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('tipo', 'Tipo <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])) !!}
            {!! Form::select('tipo', ['Receita', 'Despesa'], $tipo->tipo, ['class' => 'form-control', 'required' =>
            'true']) !!}
        </div>
    </div>
    <div class="row row-opcao form-group @if(!$tipo->tipo) hide @endif">
        <div class="col-md-12">
            {!! Html::decode(Form::label('opcao', 'Opcao <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])) !!}
            {!! Form::select('opcao', ['Livro Caixa' => 'Livro Caixa', 'Imposto de Renda' => 'Imposto de Renda'],
            $tipo->opcao, ['class' => 'form-control', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            {!! Html::decode(Form::label('perfil', 'Perfil <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])) !!}
            {!! Form::select('perfil', ['Gerencial' => 'Gerencial', 'Técnico' => 'Técnico', 'Contador' => 'Contador'],
            $tipo->perfil, ['class' => 'form-control', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('tipos.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>

<script>
    $('#tipo').change(function() {
        if($(this).val() == '1')
            $('.row-opcao').removeClass('hide');
        else
            $('.row-opcao').addClass('hide');
    });
</script>
@endsection