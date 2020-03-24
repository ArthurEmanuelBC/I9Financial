@extends('template')

@section('content')
@if (Session::has('message'))
<div class="templatemo-content-widget green-bg">
  <i class="fa fa-times"></i>
  <div class="media">
    <div class="media-body">
      <h2>{{Session::get('message')}}</h2>
    </div>
  </div>
</div>
@endif

<div class="templatemo-content-widget white-bg">
  <h2 class="margin-bottom-10">Controle</h2>
  {!! Form::open(['route' => 'parcelas.controle', 'method' => 'GET']) !!}
  {!! Form::hidden("mes", $mes) !!}
  {!! Form::hidden("ano", $ano) !!}
  <div class="row form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon">Tipo: </span>
        {!! Form::select("tipo", $tipos, $tipo, ['id' => 'tipo', 'class' =>
        'form-control']) !!}
      </div>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon">Médico: </span>
        {!! Form::select("medico_id", $medicos, @$medico->id, ['id' => 'medico_id', 'class' =>
        'form-control']) !!}
      </div>
      <p id="doctor-warning">Selecione um médico</p>
    </div>
    <div class="col-md-2 col-sm-12 col-xs-12"></div>
    <div class="col-md-4 col-sm-12 col-xs-12">
      @if(isset($medico))
      <div class="input-group">
        <span class="input-group-addon">Margem disponível: </span>
        {!! Form::text("margem", number_format($medico->margem_atual(),2,',','.'), ['class' => 'form-control','disabled'
        => true]) !!}
      </div>
      @endif
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Pesquisar</button>
    </div>
  </div>
  {!! Form::close() !!}
</div>

<div class="templatemo-content-widget">
  <div class="btn-group" data-toggle="buttons">
    <div class="btn-group">
      <button type="button" class="btn btn-default active dropdown-toggle" data-toggle="dropdown">
        {{$ano}} <span class="caret"></span></button>
      <ul class="dropdown-menu" role="menu">
        @foreach ([2019,date('Y')] as $year)
        <li><a
            href="{{ route('parcelas.controle', ['ano' => $year, 'mes' => $mes, 'tipo' => $tipo, 'medico_id' => @$medico->id]) }}">{{$year}}</a>
        </li>
        @endforeach
      </ul>
    </div>
    @foreach($meses as $numero => $nome)
    <label class="btn btn-default link-mes @if($mes === $numero) active @endif"
      data-number='{{$numero}}'>{{$nome}}</label>
    @endforeach
  </div>
  <a href="{{ route('parcelas.controle', ['ano' => $year, 'mes' => $mes, 'tipo' => $tipo, 'medico_id' => @$medico->id, 'pdf' => true]) }}"
    target="_blank" class="btn btn-success pull-right"><i class="fa fa-print"></i> Imprimir</a>
</div>

@if($parcelas->count())
<div class="templatemo-content-widget no-padding">
  <div class="panel panel-default table-responsive">
    <table class="table table-striped table-bordered templatemo-user-table">
      <thead>
        <tr>
          <th>Data de Lançamento</th>
          <th>Fornecedor/Paciente</th>
          <th>Número do Documento</th>
          <th>Opção</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th>Descrição</th>
        </tr>
      </thead>

      <tbody>
        @foreach($parcelas as $contum)
        <tr>
          <td>{{@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')}}</td>
          <td>{{@$contum->paciente_ou_fornecedor()->nome}}</td>
          <td>{{$contum->num_doc}}</td>
          <td>{{$contum->opcao}}</td>
          <td>@if($contum->tipo) Despesa @else Receita @endif</td>
          <td>{{number_format($contum->valor,2,',','.')}}</td>
          <td>{{$contum->descricao}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="pagination-wrap">
  <p class="text_pagination pull-left">Exibindo do <strong>{{$parcelas->firstItem()}}</strong> ao
    <strong>{{$parcelas->lastItem()}}</strong> de um total de <strong>{{$parcelas->total()}}</strong> registros</p>
  {!! $parcelas->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
  <div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>
    <div class="media">
      <div class="media-body">
        <h2>Nenhum registro encontrado!</h2>
      </div>
    </div>
  </div>
</div>
@endif

<style type="text/css">
  .data-search select,
  .data-search input {
    width: 33.3% !important;
  }

  #doctor-warning {
    color: red;
    text-align: center;
    width: 100%;
    margin: 0;
  }
</style>

<script type="text/javascript">
  // Oculta/exibe o warning de selecionar médico
    $("#medico_id").change(function(){
        if($(this).val())
            $("#doctor-warning").addClass('hide');
        else
            $("#doctor-warning").removeClass('hide');
    });
    $("#medico_id").change();

    // Verifica se existe algum médico selecionado ao criar relatório
    $('#form-print').submit(function(event) {
        if(!$("#medico_id").val()){
            event.preventDefault();
            alert('Selecione um médico!');
        }
    });

    $('.link-mes').click(function(event) {
      if($(this).hasClass('active'))
        location.href = `parcelas_controle?ano={{$ano}}&tipo={{$tipo}}&medico_id={{@$medico->id}}`;
      else
        location.href = `parcelas_controle?mes=${$(this).attr('data-number')}&ano={{$ano}}&tipo={{$tipo}}&medico_id={{@$medico->id}}`;
    });
</script>

@endsection