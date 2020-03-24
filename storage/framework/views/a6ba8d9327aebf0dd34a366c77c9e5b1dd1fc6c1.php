<?php $__env->startSection('content'); ?>
<table style="margin-top: 20px">
  <thead>
    <tr>
      <th>Data de Lançamento</th>
      <th>Fornecedor/Paciente</th>
      <th>Número do Documento</th>
      <th>Opção</th>
      <th>Tipo</th>
      <th>Valor</th>
      <th>Descrição</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($parcelas as $contum): ?>
    <tr>
      <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')); ?></td>
      <td><?php echo e(@$contum->paciente_ou_fornecedor()->nome); ?></td>
      <td><?php echo e($contum->num_doc); ?></td>
      <td><?php echo e($contum->opcao); ?></td>
      <td><?php if($contum->tipo): ?> Despesa <?php else: ?> Receita <?php endif; ?></td>
      <td><?php echo e(number_format($contum->valor,2,',','.')); ?></td>
      <td><?php echo e($contum->descricao); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_pdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>