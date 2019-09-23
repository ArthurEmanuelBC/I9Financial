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
                    <div class="col-md-5 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('nome', $paciente->nome, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('cpf', 'CPF <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('cpf', $paciente->cpf, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('email', 'Email <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::email('email', $paciente->email, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    </div>
        <div class="form-group text-right">
            <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
            <a class="templatemo-white-button" href="<?php echo e(route('pacientes.index')); ?>"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    <?php echo Form::close(); ?>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>