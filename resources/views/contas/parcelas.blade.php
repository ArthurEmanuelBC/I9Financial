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
    <h2 class="margin-bottom-10">Parcelas</h2>
    {!! Form::open(['route' => 'contas.parcelas', 'method' => 'GET']) !!}
    {!! Form::hidden("tipo", $parametros['tipo']) !!}
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 margin-bottom-10 data-search">
            <div class="input-group">
                <span class="input-group-addon">Data de Lançamento: </span>
                {!! Form::date("data1", $data1, ['class' => 'form-control']) !!}
                {!! Form::date("data2", $data2, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 margin-bottom-10">
            <div class="input-group">
                <span class="input-group-addon">Operação: </span>
                {!! Form::select("tipo", [NULL => "Todos", 0 => "Entrada", 1 => "Saída"], $parametros['tipo'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 margin-bottom-10 filtro-search">
            <div class="input-group">
                @if($parametros['tipo'] != "2")
                {!! Form::select("filtro", [NULL => "Nenhum", "vencimento" => "Data de Vencimento", "pagamento" => "Data de Pagamento", "valor" => "Valor"], @$parametros['filtro'], ['class' => 'form-control pesquisa-avancada-filtro']) !!}
                {!! Form::text("valor", $parametros['valor'], ['class' => 'form-control pesquisa-avancada-valor']) !!}
                @else
                <span class="input-group-addon">Pacientes: </span>
                <select name="paciente_ids[]" class="form-control select2-search" multiple>
                    @foreach($parametros['pacientes'] as $id => $nome)
                    <option value="{{$id}}" @if(in_array($id,$parametros['paciente_ids'])) selected @endif>{{$nome}}</option>
                    @endforeach
                </select>
                @endif
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                    <!-- <a type="submit" class="btn btn-success" href="{{ route('contas.parcelas', ['tipo' => $parametros['tipo'], 'data1' => $data1->format('d/m/Y'), 'data2' => $data2->format('d/m/Y'), 'paciente_ids' => $parametros['paciente_ids'], 'pdf' => true]) }}" target="_blank"><i class="fa fa-print"></i> Imprimir</a> -->
                </span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 margin-bottom-10">
        </div>
    </div>
    {!! Form::close() !!}
</div>


@if($parcelas->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>Data de Lançamento</th>
                    <th>Data de Vencimento</th>
                    <th>Data de Pagamento</th>
                    <th>Paciente</th>
                    <th>Observação</th>
                    <th>Valor</th>
                    <th>Tipo de Pagamento</th>
                    <th>Usuário</th>
                    <th>Status</th>
                    <th>Pendência</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($parcelas as $parcela)
                <tr>
                    <td>{{@date_format(date_create_from_format('Y-m-d', $parcela->lancamento), 'd/m/Y')}}</td>
                    <td>{{@date_format(date_create_from_format('Y-m-d', $parcela->vencimento), 'd/m/Y')}}</td>
                    <td>{{@date_format(date_create_from_format('Y-m-d', $parcela->pagamento), 'd/m/Y')}}</td>
                    <td>{{@$parcela->conta()->paciente()->nome}}</td>
                    <td>{{$parcela->conta()->descricao}}</td>
                    <td>{{number_format($parcela->valor,2,',','.')}}</td>
                    <td>{{$parcela->conta()->tipo_pagamento}}</td>
                    <td>{{$parcela->conta()->user()->name}}</td>
                    <td>@if($parcela->tipo) Saída @else Entrada @endif</td>
                    @if($parcela->pago)
                    <td class="table_actions" align="center" title="Gerar Pendência">
                        <a onclick="confirm_pendencia('{{ route('parcelas.pagar', ['id' => $parcela->id, 'tipo' => $parametros['tipo'], 'data1' => $data1->format('d/m/Y'), 'data2' => $data2->format('d/m/Y'), 'desfazer' => true]) }}')" href="javascript:;" data-toggle="modal" data-target="#confirm_pendencia"><i class="fa fa-square-o"></i></a>
                    </td>
                    @else
                    <td class="table_actions" align="center" title="Pendente"><i class="fa fa-check-square"></i></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$parcelas->firstItem()}}</strong> ao <strong>{{$parcelas->lastItem()}}</strong> de um total de <strong>{{$parcelas->total()}}</strong> registros</p>
    {!! $parcelas->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma Parcela encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif

<!-- Modals -->
<div class="modal fade" id="confirm_pagar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Deseja realmente pagar esta parcela?</h4>
            </div>
            <div class="modal-footer">
                {!! Form::open(['route' => null, 'method' => 'POST', 'id' => 'form-pagar']) !!}
                <button type="submit" class="btn btn-primary">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm_pendencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Deseja realmente gerar a pendência desta parcela?</h4>
            </div>
            <div class="modal-footer">
                {!! Form::open(['route' => null, 'method' => 'POST', 'id' => 'form-pendencia']) !!}
                <button type="submit" class="btn btn-primary">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .filtro-search select, .filtro-search input { width: 50% !important; }
    .data-search .form-control { width: 50%; }
</style>

<script type="text/javascript">
    // Popula o form de confirmação de conferência da parcela
    function confirm_conferir(url) {
        $('#form-conferir').attr('action', url);
    }
    
    // Popula o form de confirmação de pagamento da parcela
    function confirm_pagar(url) {
        $('#form-pagar').attr('action', url);
    }
</script>

@endsection
