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
    <h2 class="margin-bottom-10">Fornecedores</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="name" <?php if($filtro=="name" ): ?> selected <?php endif; ?>>Nome</option>
                        <option value="cnpj" <?php if($filtro=="cnpj" ): ?> selected <?php endif; ?>>Cnpj</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="<?php echo e($valor); ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i>
                            Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
                <div class="pull-right"><a href="<?php echo e(route('fornecedors.create')); ?>" type="button"
                        class="btn btn-success"><i class="fa fa-plus"></i> Novo
                        <?php echo e(substr_replace("Fornecedors", "", -1)); ?></a></div>
            </div>
        </div>
    </div>
</div>


<?php if($fornecedors->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <?php if(is_null($param)): ?>
                    <th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=name" class="white-text templatemo-sort-by">Nome
                            <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <?php if(strpos($param,'desc') !== false): ?>
                    <th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'name',Request::fullUrl())); ?>"
                            class="white-text templatemo-sort-by <?php if(strpos($param,'name') !== false): ?>active <?php endif; ?>">Nome
                            <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <th><a href="<?php echo e(str_replace('order='.$param,'order=name',Request::fullUrl())); ?> <?php if($param == 'name'): ?>desc <?php endif; ?>"
                            class="white-text templatemo-sort-by <?php if(strpos($param,'name') !== false): ?>active <?php endif; ?>">Nome
                            <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(is_null($param)): ?>
                    <th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=cnpj" class="white-text templatemo-sort-by">Cnpj
                            <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <?php if(strpos($param,'desc') !== false): ?>
                    <th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'cnpj',Request::fullUrl())); ?>"
                            class="white-text templatemo-sort-by <?php if(strpos($param,'cnpj') !== false): ?>active <?php endif; ?>">Cnpj
                            <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <th><a href="<?php echo e(str_replace('order='.$param,'order=cnpj',Request::fullUrl())); ?> <?php if($param == 'cnpj'): ?>desc <?php endif; ?>"
                            class="white-text templatemo-sort-by <?php if(strpos($param,'cnpj') !== false): ?>active <?php endif; ?>">Cnpj
                            <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php endif; ?>
                    <?php endif; ?>

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($fornecedors as $fornecedor): ?>
                <tr>
                    <td><?php echo e($fornecedor->name); ?></td>
                    <td><?php echo e($fornecedor->cnpj); ?></td>
                    <td class="small" align="center" alt="Editar Fornecedor">
                        <a href="<?php echo e(route('fornecedors.edit', $fornecedor->id)); ?>">
                            <?php echo Html::image("images/icons/edit.png", "Editar Fornecedor"); ?>

                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Fornecedor">
                        <a onclick="confirm_delete('<?php echo e(route('fornecedors.destroy', $fornecedor->id)); ?>')"
                            href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            <?php echo Html::image("images/icons/delete.png", "Deletar Fornecedor"); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong><?php echo e($fornecedors->firstItem()); ?></strong> ao
        <strong><?php echo e($fornecedors->lastItem()); ?></strong> de um total de <strong><?php echo e($fornecedors->total()); ?></strong>
        registros</p>
    <?php echo $fornecedors->render(); ?>

</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhum <?php echo e(substr_replace("Fornecedors", "", -1)); ?> encontrado!</h2>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>