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
    <h2 class="margin-bottom-10">Pacientes</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" <?php if($filtro == "nome"): ?> selected <?php endif; ?>>Nome</option>
                    <option value="cpf" <?php if($filtro == "cpf"): ?> selected <?php endif; ?>>CPF</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="<?php echo e($valor); ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
                <div class="pull-right"><a href="<?php echo e(route('pacientes.create')); ?>" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo <?php echo e(substr_replace("Pacientes", "", -1)); ?></a></div>
            </div>
        </div>
    </div>
</div>


<?php if($pacientes->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=nome" class="white-text templatemo-sort-by">Nome <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'nome') !== false): ?>active <?php endif; ?>">Nome <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=nome',Request::fullUrl())); ?> <?php if($param == 'nome'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'nome') !== false): ?>active <?php endif; ?>">Nome <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=cpf" class="white-text templatemo-sort-by">CPF <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'cpf',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cpf') !== false): ?>active <?php endif; ?>">CPF <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=cpf',Request::fullUrl())); ?> <?php if($param == 'cpf'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cpf') !== false): ?>active <?php endif; ?>">CPF <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=pagador" class="white-text templatemo-sort-by">Pagador <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'pagador',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'pagador') !== false): ?>active <?php endif; ?>">Pagador <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=pagador',Request::fullUrl())); ?> <?php if($param == 'pagador'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'pagador') !== false): ?>active <?php endif; ?>">Pagador <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($pacientes as $paciente): ?>
                <tr>
                    <td><?php echo e($paciente->nome); ?></td>
                    <td><?php echo e($paciente->cpf); ?></td>
                    <td><?php echo e(@$paciente->pagador()->nome); ?></td>
                    <td class="small" align="center" alt="Editar Paciente">
                        <a href="<?php echo e(route('pacientes.edit', $paciente->id)); ?>">
                            <?php echo Html::image("images/icons/edit.png", "Editar Paciente"); ?>

                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Paciente">
                        <a onclick="confirm_delete('<?php echo e(route('pacientes.destroy', $paciente->id)); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            <?php echo Html::image("images/icons/delete.png", "Deletar Paciente"); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong><?php echo e($pacientes->firstItem()); ?></strong> ao <strong><?php echo e($pacientes->lastItem()); ?></strong> de um total de <strong><?php echo e($pacientes->total()); ?></strong> registros</p>
    <?php echo $pacientes->render(); ?>

</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
            <h2>Nenhum <?php echo e(substr_replace("Pacientes", "", -1)); ?> encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>