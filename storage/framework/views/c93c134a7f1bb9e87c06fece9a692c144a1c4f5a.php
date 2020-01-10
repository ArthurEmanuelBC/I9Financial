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
  Recebemos do(a) Sr(a). <?php if($conta->paciente()->pagador()): ?> <?php echo e($conta->paciente()->pagador()->nome); ?>, CPF nº
  <?php echo e($conta->paciente()->pagador()->cpf); ?>, <?php else: ?>
  <?php echo e($conta->paciente()->nome); ?>, CPF nº <?php echo e($conta->paciente()->cpf); ?>, <?php endif; ?> a importância de R$
  <?php echo e(number_format($conta->valor,2,',','.')); ?>, referente a(s) despesa(s) decorrente do atendimento do paciente
  <?php echo e($conta->paciente()->nome); ?>, neste estabelecimento.
</p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_pdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>