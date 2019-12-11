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
        Novo <?php echo e(substr_replace("Pacientes", "", -1)); ?>

    </h2>

    <?php echo Form::open(['route' => [$url, $paciente->id], 'method' => $method, 'class' => 'form-horizontal']); ?>

    <div class="row form-group">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('nome', $paciente->nome, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('cpf', 'CPF <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('cpf', $paciente->cpf, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="checkbox squaredTwo">
                    <input type="checkbox" id="pagador" name="pagador" <?php if($paciente->pagador_id): ?> checked <?php endif; ?>/>
                    <label for="pagador" class="control-label"><span></span>Possui pagador?</label>
                </div>
            </div>
        </div>
        <div id="row_pagador" class="row form-group hide">
            <div class="col-md-8">
                <?php echo Html::decode(Form::label('pagador_nome', 'Nome do Pagador <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::text('pagador_nome', @$paciente->pagador()->nome, ['class' => 'form-control','required' => $paciente->pagador_id]); ?>

            </div>
            <div class="col-md-4">
                <?php echo Html::decode(Form::label('pagador_cpf', 'CPF do Pagador <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::text('pagador_cpf', @$paciente->pagador()->cpf, ['class' => 'form-control cpf','required' => $paciente->pagador_id]); ?>

            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
            <a class="templatemo-white-button" href="<?php echo e(route('pacientes.index')); ?>"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    <?php echo Form::close(); ?>


</div>

<script type="text/javascript">
    <?php if($paciente->pagador_id): ?>
    $("#row_pagador").removeClass('hide');
    <?php endif; ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>