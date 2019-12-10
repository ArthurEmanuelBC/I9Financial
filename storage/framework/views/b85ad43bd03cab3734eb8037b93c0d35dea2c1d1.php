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
    <h2 class="margin-bottom-10">Usuários</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" <?php if($filtro == "users.nome"): ?> selected <?php endif; ?>>Nome</option>
                        <option value="email" <?php if($filtro == "email"): ?> selected <?php endif; ?>>Email</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="<?php echo e($valor); ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4 col-sm-12 form-group">
            <div class="pull-right search-new"><a href="<?php echo e(route('users.create')); ?>" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo <?php echo e(substr_replace("Usuários", "", -1)); ?></a></div>
        </div>
    </div>
</div>

<?php if($users->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <?php if(is_null($param)): ?>
                    <th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=id" class="white-text templatemo-sort-by">Id <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <?php if(strpos($param,'desc') !== false): ?>
                    <th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'id',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'id') !== false): ?>active <?php endif; ?>">Id <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <th><a href="<?php echo e(str_replace('order='.$param,'order=id',Request::fullUrl())); ?> <?php if($param == 'id'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'id') !== false): ?>active <?php endif; ?>">Id <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php endif; ?>
                    <?php endif; ?>
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
                    <th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=email" class="white-text templatemo-sort-by">Email <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <?php if(strpos($param,'desc') !== false): ?>
                    <th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'email',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'email') !== false): ?>active <?php endif; ?>">Email <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php else: ?>
                    <th><a href="<?php echo e(str_replace('order='.$param,'order=email',Request::fullUrl())); ?> <?php if($param == 'email'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'email') !== false): ?>active <?php endif; ?>">Email <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
                    <?php endif; ?>
                    <?php endif; ?>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo e($user->id); ?></td>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td class="small" align="center" alt="Editar Usuário">
                        <a href="<?php echo e(route('users.edit', $user->id)); ?>">
                            <?php echo Html::image("/images/icons/edit.png", "Editar Usuário"); ?>

                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Usuário">
                        <a onclick="confirm_delete('<?php echo e(route('users.destroy', $user->id)); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            <?php echo Html::image('/images/icons/delete.png', 'Deletar Usuário'); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>    
    </div>                          
</div>
<div class="pagination-wrap">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <p class="text_pagination">Exibindo do <strong><?php echo e($users->firstItem()); ?></strong> ao <strong><?php echo e($users->lastItem()); ?></strong> de um total de <strong><?php echo e($users->total()); ?></strong> registros</p>
        </div>
        <div class="col-md-4 col-sm-12">
            <?php echo $users->render(); ?>

        </div>
    </div>
</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
                <h2>Nenhum Usuário encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>