<?php $__env->startSection('content'); ?>
<?php if(Session::has('message')): ?>
<div class="templatemo-content-widget green-bg">
  <i class="fa fa-times"></i>
  <div class="media">
    <div class="media-body">
      <h2><?php echo e(Session::get('message')); ?></h2>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="templatemo-content-widget white-bg">
  <h2 class="margin-bottom-10">Controle</h2>
  <?php echo Form::open(['route' => 'parcelas.controle', 'method' => 'GET']); ?>

  <?php echo Form::hidden("mes", $mes); ?>

  <?php echo Form::hidden("ano", $ano); ?>

  <div class="row form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon">Tipo: </span>
        <?php echo Form::select("tipo", $tipos, $tipo, ['id' => 'tipo', 'class' =>
        'form-control', 'required' => 'true']); ?>

      </div>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon">Médico: </span>
        <?php echo Form::select("medico_id", $medicos, @$medico->id, ['id' => 'medico_id', 'class' =>
        'form-control']); ?>

      </div>
      <p id="doctor-warning">Selecione um médico</p>
    </div>
    <div class="col-md-2 col-sm-12 col-xs-12"></div>
    <div class="col-md-4 col-sm-12 col-xs-12">
      <?php if(isset($medico)): ?>
      <div class="input-group">
        <span class="input-group-addon">Margem disponível: </span>
        <?php echo Form::text("margem", number_format($medico->margem_atual(),2,',','.'), ['class' => 'form-control','disabled'
        => true]); ?>

      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Pesquisar</button>
    </div>
  </div>
  <?php echo Form::close(); ?>

</div>

<div class="templatemo-content-widget">
  <div class="btn-group" data-toggle="buttons">
    <div class="btn-group">
      <button type="button" class="btn btn-default active dropdown-toggle" data-toggle="dropdown">
        <?php echo e($ano); ?> <span class="caret"></span></button>
      <ul class="dropdown-menu" role="menu">
        <?php foreach([2019,date('Y')] as $year): ?>
        <li><a
            href="<?php echo e(route('parcelas.controle', ['ano' => $year, 'mes' => $mes, 'tipo' => $tipo, 'medico_id' => @$medico->id])); ?>"><?php echo e($year); ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php foreach($meses as $numero => $nome): ?>
    <label class="btn btn-default link-mes <?php if($mes === $numero): ?> active <?php endif; ?>"
      data-number='<?php echo e($numero); ?>'><?php echo e($nome); ?></label>
    <?php endforeach; ?>
  </div>
  <a href="<?php echo e(route('parcelas.controle', ['ano' => $year, 'mes' => $mes, 'tipo' => $tipo, 'medico_id' => @$medico->id, 'pdf' => true])); ?>"
    target="_blank" class="btn btn-success pull-right"><i class="fa fa-print"></i> Imprimir</a>
</div>

<?php if($parcelas->count()): ?>
<div class="templatemo-content-widget no-padding">
  <div class="panel panel-default table-responsive">
    <table class="table table-striped table-bordered templatemo-user-table">
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
  </div>
</div>
<div class="pagination-wrap">
  <p class="text_pagination pull-left">Exibindo do <strong><?php echo e($parcelas->firstItem()); ?></strong> ao
    <strong><?php echo e($parcelas->lastItem()); ?></strong> de um total de <strong><?php echo e($parcelas->total()); ?></strong> registros</p>
  <?php echo $parcelas->render(); ?>

</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
  <div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>
    <div class="media">
      <div class="media-body">
        <h2>Nenhum registro encontrado!</h2>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<style type="text/css">
  .data-search select,
  .data-search input {
    width: 33.3% !important;
  }

  #doctor-warning {
    color: red;
    text-align: center;
    width: 100%;
    margin: 0;
  }
</style>

<script type="text/javascript">
  // Oculta/exibe o warning de selecionar médico
    $("#medico_id").change(function(){
        if($(this).val())
            $("#doctor-warning").addClass('hide');
        else
            $("#doctor-warning").removeClass('hide');
    });
    $("#medico_id").change();

    // Verifica se existe algum médico selecionado ao criar relatório
    $('#form-print').submit(function(event) {
        if(!$("#medico_id").val()){
            event.preventDefault();
            alert('Selecione um médico!');
        }
    });

    $('.link-mes').click(function(event) {
      if($(this).hasClass('active'))
        location.href = `parcelas_controle?ano=<?php echo e($ano); ?>&tipo=<?php echo e($tipo); ?>&medico_id=<?php echo e(@$medico->id); ?>`;
      else
        location.href = `parcelas_controle?mes=${$(this).attr('data-number')}&ano=<?php echo e($ano); ?>&tipo=<?php echo e($tipo); ?>&medico_id=<?php echo e(@$medico->id); ?>`;
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>