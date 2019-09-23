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
    <h2 class="margin-bottom-10">Contas a @if($tipo) Receber @else Pagar @endif</h2>
    {!! Form::open(['route' => 'contas.index', 'method' => 'GET']) !!}
    {!! Form::hidden("tipo", $tipo) !!}
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12 form-group">
            <div class="input-group">
                <span class="input-group-addon" style="width:150px">Tipo de Relatório: </span>
                {!! Form::select("tipo_relatorio", ["Agrupado","Detalhado"], @$parametros['tipo_relatorio'], ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12 form-group data-search">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {!! Form::select("tipo_data", ["date" => "Data de Lançamento", "vencimento" => "Data de Vencimento", "conferencia" => "Data de Conferência", "pagamento" => "Data de Pagamento", "recebimento" => "Data de Recebimento"], @$parametros['tipo_data'], ['class' => 'form-control', 'required' => 'true']) !!}
                {!! Form::date("data1", @$parametros['data1'], ['class' => 'form-control']) !!}
                {!! Form::date("data2", @$parametros['data2'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12 form-group filtro-search">
            <div class="input-group">
                {!! Form::select("filtro", [NULL => "Nenhum", "tipo_pagamento" => "Tipo de Pagamento", "num_doc" => "Número do Documento", "qtd_parcelas" => "Qtd Parcelas", "total" => "Valor Total", "cartao" => "Cartão", "descricao" => "Descrição"], @$parametros['filtro'], ['class' => 'form-control pesquisa-avancada-filtro']) !!}
                {!! Form::text("valor", $parametros['valor'], ['class' => 'form-control pesquisa-avancada-valor']) !!}
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn btn-success" data-toggle="modal" data-target="#pesquisa-avancada"><i class="fa fa-plus"></i></a>
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                </span>
            </div>
        </div>
        
        <!-- Modal da pesquisa avançada -->
        <div class="modal fade" id="pesquisa-avancada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Pesquisa Avançada</h4>
                    </div>
                    <div class="modal-body">
                        <table id="table_pesquisa_avancada" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Coluna</th>
                                    <th>Tipo</th>
                                    <th>valor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {!! Form::select("filtro_avancado[]", [NULL => "Nenhum", "tipo_pagamento" => "Tipo de Pagamento", "origem" => "Origem", "profissional" => "Profissional", "num_doc" => "Número do Documento", "qtd_parcelas" => "Qtd Parcelas", "total" => "Valor Total", "cartao" => "Cartão", "taxa" => "Taxa", "categoria" => "Categoria", "descricao" => "Descrição"], @$parametros['filtro'], ['class' => 'form-control filtro_avancado']) !!}
                                    </td>
                                    <td>
                                        {!! Form::select("tipo_avancado[]", [NULL => "Nenhum", "=" => "=", "<" => "<", ">" => ">", "like" => "Contém", "not like" => "Não Contém", "!=" => "Diferente de", "in" => "Possui", "not in" => "Não Possui"], "=", ['class' => 'form-control tipo_avancado']) !!}
                                    </td>
                                    <td>
                                        <textarea class="form-control valor_avancado" name="valor_avancado[]" resizable="true" rows="1">{{$parametros["valor"]}}</textarea>
                                    </td>
                                    <td align="center" class="table_actions">
                                        <a class="add_linha" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-12 col-xs-12 form-group filtro-search">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('contas.create', ['tipo' => $tipo]) }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Nova Conta {{substr_replace("Contas", "", -1)}} @if($tipo == '0') a Pagar @else a Receber @endif</a></div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="row" style="margin-left:-5px">
    <div class="col-md-2 col-sm-6 col-xs-6 form-group">
        <div id="group-dropdown" class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Colunas <span class="caret"></span></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <ul style="list-style: none;padding: 0 10px;">
                    <li><input type="checkbox" id="check_lancamento" class="dropdown-check" data-column="lancamento" checked> <label for="check_lancamento" class="font-weight-400"><span></span>Data de Lançamento</label></li>
                    @if($parametros['tipo_relatorio'] == "1")
                    <li><input type="checkbox" id="check_vencimento" class="dropdown-check" data-column="vencimento" checked> <label for="check_vencimento" class="font-weight-400"><span></span>Data de Vencimento</label></li>
                    <li><input type="checkbox" id="check_conferencia" class="dropdown-check" data-column="conferencia" checked> <label for="check_conferencia" class="font-weight-400"><span></span>Data de Conferência</label></li>
                    <li><input type="checkbox" id="check_pagamento" class="dropdown-check" data-column="pagamento" checked> <label for="check_pagamento" class="font-weight-400"><span></span>Data de Pagamento</label></li>
                    <li><input type="checkbox" id="check_recebimento" class="dropdown-check" data-column="recebimento" checked> <label for="check_recebimento" class="font-weight-400"><span></span>Data de Recebimento</label></li>
                    @endif
                    <li><input type="checkbox" id="check_tipo_pagamento" class="dropdown-check" data-column="tipo_pagamento" checked> <label for="check_tipo_pagamento" class="font-weight-400"><span></span>Tipo de Pagamento</label></li>
                    <li><input type="checkbox" id="check_num_doc" class="dropdown-check" data-column="num_doc" checked> <label for="check_num_doc" class="font-weight-400"><span></span>Número do Documento</label></li>
                    <li><input type="checkbox" id="check_qtd_parcelas" class="dropdown-check" data-column="qtd_parcelas" checked> <label for="check_qtd_parcelas" class="font-weight-400"><span></span>Quantidade de Parcelas</label></li>
                    <li><input type="checkbox" id="check_total" class="dropdown-check" data-column="total" checked> <label for="check_total" class="font-weight-400"><span></span>Valor Total</label></li>
                    <li><input type="checkbox" id="check_cartao" class="dropdown-check" data-column="cartao" checked> <label for="check_cartao" class="font-weight-400"><span></span>Cartão</label></li>
                    <li><input type="checkbox" id="check_descricao" class="dropdown-check" data-column="descricao" checked> <label for="check_descricao" class="font-weight-400"><span></span>Descrição</label></li>
                </ul>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-6 col-xs-6 form-group">
        {!! Form::open(['route' => 'contas.index', 'method' => 'GET', 'target' => '_blank', 'id' => 'form-print']) !!}
        {!! Form::hidden("tipo", $tipo) !!}
        {!! Form::hidden("pdf", true) !!}
        {!! Form::hidden("tipo_relatorio", @$parametros['tipo_relatorio']) !!}
        {!! Form::hidden("tipo_data", @$parametros['tipo_data']) !!}
        {!! Form::hidden("data1", @$parametros['data1']) !!}
        {!! Form::hidden("data2", @$parametros['data2']) !!}
        {!! Form::hidden("filtro", @$parametros['filtro']) !!}
        {!! Form::hidden("valor", @$parametros['valor']) !!}
        @if(!is_null($parametros['filtro_avancado']))
        @foreach($parametros['filtro_avancado'] as $filtro)
        <input type="hidden" name="filtro_avancado[]" value="{{$filtro}}">
        @endforeach
        @endif
        @if(!is_null($parametros['tipo_avancado']))
        @foreach($parametros['tipo_avancado'] as $tipo_avancado)
        <input type="hidden" name="tipo_avancado[]" value="{{$tipo_avancado}}">
        @endforeach
        @endif
        @if(!is_null($parametros['valor_avancado']))
        @foreach($parametros['valor_avancado'] as $valor)
        <input type="hidden" name="valor_avancado[]" value="{{$valor}}">
        @endforeach
        @endif
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-print"></i> Imprimir</button>
        {!! Form::close() !!}
    </div> --}}
</div>

@if($contas->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th class="lancamento">Data de Lançamento</th>
                    @if(@$parametros['tipo_relatorio'] == "1")
                    <th class="vencimento">Data de Vencimento</th>
                    <th class="conferencia">Data de Conferência</th>
                    <th class="pagamento">Data de Pagamento</th>
                    <th class="recebimento">Data de Recebimento</th>
                    @endif
                    <th class="tipo_pagamento">Tipo de Pagamento</th>
                    <th class="num_doc">Número do Documento</th>
                    <th class="qtd_parcelas">Qtd Parcelas</th>
                    <th class="total">Valor Total</th>
                    <th class="cartao">Cartão</th>
                    <th class="descricao">Descrição</th>
                    <th colspan="3"></th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($contas as $contum)
                <tr @if(isset($contum->pai_id)) class="linha_filho" @endif>
                    <td class="lancamento">{{@date_format(date_create_from_format('Y-m-d', $contum->lancamento), 'd/m/Y')}}</td>
                    @if(@$parametros['tipo_relatorio'] == "1")
                    <td class="vencimento">{{@date_format(date_create_from_format('Y-m-d', $contum->vencimento), 'd/m/Y')}}</td>
                    <td class="conferencia">{{@date_format(date_create_from_format('Y-m-d', $contum->conferencia), 'd/m/Y')}}</td>
                    <td class="pagamento">{{@date_format(date_create_from_format('Y-m-d', $contum->pagamento), 'd/m/Y')}}</td>
                    <td class="recebimento">{{@date_format(date_create_from_format('Y-m-d', $contum->recebimento), 'd/m/Y')}}</td>
                    @endif
                    <td class="tipo_pagamento">{{$contum->tipo_pagamento}}</td>
                    <td class="num_doc">{{$contum->num_doc}}</td>
                    <td class="qtd_parcelas">{{$contum->qtd_parcelas}}</td>
                    <td class="total">{{number_format($contum->total,2,',','.')}}</td>
                    <td class="cartao">{{$contum->cartao}}</td>
                    <td class="descricao">{{$contum->descricao}}</td>
                    @if($contum->pago)
                    <td class="table_actions" align="center" title="Pago"><i class="fa fa-check-square"></i></td>
                    @else
                    <td class="table_actions" align="center" title="Pendente"><i class="fa fa-square-o"></i></td>
                    @endif
                    <td class="table_actions" align="center" title="Editar Contum">
                        <a href="{{ route('contas.edit', ['id' => $contum->id, 'tipo' => $tipo]) }}"><i class="fa fa-edit"></i></a>
                    </td>
                    <td class="table_actions" align="center" title="Deletar Contum">
                        <a onclick="confirm_delete('{{ route('contas.destroy', ['id' => $contum->id, 'tipo' => $tipo]) }}')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete"><i class="fa fa-remove"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$contas->firstItem()}}</strong> ao <strong>{{$contas->lastItem()}}</strong> de um total de <strong>{{$contas->total()}}</strong> registros</p>
    {!! $contas->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma {{substr_replace("Contas", "", -1)}} @if($tipo == '0') a Pagar @else a Receber @endif encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
@endif

<style type="text/css">
    .data-search select, .data-search input { width: 33.3% !important; }
    
    .filtro-search select, .filtro-search input { width: 50% !important; }
    
    .linha_filho { background: #F0F8FF }
</style>

<script type="text/javascript">
    // Adiciona uma linha na tabela de pesquisa avançada
    $(document).on('click','a.add_linha',function(){
        $length = $("#table_pesquisa_avancada tbody tr").length;
        $row = $("#table_pesquisa_avancada tbody tr:last").clone();
        $("#table_pesquisa_avancada tbody tr td.table_actions").html("");
        $("#table_pesquisa_avancada tr:last").after($row);
        $("#table_pesquisa_avancada tbody tr:last").find("textarea").val("");
        $("#table_pesquisa_avancada tbody tr:last").find("select.filtro_avancado").val(null);
        $("#table_pesquisa_avancada tbody tr:last").find("select.tipo_avancado").val("=");
    });
    
    // Omite a coluna selecionada
    $('.dropdown-check').change(function(){
        if($("."+$(this).attr('data-column')).css('display') == 'none'){
            $("."+$(this).attr('data-column')).removeClass("hide");
            $("#form-print #print-oculta-"+$(this).attr('data-column')).remove();	
        } else {
            $("."+$(this).attr('data-column')).addClass("hide");
            $("#form-print").append("<input id='print-oculta-"+$(this).attr('data-column')+"' type='hidden' name='ocultas[]' value='"+$(this).attr('data-column')+"'>");
        }
        $("#group-dropdown").addClass("open");
    });
</script>

@endsection
