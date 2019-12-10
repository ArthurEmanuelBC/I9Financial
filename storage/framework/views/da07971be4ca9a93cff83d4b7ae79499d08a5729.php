<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>                
    <div class="media">
        <div class="media-body">
            <ul>
                <?php foreach($errors->all() as $error): ?>
                <li><h2><?php echo e($error); ?></h2></li>
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
                <?php echo Html::decode(Form::label('date', 'Data de Lançamento <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::date('date', $contum->date, ['class' => 'form-control date','required' => 'true','readonly' => true]); ?>

            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php if($tipo): ?>
                <?php echo Html::decode(Form::label('paciente_id', 'Paciente <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::select("paciente_id", $pacientes, $contum->paciente_id, ['id' => 'paciente', 'class' => 'form-control select2-search paciente_id', 'required' => 'true']); ?>

                <?php else: ?>
                <?php echo Form::label('fornecedor', 'Fornecedor', ['class' => 'control-label']); ?>

                <?php echo Form::text('fornecedor', $contum->fornecedor, ['class' => 'form-control fornecedor',]); ?>

                <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <?php echo Form::label('num_doc', 'Núm Documento', ['class' => 'control-label']); ?>

                <?php echo Form::text('num_doc', $contum->num_doc, ['class' => 'form-control num_doc',]); ?>

            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('valor', 'Valor Total <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::text('valor', NULL, ['class' => 'form-control valor','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php else: ?> <?php echo Form::text('valor', number_format($contum->valor,2,',','.'), ['class' => 'form-control', 'onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php endif; ?>
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
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="<?php echo e(route('contas.index', ['tipo' => $tipo])); ?>"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    <?php echo Form::close(); ?>

    
</div>

<!-- Modals -->
<div class="modal fade" id="confirm_pagar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
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

<style type="text/css">
    a.fechar-formulario {
        font-size: 18px;
        color: #c9302c;
    }
</style>

<script type="text/javascript">
    // Oculta/exibe o campo de desconto
    $(document).on('change','select.tipo_pagamento',function(){
        $formulario = $(this).parent().parent().parent();
        switch ($(this).val()) {
            case "Crédito":
            $formulario.find("select.cartao").parent().removeClass('hide');
            $formulario.find("input.qtd_parcelas").prop("readonly",false);
            break;
            
            case "Boleto":
            case "Cheque Pré-Datado":
            $formulario.find("select.cartao").parent().addClass('hide');
            $formulario.find("input.qtd_parcelas").prop("readonly",false);
            break;
            
            default:
            $formulario.find("select.cartao").parent().addClass('hide');
            $formulario.find("input.qtd_parcelas").prop("readonly",true);
            break;
        }
        // $formulario.find("input.qtd_parcelas").val(1);
    });
    $("select.tipo_pagamento").change();
    
    
    // Popula o form de confirmação de pagamento da parcela
    function confirm_pagar(url) {
        $('#form-pagar').attr('action', url);
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>