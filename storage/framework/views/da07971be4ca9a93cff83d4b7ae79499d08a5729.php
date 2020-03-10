<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>
    <div class="media">
        <div class="media-body">
            <ul>
                <?php foreach($errors->all() as $error): ?>
                <li>
                    <h2><?php echo e($error); ?></h2>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        <?php if(Request::is('*contas/create')): ?>
        Cadastrar <?php if($tipo == '0'): ?> Receita <?php else: ?> Despesa <?php endif; ?>
        <?php else: ?>
        Editar <?php if($tipo == '0'): ?> Receita <?php else: ?> Despesa <?php endif; ?> #<?php echo e($contum->id); ?>

        <?php endif; ?>
    </h2>

    <?php echo Form::open(['route' => [$url, $contum->id], 'method' => $method, 'class' => 'form-horizontal']); ?>

    <?php echo Form::hidden('tipo', $tipo); ?>

    <div id="formulario_0" class="formulario">
        <div class="row form-group row-multiple">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('date', 'Data de Lançamento <span class="obrigatorio">*</span>', ['class'
                => 'control-label'])); ?>

                <?php echo Form::date('date', $contum->date, ['class' => 'form-control date','required' => 'true','readonly' =>
                true]); ?>

            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php if($tipo == '0'): ?>
                <?php echo Html::decode(Form::label('paciente_id', 'Nome <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])); ?>

                <?php else: ?>
                <?php echo Html::decode(Form::label('paciente_id', 'Fornecedor <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])); ?>

                <?php endif; ?>
                <?php echo Form::select("nome_id", $nomes, $contum->paciente_id, ['id' => 'paciente', 'class' =>
                'form-control select2-search paciente_id', 'required' => 'true']); ?>

            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php echo Form::label('num_doc', 'Núm Documento', ['class' => 'control-label']); ?>

                <?php echo Form::text('num_doc', $contum->num_doc, ['class' => 'form-control num_doc', 'readonly' => true]); ?>

            </div>
        </div>

        <?php if($tipo == '1' && $method == 'post'): ?>
        <?php ($col = '3'); ?>
        <?php else: ?>
        <?php ($col = '4'); ?>
        <?php endif; ?>

        <div class="row form-group row-multiple">
            <?php if($tipo == '1'): ?>
            <div class="col-md-<?php echo e($col); ?> col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('opcao', 'Opção <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])); ?>

                <div class="templatemo-block">
                    <input type="radio" name="opcao" id="livro_caixa" value="Livro Caixa" <?php if($contum->opcao != "Imposto
                    de Renda"): ?> checked <?php endif; ?>>
                    <label for="livro_caixa" class="font-weight-400"><span></span>Livro Caixa</label>
                </div>
                <div class="templatemo-block">
                    <input type="radio" name="opcao" id="imposto_de_renda" value="Imposto de Renda" <?php if($contum->opcao
                    == "Imposto de Renda"): ?> checked <?php endif; ?>>
                    <label for="imposto_de_renda" class="font-weight-400"><span></span>Imposto de Renda</label>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-<?php echo e($col); ?> col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('tipo_conta', 'Tipo <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])); ?>

                <?php echo Form::select("tipo_conta", $opcoes, $contum->tipo_conta, ['id' => 'tipo_conta', 'class' =>
                'form-control select2-search paciente_id', 'required' => 'true']); ?>

            </div>
            <?php if($method == 'post'): ?>
            <div class="col-md-<?php echo e($col); ?> col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('empresa_id', 'Médico <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])); ?>

                <div class="input-group">
                    <?php echo Form::select("empresa_id", $medicos, $contum->empresa_id, ['id' => 'empresa', 'class' =>
                    'form-control select2-search', 'required' => 'true']); ?>

                    <?php if($tipo == '0'): ?>
                    <span id="btn-check" class="input-group-btn hide">
                        <a href="javascript:;" class="btn btn-success" data-toggle="modal"
                            data-target="#verificar-margem"><i class="fa fa-dollar"></i></a>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-<?php echo e($col); ?> col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('valor', 'Valor Total <span class="obrigatorio">*</span>', ['class' =>
                'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::text('valor', NULL, ['class' => 'form-control valor','onKeyDown' =>
                'Formata(this,20,event,2)', 'required' => 'true', 'id' => 'valor']); ?> <?php else: ?> <?php echo Form::text('valor',
                number_format($contum->valor,2,',','.'), ['class' => 'form-control', 'onKeyDown' =>
                'Formata(this,20,event,2)', 'required' => 'true', 'id' => 'valor']); ?> <?php endif; ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php echo Form::label('descricao', 'Descrição', ['class' => 'control-label']); ?>

                <?php echo Form::textarea('descricao', $contum->descricao, ['class' => 'form-control descricao','rows' => '3']); ?>

            </div>
        </div>
    </div>

    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button" disabled style="background-color: gray"><i
                class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="<?php echo e(route('contas.index', ['tipo' => $tipo])); ?>"><i
                class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    <?php echo Form::close(); ?>


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
                <?php echo Form::open(['route' => null, 'method' => 'POST', 'id' => 'form-pagar']); ?>

                <button type="submit" class="btn btn-primary">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <?php echo Form::close(); ?>

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
    <?php if($tipo == '1'): ?>
    $("input[name=opcao]").change(function(){
        $("#tipo_conta").val("");

        if($(this).val() == "Livro Caixa")
            opcoes = ['Pessoal','Material Médico','Material de Custeio','Marketing/divulgação','Outros'];
        else
            opcoes = ['INSS','IRPF','Despesas Dedutíveis','Saúde'];

        $("#tipo_conta > option").remove();

        for (const key in opcoes)
            $("#tipo_conta").append(`<option value='${opcoes[key]}'>${opcoes[key]}</option>`);
    });
    <?php endif; ?>

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

    $("#valor").keyup(async function(){
        if(await tem_margem('valor')){
            $('.templatemo-blue-button').attr('disabled', false);
            $('.templatemo-blue-button').css('background-color', '#39ADB4');
        } else {
            $('.templatemo-blue-button').attr('disabled', true);
            $('.templatemo-blue-button').css('background-color', 'gray');
        }
    });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>