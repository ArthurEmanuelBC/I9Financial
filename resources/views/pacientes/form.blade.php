@extends('template')

@section('content')
@if ($errors->any())
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>                
    <div class="media">
        <div class="media-body">
            <ul>
                @foreach($errors->all() as $error)
                <li><h2>{{ $error }}</h2></li>
                @endforeach
            </ul>
        </div>        
    </div>           
</div>     
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        Novo {{substr_replace("Pacientes", "", -1)}}
    </h2>

    {!! Form::open(['route' => [$url, $paciente->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                    {!! Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                    {!! Form::text('nome', $paciente->nome, ['class' => 'form-control','required' => 'true']) !!}
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                    {!! Html::decode(Form::label('cpf', 'CPF <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                    {!! Form::text('cpf', $paciente->cpf, ['class' => 'form-control','required' => 'true']) !!}
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    {!! Html::decode(Form::label('email', 'Email <span class="obrigatorio">*</span>', ['class' => 'control-label'])) !!}
                    {!! Form::email('email', $paciente->email, ['class' => 'form-control','required' => 'true']) !!}
                    </div>
                    </div>
        <div class="form-group text-right">
            <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
            <a class="templatemo-white-button" href="{{ route('pacientes.index') }}"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    {!! Form::close() !!}

</div>
@endsection