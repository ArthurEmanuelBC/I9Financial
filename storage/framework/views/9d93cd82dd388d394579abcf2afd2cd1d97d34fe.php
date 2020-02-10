<?php $__env->startSection('content'); ?>
<table>
  <thead>
    <tr>
      <th colspan="6">Margem Mensal de <?php echo e(@$medico->nome); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php ($ano = date('Y')); ?>
    <?php foreach(@$medico->margem_mensal() as $mes => $valor): ?>
    <?php if(in_array($mes, ["01/$ano","04/$ano","07/$ano","10/$ano"])): ?> <tr> <?php endif; ?>
      <td align="right"><strong><?php echo e($mes); ?>: </strong></td>
      <td><?php echo e(number_format($valor,2,',','.')); ?></td>
      <?php if(in_array($mes, ["03/$ano","06/$ano","09/$ano","12/$ano"])): ?>
    <tr> <?php endif; ?>
      <?php endforeach; ?>

    <tr>
      <td align="right" colspan="5"><strong>Valor Real da Margem Atual: </strong></td>
      <td><?php echo e(number_format(@$medico->margem_atual(),2,',','.')); ?></td>
    </tr>
  </tbody>
</table>

<table style="margin-top: 20px">
  <thead>
    <?php if(!in_array('lancamento', $ocultas)): ?> <th class="lancamento">Data de Lançamento</th> <?php endif; ?>
    <?php if(!in_array('paciente_id', $ocultas)): ?> <th class="paciente_id"><?php if($tipo): ?> Fornecedor <?php else: ?> Paciente <?php endif; ?></th>
    <?php endif; ?>
    <?php if(!in_array('num_doc', $ocultas)): ?> <th class="num_doc">Número do Documento</th> <?php endif; ?>
    <?php if($tipo == '1'): ?>
    <?php if(!in_array('opcao', $ocultas)): ?> <th class="opcao">Opção</th> <?php endif; ?>
    <?php endif; ?>
    <?php if(!in_array('tipo', $ocultas)): ?> <th class="tipo">Tipo</th> <?php endif; ?>
    <?php if(!in_array('valor', $ocultas)): ?> <th class="valor">Valor</th> <?php endif; ?>
    <?php if(!in_array('descricao', $ocultas)): ?> <th class="descricao">Descrição</th> <?php endif; ?>
  </thead>
  <tbody>
    <?php foreach($contas as $contum): ?>
    <tr>
      <?php if(!in_array('lancamento', $ocultas)): ?> <td class="lancamento">
        <?php echo e(@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')); ?> <?php endif; ?>
      </td>
      <?php if(!in_array('paciente_id', $ocultas)): ?> <td class="paciente_id"><?php echo e(@$contum->paciente_ou_fornecedor()->nome); ?></td>
      <?php endif; ?>
      <?php if(!in_array('num_doc', $ocultas)): ?> <td class="num_doc"><?php echo e($contum->num_doc); ?></td> <?php endif; ?>
      <?php if($tipo == '1'): ?>
      <?php if(!in_array('opcao', $ocultas)): ?> <td class="opcao"><?php echo e($contum->opcao); ?></td> <?php endif; ?>
      <?php endif; ?>
      <?php if(!in_array('tipo', $ocultas)): ?> <td class="tipo"><?php echo e($contum->tipo_conta); ?></td> <?php endif; ?>
      <?php if(!in_array('valor', $ocultas)): ?> <td class="valor"><?php echo e(number_format($contum->valor,2,',','.')); ?></td> <?php endif; ?>
      <?php if(!in_array('descricao', $ocultas)): ?> <td class="descricao"><?php echo e($contum->descricao); ?></td> <?php endif; ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_pdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>