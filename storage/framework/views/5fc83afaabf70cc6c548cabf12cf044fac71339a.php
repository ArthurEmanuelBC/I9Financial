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
        Novo <?php echo e(substr_replace("Fornecedors", "", -1)); ?>

    </h2>

    <?php echo Form::open(['route' => [$url, $fornecedor->id], 'method' => $method, 'class' => 'form-horizontal']); ?>

    <div class="row form-group">
        <div class="col-md-6">
            <?php echo Html::decode(Form::label('name', 'Nome <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])); ?>

            <?php echo Form::text('name', $fornecedor->name, ['class' => 'form-control','required' => 'true']); ?>

        </div>
        <div class="col-md-6">
            <?php echo Html::decode(Form::label('cnpj', 'CNPJ <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])); ?>

            <?php echo Form::text('cnpj', $fornecedor->cnpj, ['class' => 'form-control','required' => 'true']); ?>

        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="<?php echo e(route('fornecedors.index')); ?>"><i class="fa fa-arrow-left"></i>
            Voltar</a>
    </div>
    <?php echo Form::close(); ?>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>