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
    Novo {{substr_replace("Pacientes", "", -1)}}
  </h2>

  {!! Form::open(['route' => [$url, $paciente->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
  <div class="row form-group">
    <div class="col-md-8 col-sm-12 col-xs-12">
      {!! Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' =>
      'control-label'])) !!}
      {!! Form::text('nome', $paciente->nome, ['class' => 'form-control','required' => 'true']) !!}
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
      {!! Html::decode(Form::label('cpf', 'CPF', ['class' => 'control-label'])) !!}
      {!! Form::text('cpf', $paciente->cpf, ['class' => 'form-control']) !!}
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-12">
      <div class="checkbox squaredTwo">
        <input type="checkbox" id="pagador" name="pagador" @if($paciente->pagador_id) checked @endif/>
        <label for="pagador" class="control-label"><span></span>Possui pagador?</label>
      </div>
    </div>
  </div>
  <div id="row_pagador" class="row form-group hide">
    <div class="col-md-8">
      {!! Html::decode(Form::label('pagador_nome', 'Nome do Pagador <span class="obrigatorio">*</span>', ['class'
      => 'control-label'])) !!}
      {!! Form::text('pagador_nome', @$paciente->pagador()->nome, ['class' => 'form-control','required' =>
      $paciente->pagador_id]) !!}
    </div>
    <div class="col-md-4">
      {!! Html::decode(Form::label('pagador_cpf', 'CPF do Pagador <span class="obrigatorio">*</span>', ['class' =>
      'control-label'])) !!}
      {!! Form::text('pagador_cpf', @$paciente->pagador()->cpf, ['class' => 'form-control cpf','required' =>
      $paciente->pagador_id]) !!}
    </div>
  </div>
  <div class="form-group text-right">
    <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
    <a class="templatemo-white-button" href="{{ route('pacientes.index') }}"><i class="fa fa-arrow-left"></i>
      Voltar</a>
  </div>
  {!! Form::close() !!}

</div>

<script type="text/javascript">
  @if($paciente->pagador_id)
    $("#row_pagador").removeClass('hide');
    @endif

    // Exibe/oculta a área de selecionar o pagador
    $("#pagador").change(function(){
        if($(this).attr('checked'))
            $("#row_pagador").removeClass('hide');
        else
            $("#row_pagador").addClass('hide');
    });

    // obriga/não obriga os dados de pagador
    $("#pagador").change(function(){
        if($(this).attr('checked'))
            $("#row_pagador").find("input").attr('required', true);
        else
            $("#row_pagador").find("input").attr('required', false);
    });
</script>
@endsection