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
    <h2 class="margin-bottom-10">Parcelas</h2>
    <?php echo Form::open(['route' => 'contas.parcelas', 'method' => 'GET']); ?>

    <?php echo Form::hidden("tipo", $parametros['tipo']); ?>

    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 margin-bottom-10 data-search">
            <div class="input-group">
                <span class="input-group-addon">Data de Lançamento: </span>
                <?php echo Form::date("data1", $data1, ['class' => 'form-control']); ?>

                <?php echo Form::date("data2", $data2, ['class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 margin-bottom-10">
            <div class="input-group">
                <span class="input-group-addon">Operação: </span>
                <?php echo Form::select("tipo", [NULL => "Todos", 0 => "Entrada", 1 => "Saída"], $parametros['tipo'], ['class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 margin-bottom-10 filtro-search">
            <div class="input-group">
                <?php if($parametros['tipo'] != "2"): ?>
                <?php echo Form::select("filtro", [NULL => "Nenhum", "vencimento" => "Data de Vencimento", "pagamento" => "Data de Pagamento", "valor" => "Valor"], @$parametros['filtro'], ['class' => 'form-control pesquisa-avancada-filtro']); ?>

                <?php echo Form::text("valor", $parametros['valor'], ['class' => 'form-control pesquisa-avancada-valor']); ?>

                <?php else: ?>
                <span class="input-group-addon">Pacientes: </span>
                <select name="paciente_ids[]" class="form-control select2-search" multiple>
                    <?php foreach($parametros['pacientes'] as $id => $nome): ?>
                    <option value="<?php echo e($id); ?>" <?php if(in_array($id,$parametros['paciente_ids'])): ?> selected <?php endif; ?>><?php echo e($nome); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php endif; ?>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                    <!-- <a type="submit" class="btn btn-success" href="<?php echo e(route('contas.parcelas', ['tipo' => $parametros['tipo'], 'data1' => $data1->format('d/m/Y'), 'data2' => $data2->format('d/m/Y'), 'paciente_ids' => $parametros['paciente_ids'], 'pdf' => true])); ?>" target="_blank"><i class="fa fa-print"></i> Imprimir</a> -->
                </span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 margin-bottom-10">
        </div>
    </div>
    <?php echo Form::close(); ?>

</div>


<?php if($parcelas->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>Data de Lançamento</th>
                    <th>Data de Vencimento</th>
                    <th>Data de Pagamento</th>
                    <th>Paciente</th>
                    <th>Observação</th>
                    <th>Valor</th>
                    <th>Tipo de Pagamento</th>
                    <th>Usuário</th>
                    <th>Status</th>
                    <th>Pendência</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach($parcelas as $parcela): ?>
                <tr>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->lancamento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->vencimento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->pagamento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@$parcela->conta()->paciente()->nome); ?></td>
                    <td><?php echo e($parcela->conta()->descricao); ?></td>
                    <td><?php echo e(number_format($parcela->valor,2,',','.')); ?></td>
                    <td><?php echo e($parcela->conta()->tipo_pagamento); ?></td>
                    <td><?php echo e($parcela->conta()->user()->name); ?></td>
                    <td><?php if($parcela->tipo): ?> Saída <?php else: ?> Entrada <?php endif; ?></td>
                    <?php if($parcela->pago): ?>
                    <td class="table_actions" align="center" title="Gerar Pendência">
                        <a onclick="confirm_pendencia('<?php echo e(route('parcelas.pagar', ['id' => $parcela->id, 'tipo' => $parametros['tipo'], 'data1' => $data1->format('d/m/Y'), 'data2' => $data2->format('d/m/Y'), 'desfazer' => true])); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_pendencia"><i class="fa fa-square-o"></i></a>
                    </td>
                    <?php else: ?>
                    <td class="table_actions" align="center" title="Pendente"><i class="fa fa-check-square"></i></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong><?php echo e($parcelas->firstItem()); ?></strong> ao <strong><?php echo e($parcelas->lastItem()); ?></strong> de um total de <strong><?php echo e($parcelas->total()); ?></strong> registros</p>
    <?php echo $parcelas->render(); ?>

</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma Parcela encontrada!</h2>
            </div>        
        </div>                
    </div>
</div>
<?php endif; ?>

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
<div class="modal fade" id="confirm_pendencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Deseja realmente gerar a pendência desta parcela?</h4>
            </div>
            <div class="modal-footer">
                <?php echo Form::open(['route' => null, 'method' => 'POST', 'id' => 'form-pendencia']); ?>

                <button type="submit" class="btn btn-primary">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .filtro-search select, .filtro-search input { width: 50% !important; }
    .data-search .form-control { width: 50%; }
</style>

<script type="text/javascript">
    // Popula o form de confirmação de conferência da parcela
    function confirm_conferir(url) {
        $('#form-conferir').attr('action', url);
    }
    
    // Popula o form de confirmação de pagamento da parcela
    function confirm_pagar(url) {
        $('#form-pagar').attr('action', url);
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>