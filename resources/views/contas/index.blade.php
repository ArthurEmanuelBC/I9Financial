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
    <h2 class="margin-bottom-10">@if($tipo) Despesa @else Receita @endif</h2>
    {!! Form::open(['route' => 'contas.index', 'method' => 'GET']) !!}
    {!! Form::hidden("tipo", $tipo) !!}
    @if(Auth::user()->permissao == 'Técnico')
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 data-search">
            <div class="input-group">
                <span class="input-group-addon">Data: </span>
                {!! Form::date("data1", @$parametros['data1'], ['class' => 'form-control']) !!}
                {!! Form::date("data2", @$parametros['data2'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Médico: </span>
                {!! Form::select("medico_id", $parametros["medicos"], NULL, ['id' => 'medico_id', 'class' =>
                'form-control']) !!}
            </div>
            <p id="doctor-warning">Selecione um médico</p>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="input-group">
                @if(Auth::user()->permissao == 'Técnico')
                <span class="input-group-addon">@if($tipo == '0') Paciente: @else Fornecedor: @endif</span>
                {!! Form::text("paciente", NULL, ['id' => 'paciente_id', 'class' => 'form-control', 'required' => true])
                !!}
                @else
                <span class="input-group-addon">@if($tipo == '0') Paciente: @else Fornecedor: @endif</span>
                {!! Form::text("paciente", NULL, ['id' => 'paciente_id', 'class' => 'form-control']) !!}
                @endif
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                </span>
            </div>
        </div>
        @if(Auth::user()->permissao != 'Contador')
        <div class="col-md-4 col-sm-12 col-xs-12 filtro-search">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('contas.create', ['tipo' => $tipo]) }}" type="button"
                        class="btn btn-success"><i class="fa fa-plus"></i> Nova @if($tipo == '0') Receita @else Despesa
                        @endif</a></div>
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 data-search">
            <div class="input-group">
                <span class="input-group-addon">Data: </span>
                {!! Form::date("data1", @$parametros['data1'], ['class' => 'form-control']) !!}
                {!! Form::date("data2", @$parametros['data2'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Médico: </span>
                {!! Form::select("medico_id", $parametros["medicos"], NULL, ['id' => 'medico_id', 'class' =>
                'form-control']) !!}
            </div>
            <p id="doctor-warning">Selecione um médico</p>
        </div>
    </div>
    @if($tipo == '1')
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Fornecedor: </span>
                {!! Form::text("paciente", NULL, ['id' => 'paciente_id', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Opção: </span>
                {!! Form::select("opcao", ['Todos' => 'Todos', 'Livro Caixa' => 'Livro Caixa', 'Imposto de Renda' =>
                'Imposto de
                Renda'], NULL, ['id' => 'opcao', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    @else
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Paciente: </span>
                {!! Form::text("paciente", NULL, ['id' => 'paciente_id', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    @endif
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Tipo: </span>
                {!! Form::select("tipo_id", $parametros["opcoes"], NULL, ['id' => 'tipo_id', 'class' =>
                'form-control', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 filtro-search">
            <div class="input-group">
                {!! Form::select("filtro", [NULL => "Nenhum", "num_doc" => "Número do Documento", "valor" => "Valor",
                "descricao" => "Descrição"], @$parametros['filtro'], ['class' => 'form-control
                pesquisa-avancada-filtro']) !!}
                {!! Form::text("valor", $parametros['valor'], ['class' => 'form-control pesquisa-avancada-valor']) !!}
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn btn-success" data-toggle="modal"
                        data-target="#pesquisa-avancada"><i class="fa fa-plus"></i></a>
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                </span>
            </div>
        </div>

        <!-- Modal da pesquisa avançada -->
        <div class="modal fade" id="pesquisa-avancada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Pesquisa Avançada</h4>
                    </div>
                    <div class="modal-body">
                        <table id="table_pesquisa_avancada" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Coluna</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {!! Form::select("filtro_avancado[]", [NULL => "Nenhum", "num_doc" => "Número do
                                        Documento", "valor" => "Valor Total", "descricao" => "Descrição"],
                                        @$parametros['filtro'], ['class' => 'form-control filtro_avancado']) !!}
                                    </td>
                                    <td>
                                        {!! Form::select("tipo_avancado[]", [NULL => "Nenhum", "=" => "=", "<"=> "
                                            <", ">"=> ">", "like" => "Contém", "not like" => "Não Contém", "!=" =>
                                                "Diferente de", "in" => "Possui", "not in" => "Não Possui"], "=",
                                                ['class' => 'form-control tipo_avancado']) !!}
                                    </td>
                                    <td>
                                        <textarea class="form-control valor_avancado" name="valor_avancado[]"
                                            resizable="true" rows="1">{{$parametros["valor"]}}</textarea>
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
        @if(Auth::user()->permissao != 'Contador')
        <div class="col-md col-sm-12 col-xs-12 filtro-search">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('contas.create', ['tipo' => $tipo]) }}" type="button"
                        class="btn btn-success"><i class="fa fa-plus"></i> Nova @if($tipo == '0') Receita @else Despesa
                        @endif</a></div>
            </div>
        </div>
        @endif
        @endif
    </div>
    {!! Form::close() !!}
</div>

<div class="row form-group" style="margin-left:-5px">
    <div class="col-md-2 col-sm-6 col-xs-6">
        <div id="group-dropdown" class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Colunas <span class="caret"></span></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <ul style="list-style: none;padding: 0 10px;">
                    <li><input type="checkbox" id="check_lancamento" class="dropdown-check" data-column="lancamento"
                            checked> <label for="check_lancamento" class="font-weight-400"><span></span>Data de
                            Lançamento</label></li>
                    <li><input type="checkbox" id="check_paciente_id" class="dropdown-check" data-column="paciente_id"
                            checked> <label for="check_paciente_id" class="font-weight-400"><span></span>@if($tipo)
                            Fornecedor @else Paciente @endif</label></li>
                    <li><input type="checkbox" id="check_cnpj_cpf" class="dropdown-check" data-column="cnpj_cpf" checked>
                        <label for="check_cnpj_cpf" class="font-weight-400"><span></span>@if($tipo) CNPJ @else CPF @endif</label></li>
                    @if(!$tipo)
                    <li><input type="checkbox" id="check_pagador_nome" class="dropdown-check" data-column="pagador_nome"
                            checked> <label for="check_pagador_nome" class="font-weight-400"><span></span>Nome do Pagador</label></li>
                    <li><input type="checkbox" id="check_pagador_cpf" class="dropdown-check" data-column="pagador_cpf" checked>
                        <label for="check_pagador_cpf" class="font-weight-400"><span></span>CPF do Pagador</label></li>
                    @endif
                    <li><input type="checkbox" id="check_num_doc" class="dropdown-check" data-column="num_doc" checked>
                        <label for="check_num_doc" class="font-weight-400"><span></span>Número do Documento</label></li>
                    <li><input type="checkbox" id="check_opcao" class="dropdown-check" data-column="opcao" checked>
                        <label for="check_opcao" class="font-weight-400"><span></span>Opção</label></li>
                    <li><input type="checkbox" id="check_tipo" class="dropdown-check" data-column="tipo" checked>
                        <label for="check_tipo" class="font-weight-400"><span></span>Tipo</label></li>
                    <li><input type="checkbox" id="check_valor" class="dropdown-check" data-column="valor" checked>
                        <label for="check_valor" class="font-weight-400"><span></span>Valor</label></li>
                    <li><input type="checkbox" id="check_descricao" class="dropdown-check" data-column="descricao"
                            checked> <label for="check_descricao" class="font-weight-400"><span></span>Descrição</label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-6 form-group">
        {!! Form::open(['route' => 'contas.index', 'method' => 'GET', 'target' => '_blank', 'id' => 'form-print']) !!}
        {!! Form::hidden("tipo", $tipo) !!}
        {!! Form::hidden("pdf", true) !!}
        {!! Form::hidden("paciente_id", @$parametros['paciente_id']) !!}
        {!! Form::hidden("medico_id", @$parametros['medico_id'], ['id' => 'hidden_medico_id']) !!}
        {!! Form::hidden("opcao", @$parametros['opcao']) !!}
        {!! Form::hidden("tipo_id", @$parametros['tipo_id']) !!}
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
        <div class="input-group">
            <select name="margem" class="form-control">
                <option value="true">Com Margem</option>
                <option value="false">Sem Margem</option>
            </select>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</button>
            </span>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@if($contas->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th class="lancamento">Data de Lançamento</th>
                    <th class="paciente_id">@if($tipo) Fornecedor @else Paciente @endif</th>
                    <th class="cnpj_cpf">@if($tipo) CNPJ @else CPF @endif</th>
                    @if(!$tipo)
                    <th class="pagador_nome">Nome do Pagador</th>
                    <th class="pagador_cpf">CPF do Pagador</th>
                    @endif
                    <th class="num_doc">Número do Documento</th>
                    <th class="opcao">Opção</th>
                    <th class="tipo">Tipo</th>
                    <th class="valor">Valor</th>
                    <th class="descricao">Descrição</th>
                    <th colspan="4"></th>
                </tr>
            </thead>

            <tbody>
                <tr class="linha_total">
                    <td class="lancamento"></td>
                    <td class="paciente_id"></td>
                    <td class="cnpj_cpf"></td>
                    @if(!$tipo)
                    <td class="pagador_nome"></td>
                    <td class="pagador_cpf"></td>
                    @endif
                    <td class="num_doc"></td>
                    <td class="opcao"></td>
                    <td class="tipo"></td>
                    <td class="valor">{{number_format($total,2,',','.')}}</td>
                    <td class="descricao"></td>
                    <td class="table_actions" @if($tipo) colspan="2" @endif></td>
                    <td class="table_actions"></td>
                    @if(in_array(Auth::user()->permissao, ['Gerencial', 'Master']))<td></td>@endif
                </tr>
                @foreach($contas as $contum)
                <tr>
                    <td class="lancamento">{{@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')}}
                    </td>
                    <td class="paciente_id">{{@$contum->paciente_ou_fornecedor()->nome}}</td>
                    <td class="cnpj_cpf">@if($tipo) {{@$contum->paciente_ou_fornecedor()->cnpj}} @else {{@$contum->paciente_ou_fornecedor()->cpf}} @endif </td>
                    @if(!$tipo)
                    <td class="pagador_nome">{{@$contum->paciente_ou_fornecedor()->pagador()->nome}}</td>
                    <td class="pagador_cpf">{{@$contum->paciente_ou_fornecedor()->pagador()->cpf}}</td>
                    @endif
                    <td class="num_doc">{{$contum->num_doc}}</td>
                    <td class="opcao">{{$contum->opcao}}</td>
                    <td class="tipo">{{@$contum->tipo()->nome}}</td>
                    <td class="valor">{{number_format($contum->valor,2,',','.')}}</td>
                    <td class="descricao">{{$contum->descricao}}</td>
                    @if($tipo)
                    @if($contum->recibo)
                    <td class="table_actions" align="center" title="Recibo">
                        <a href="{{ "storage/contas/$contum->id/$contum->recibo", $contum->recibo }}" target="_blank">
                            {!! Html::image("images/icons/print.png", "Recibo") !!}
                        </a>
                    </td>
                    <td class="table_actions" align="center" title="Recibo">
                        <a href="javascript:;" class="link-upload-recibo" data-toggle="modal"
                            data-target="#upload-recibo" data-id="{{$contum->id}}">
                            {!! Html::image("images/icons/up.png", "Recibo") !!}
                        </a>
                    </td>
                    @else
                    <td class="table_actions" align="center" title="Recibo" colspan="2">
                        <a href="javascript:;" class="link-upload-recibo" data-toggle="modal"
                            data-target="#upload-recibo" data-id="{{$contum->id}}">
                            {!! Html::image("images/icons/up.png", "Recibo") !!}
                        </a>
                    </td>
                    @endif
                    @else
                    <td class="table_actions" align="center" title="Recibo">
                        <a href="contas/{{$contum->id}}/recibo" target="_blank"><i class="fa fa-file"></i></a>
                    </td>
                    @endif
                    <td class="table_actions" align="center" title="Editar Contum">
                        <a href="{{ route('contas.edit', ['id' => $contum->id, 'tipo' => $tipo]) }}"><i
                                class="fa fa-edit"></i></a>
                    </td>
                    @if(in_array(Auth::user()->permissao, ['Gerencial', 'Master']))
                    <td class="table_actions" align="center" title="Deletar Contum">
                        <a onclick="confirm_delete('{{ route('contas.destroy', ['id' => $contum->id, 'tipo' => $tipo]) }}')"
                            href="javascript:;" data-toggle="modal" data-target="#confirm_delete"><i
                                class="fa fa-remove"></i></a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$contas->firstItem()}}</strong> ao
        <strong>{{$contas->lastItem()}}</strong> de um total de <strong>{{$contas->total()}}</strong> registros</p>
    {!! $contas->appends(['data1' => @$parametros['data1'], 'data2' => @$parametros['data2'], 'medico_id' =>
    @$parametros['medico']->id, 'paciente' => @$parametros['paciente'], 'tipo' => @$parametros['tipo'], 'filtro' =>
    @$parametros['filtro'], 'valor' => @$parametros['valor'], 'filtro_avancado' => @$parametros['filtro_avancado'],
    'tipo_avancado' => @$parametros['tipo_avancado'], 'valor_avancado' => @$parametros['valor_avancado']])->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma @if($tipo == '0') receita @else despesa @endif encontrada!</h2>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal de cadastro de recibo para despesa --}}
<div class="modal fade" id="upload-recibo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload de Recibo</h4>
            </div>
            {!! Form::open(['route' => ['contas.recibo', 0], 'method' => 'post', 'id' => 'form-upload-recibo', 'class'
            => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-body">
                {!! Form::hidden('id') !!}
                <div class="row form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        {!! Html::decode(Form::label('anexo', 'Recibo', ['class' => 'control-label'])) !!}
                        {!! Form::file('recibo', ['class' => 'filestyle']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<style type="text/css">
    .data-search select,
    .data-search input {
        width: 33.3% !important;
    }

    .filtro-search select,
    .filtro-search input {
        width: 50% !important;
    }

    .linha_filho {
        background: #F0F8FF
    }

    #doctor-warning {
        color: red;
        text-align: center;
        width: 100%;
        margin: 0;
    }
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

    // Altera os campos de tipo e opções
    $("input[name=opcao]").change(function(){
    $("#tipo_id").val("");

    if($(this).val() == "Livro Caixa")
        opcoes = ['Emissão de Recibo','Aluguel','Salário','Convênio','Pró-labore','Outros'];
    else
        opcoes = ['INSS','IRPF','Despesas Dedutíveis','Saúde'];

    $("#tipo_id > option").remove();

    for (const key in opcoes)
        $("#tipo_id").append(`<option value='${opcoes[key]}'>${opcoes[key]}</option>`);
    });

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
        if(!$("#hidden_medico_id").val()){
            event.preventDefault();
            alert('Selecione um médico!');
        }
    });

    // function id_to_modal(id) {
    $('.link-upload-recibo').click(function() {
        action = $('form#form-upload-recibo').attr('action').split('/');
        action[action.length - 2] = $(this).attr('data-id');
        $('form#form-upload-recibo').attr('action', action.join('/'));
        console.log(action);
    });
</script>

@endsection