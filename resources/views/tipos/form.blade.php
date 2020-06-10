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
    <div class="row row-opcao form-group">
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
            <div class="templatemo-block margin-bottom-5">
                <input type="checkbox" name="perfil[]" id="tipo_gerencial" value="Gerencial"
                    @if(preg_match('/\bGerencial\b/', $tipo->perfil)) checked @endif>
                <label for="tipo_gerencial" class="font-weight-400"><span></span>Gerencial</label>
            </div>
            <div class="templatemo-block margin-bottom-5">
                <input type="checkbox" name="perfil[]" id="tipo_tecnico" value="Técnico" @if(preg_match('/\bTécnico\b/',
                    $tipo->perfil)) checked @endif>
                <label for="tipo_tecnico" class="font-weight-400"><span></span>Técnico</label>
            </div>
            <div class="templatemo-block margin-bottom-5">
                <input type="checkbox" name="perfil[]" id="tipo_contador" value="Contador"
                    @if(preg_match('/\bContador\b/', $tipo->perfil)) checked @endif>
                <label for="tipo_contador" class="font-weight-400"><span></span>Contador</label>
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('tipos.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    {!! Form::close() !!}

</div>
@endsection