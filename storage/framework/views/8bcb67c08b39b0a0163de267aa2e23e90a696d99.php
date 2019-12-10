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
        Novo <?php echo e(substr_replace("Médicos", "", -1)); ?>

    </h2>

    <?php echo Form::open(['route' => [$url, $empresa->id], 'method' => $method, 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']); ?>

    <div class="row form-group">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('nome', $empresa->nome, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('cpf', 'CPF <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('cpf', $empresa->cpf, ['class' => 'form-control cpf','required' => 'true']); ?>

                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('crm', 'CRM <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('crm', $empresa->crm, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Form::label('cep', 'CEP', ['class' => 'control-label']); ?>

                    <?php echo Form::text('cep', $empresa->cep, ['class' => 'form-control',]); ?>

                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('logradouro', 'Logradouro <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('logradouro', $empresa->logradouro, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('bairro', 'Bairro <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('bairro', $empresa->bairro, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('cidade', 'Cidade <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('cidade', $empresa->cidade, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('estado', 'Estado <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('estado', $empresa->estado, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('numero', 'Número <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('numero', $empresa->numero, ['class' => 'form-control','required' => 'true']); ?>

                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                    <?php echo Form::label('complemento', 'Complemento', ['class' => 'control-label']); ?>

                    <?php echo Form::text('complemento', $empresa->complemento, ['class' => 'form-control',]); ?>

                    </div>
                    </div>
                    <div class="row form-group">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('telefone', 'Telefone <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                    <?php echo Form::text('telefone', $empresa->telefone, ['class' => 'form-control telefone','required' => 'true']); ?>

                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    <?php echo Html::decode(Form::label('anexo', 'Assinatura digitalizada', ['class' => 'control-label'])); ?>

                    <?php if($method == "post"): ?>
                    <?php echo Form::file('anexo', ['class' => 'filestyle']); ?>

                    <?php else: ?>
                    <?php echo Form::file('anexo', ['class' => 'filestyle', 'data-placeholder' => $empresa->anexo]); ?>

                    <?php endif; ?>
                    </div>
                    </div>
        <div class="form-group text-right">
            <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
            <a class="templatemo-white-button" href="<?php echo e(route('empresas.index')); ?>"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    <?php echo Form::close(); ?>


</div>

<script type="text/javascript">
    // Adiciona os valores de endereço a partir do blur no campo de cep
    $("#cep").blur(function(){
        var cep_code = $(this).val();
        if( cep_code.length <= 0 ) return;
        $.get("http://apps.widenet.com.br/busca-cep/api/cep.json", { code: cep_code },
            function(result){
            if( result.status!=1 ){
                return;
            }
            $("input#cep").val( result.code );
            $("input#estado").val( result.state );
            $("input#cidade").val( result.city );
            $("input#bairro").val( result.district );
            $("input#logradouro").val( result.address );
            $("input#estado").val( result.state );
            });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>