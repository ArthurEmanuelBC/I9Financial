<?php $__env->startSection('content'); ?>
<style type="text/css">
  p,
  table tr td {
    font-size: 24px;
  }
</style>

<h2 align="center"><?php echo e($conta->medico()->nome); ?></h2>

<table class="no-border">
  <tr>
    <td colspan="2"><?php echo e($conta->medico()->cpf); ?></td>
  </tr>
  <tr>
    <td><?php echo e($conta->medico()->logradouro); ?></td>
    <td><?php echo e($conta->medico()->bairro); ?></td>
  </tr>
  <tr>
    <td><?php echo e($conta->medico()->cidade); ?></td>
    <td><?php echo e($conta->medico()->estado); ?></td>
  </tr>
  <tr>
    <td><?php echo e($conta->medico()->cep); ?></td>
    <td>Fone: <?php echo e($conta->medico()->telefone); ?></td>
  </tr>
</table>

<p style="text-align: right"><strong>Nº <?php echo e($conta->num_doc); ?></strong></p>

<p style="text-align: right">R$ <?php echo e(number_format($conta->valor,2,',','.')); ?></p>

<p>
  Recebemos do(a) Sr(a). <?php if($conta->paciente_ou_fornecedor()->pagador()): ?>
  <?php echo e($conta->paciente_ou_fornecedor()->pagador()->nome); ?>, CPF nº
  <?php echo e($conta->paciente_ou_fornecedor()->pagador()->cpf); ?>, <?php else: ?>
  <?php echo e($conta->paciente_ou_fornecedor()->nome); ?>, CPF nº <?php echo e($conta->paciente_ou_fornecedor()->cpf); ?>, <?php endif; ?> a importância de
  R$
  <?php echo e(number_format($conta->valor,2,',','.')); ?>, referente a(s) despesa(s) decorrente do atendimento do paciente
  <?php echo e($conta->paciente_ou_fornecedor()->nome); ?>, neste estabelecimento.
</p>

<div class="assinatura">
  <p>João Pessoa, <?php echo e(@date_format(date_create_from_format('Y-m-d', $conta->date), 'd/m/Y')); ?></p>
  <p><?php echo Html::image('/storage/empresas/'.$conta->medico()->id.'/'.$conta->medico()->anexo, "Assinatura"); ?></p>
</div>
<?php $__env->stopSection(); ?>

<style>
  .assinatura {
    margin-top: 50px;
    text-align: center;
    justify-content: center;
  }

  .assinatura img {
    width: 200px;
  }
</style>
<?php echo $__env->make('template_pdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>