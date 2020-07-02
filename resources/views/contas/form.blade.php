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
    <h2 class="margin-bottom-10">
        @if(Request::is('*contas/create'))
        Cadastrar @if($tipo == '0') Receita @else Despesa @endif
        @else
        Editar @if($tipo == '0') Receita @else Despesa @endif
        @endif
    </h2>

    {!! Form::open(['route' => [$url, $contum->id], 'method' => $method, 'class' => 'form-horizontal', 'enctype' =>
    'multipart/form-data']) !!}
    {!! Form::hidden('tipo', $tipo) !!}
    <div id="formulario_0" class="formulario">
        <div class="row form-group row-multiple">
            <div class="col-md-4 col-sm-12 col-xs-12">
                {!! Html::decode(Form::label('date', 'Data de Lançamento <span class="obrigatorio">*</span>', ['class'
                => 'control-label'])) !!}
                {!! Form::date('date', $contum->date, ['class' => 'form-control date','required' => true,'readonly' =>
                $disabled]) !!}
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                @if($tipo == '0')
                {!! Html::decode(Form::label('paciente_id', 'Paciente <span class="obrigatorio">*</span>', ['class' =>
                'control-label', 'disabled' => $disabled])) !!}
                @else
                {!! Html::decode(Form::label('paciente_id', 'Fornecedor <span class="obrigatorio">*</span>', ['class' =>
                'control-label', 'disabled' => $disabled])) !!}
                @endif

                @if($disabled)
                {!! Form::text('nome_id', @$contum->paciente_ou_fornecedor()->nome, ['class' => 'form-control',
                'disabled' => true]) !!}
                @else
                {!! Form::select("nome_id", $nomes, $contum->paciente_id, ['id' => 'paciente', 'class' =>
                'form-control select2-search paciente_id', 'required' => true, 'disabled' => $disabled]) !!}
                @endif
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                {!! Form::label('num_doc', @if($tipo == '0') 'Núm Documento' @else 'Número da Nota Fiscal' @endif, ['class' => 'control-label']) !!}
                {!! Form::text('num_doc', $contum->num_doc, ['class' => 'form-control num_doc', 'disabled' => $disabled]) !!}
            </div>
        </div>

        @if(Auth::user()->permissao == 'Gerencial' && $method == 'post')
        @php($col = '3')
        @else
        @php($col = '4')
        @endif

        <div class="row form-group row-multiple" style="margin-bottom: 0">
            <div class="col-md-{{$col}} col-sm-12 col-xs-12">
                {!! Html::decode(Form::label('opcao', 'Opção <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])) !!}
                <div class="templatemo-block">
                    <input type="radio" name="opcao" id="livro_caixa" value="Livro Caixa" @if($contum->opcao == "Livro
                    Caixa" || $method == 'post') checked @endif @if($disabled) disabled @endif>
                    <label for="livro_caixa" class="font-weight-400"><span></span>Livro Caixa</label>
                </div>
                <div class="templatemo-block">
                    <input type="radio" name="opcao" id="imposto_de_renda" value="Imposto de Renda" @if($contum->opcao
                    == "Imposto de Renda") checked @endif @if($disabled) disabled @endif>
                    <label for="imposto_de_renda" class="font-weight-400"><span></span>Imposto de Renda</label>
                </div>
            </div>
            <div class="col-md-{{$col}} col-sm-12 col-xs-12">
                {!! Html::decode(Form::label('tipo_id', 'Tipo <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])) !!}
                {!! Form::select("tipo_id", $opcoes, $contum->tipo_id, ['id' => 'tipo_id', 'class' =>
                'form-control select2-search paciente_id', 'required' => true, 'disabled' => $disabled]) !!}
            </div>
            @if($method == 'post')
            <div class="col-md-{{$col}} col-sm-12 col-xs-12">
                {!! Html::decode(Form::label('empresa_id', 'Médico <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])) !!}
                <div class="input-group">
                    {!! Form::select("empresa_id", $medicos, $contum->empresa_id, ['id' => 'empresa', 'class' =>
                    'form-control select2-search', 'required' => true, 'disabled' => $disabled]) !!}
                    @if($tipo == '0')
                    <span id="btn-check" class="input-group-btn hide">
                        <a href="javascript:;" class="btn btn-success" data-toggle="modal"
                            data-target="#verificar-margem"><i class="fa fa-dollar"></i></a>
                    </span>
                    @endif
                </div>
            </div>
            @endif
            <div class="col-md-{{$col}} col-sm-12 col-xs-12">
                {!! Html::decode(Form::label('valor', 'Valor Total <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])) !!}
                @if($method == 'post') {!! Form::text('valor', NULL, ['class' => 'form-control valor','onKeyDown' =>
                'Formata(this,20,event,2)', 'required' => 'true', 'id' => 'valor', 'disabled' => $disabled]) !!} @else
                {!! Form::text('valor',
                number_format($contum->valor,2,',','.'), ['class' => 'form-control', 'onKeyDown' =>
                'Formata(this,20,event,2)', 'required' => 'true', 'id' => 'valor', 'disabled' => $disabled]) !!} @endif
            </div>
        </div>
        @if($tipo == '1')
        <div class="row form-group">
            <div class="col-md-6 col-sm-12 col-xs-12">
                {!! Html::decode(Form::label('anexo', 'Recibo', ['class' => 'control-label'])) !!}
                @if($method == "post")
                {!! Form::file('recibo', ['class' => 'filestyle', 'disabled' => $disabled]) !!}
                @else
                {!! Form::file('recibo', ['class' => 'filestyle', 'data-placeholder' => $contum->recibo, 'disabled' =>
                $disabled]) !!}
                @endif
            </div>
            @if($method == 'post')
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="templatemo-block" style="padding-top: 30px">
                    <input type="checkbox" id="repetir-parcelas">
                    <label for="repetir-parcelas" class="font-weight-400"><span></span>Repetir Parcelas</label>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 col-parcelas hide">
                {!! Html::decode(Form::label('parcelas', 'Quantidade de Parcelas', ['class' => 'control-label'])) !!}
                {!! Form::number('parcelas', NULL, ['class' => 'form-control']) !!}
            </div>
            @endif
        </div>
        @endif
        <div class="row form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                {!! Form::label('descricao', 'Descrição', ['class' => 'control-label']) !!}
                {!! Form::textarea('descricao', $contum->descricao, ['class' => 'form-control descricao','rows' => '3',
                'disabled' => $disabled])
                !!}
            </div>
        </div>
    </div>

    <div class="form-group text-right">
        @if(!$tipo && $method == 'put')
        <a class="btn btn-success" href="/contas/{{$contum->id}}/recibo" target="_blank"><i class="fa fa-print"></i>
            Imprimir Recibo</a>
        @endif
        <button type="submit" class="templatemo-blue-button" @if($disabled) disabled
            style="background-color: gray" @endif><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('contas.index', ['tipo' => $tipo]) }}"><i
                class="fa fa-arrow-left"></i> Voltar para listagem</a>
    </div>
    {!! Form::close() !!}
</div>

<!-- Modals -->
<div class="modal fade" id="confirm_pagar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
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

<div class="modal fade" id="verificar-margem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Margem Disponível</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-3">
                        <label for="modal_margem">Emitir recibo até:</label>
                        <input id="modal_margem" name="modal_margem" class="form-control" type="text" disabled>
                    </div>
                    <div class="col-md-5">
                        <label for="modal_valor">Valor maior que o disponível, checar permissão aqui:</label>
                        <input id="modal_valor" name="modal_valor" class="form-control" type="text"
                            onKeyDown="Formata(this,20,event,2)">
                    </div>
                    <div class="col-md-4">
                        <button onclick="verifica_margem()" class="btn btn-success" style="margin-top: 23px"><i
                                class="fa fa-check"></i> Checar emissão de recibo</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    a.fechar-formulario {
        font-size: 18px;
        color: #c9302c;
    }
</style>

<script type="text/javascript">
    // Altera os campos de tipo e opções
    $("input[name=opcao]").change(function(){
        $("#tipo_id").val("");

        $.ajax({
            type: "GET",
            url: '/tipos_opcao',
            dataType: "html",
            data: "opcao=" + $(this).val() + "&tipo={{$tipo}}",
            success: function(response) {
                $("#tipo_id > option").remove();

                opcoes = JSON.parse(response);
                for (const key in opcoes)
                    $("#tipo_id").append(`<option value='${opcoes[key].id}'>${opcoes[key].nome}</option>`);
            }
        });

    });

    $('#empresa').change(function(){
        if($(this).val()) {
            get_margem_atual().then(response => {
                if(response > 5000)
                    $('#modal_margem').val('5.000,00');
                else
                    $('#modal_margem').val(number_format(response,2,',','.'))
            });
            $('#btn-check').removeClass('hide');
        } else {
            $('#btn-check').addClass('hide');
        }
    });

    async function get_margem_atual(){
        if(!$('#empresa').val()) {
            alert('Selecione um médico!');
            return;
        }

        $valor = null;

    	await $.ajax({
    		type: "GET",
    		url: `/empresas/${$('#empresa').val()}/margem`,
    		dataType: "html",
            success: function(response) {
                $valor = response;
            }
    	});

    	return parseFloat($valor);
    }

    async function tem_margem(id){
        $val = parseFloat($(`#${id}`).val().replace(/\./g,'').replace(',','.'));
        if(isNaN($val))
            $val = 0;

        $margem = null;
        await get_margem_atual().then(response => $margem = response);

        if($margem){
            if($val <= $margem)
                return true;
            else
                return false;
        }
    }

    async function verifica_margem(){
        if(await tem_margem('modal_valor'))
            alert('Emitir recibo!');
        else
            alert('Não emitir recibo!');
    }

    @if(!$tipo)
    $("#valor").keyup(async function(){
        if(await tem_margem('valor')){
            $('.templatemo-blue-button').attr('disabled', false);
            $('.templatemo-blue-button').css('background-color', '#39ADB4');
        } else {
            $('.templatemo-blue-button').attr('disabled', true);
            $('.templatemo-blue-button').css('background-color', 'gray');
        }
    });
    @endif

    @if($tipo && $method == 'post')
    $("#repetir-parcelas").change(function(){
        if($(this).attr('checked'))
            $('.col-parcelas').removeClass('hide');
        else
            $('.col-parcelas').addClass('hide');
    });
    @endif

</script>

@endsection