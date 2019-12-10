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
    <h2 class="margin-bottom-10">Médicos</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" <?php if($filtro == "nome"): ?> selected <?php endif; ?>>Nome</option>
                    <option value="cpf" <?php if($filtro == "cpf"): ?> selected <?php endif; ?>>CPF</option>
                    <option value="crm" <?php if($filtro == "crm"): ?> selected <?php endif; ?>>CRM</option>
                    <option value="cidade" <?php if($filtro == "cidade"): ?> selected <?php endif; ?>>Cidade</option>
                    <option value="estado" <?php if($filtro == "estado"): ?> selected <?php endif; ?>>Estado</option>
                    <option value="telefone" <?php if($filtro == "telefone"): ?> selected <?php endif; ?>>Telefone</option>
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
                <div class="pull-right"><a href="<?php echo e(route('empresas.create')); ?>" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo <?php echo e(substr_replace("Médicos", "", -1)); ?></a></div>
            </div>
        </div>
    </div>
</div>


<?php if($empresas->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=nome" class="white-text templatemo-sort-by">Nome <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'nome') !== false): ?>active <?php endif; ?>">Nome Fantasia <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=nome',Request::fullUrl())); ?> <?php if($param == 'nome'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'nome') !== false): ?>active <?php endif; ?>">Nome Fantasia <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
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
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=crm" class="white-text templatemo-sort-by">CRM <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'crm',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'crm') !== false): ?>active <?php endif; ?>">CRM <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=crm',Request::fullUrl())); ?> <?php if($param == 'crm'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'crm') !== false): ?>active <?php endif; ?>">CRM <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=cidade" class="white-text templatemo-sort-by">Cidade <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'cidade',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cidade') !== false): ?>active <?php endif; ?>">Cidade <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=cidade',Request::fullUrl())); ?> <?php if($param == 'cidade'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cidade') !== false): ?>active <?php endif; ?>">Cidade <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=estado" class="white-text templatemo-sort-by">Estado <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'estado',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'estado') !== false): ?>active <?php endif; ?>">Estado <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=estado',Request::fullUrl())); ?> <?php if($param == 'estado'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'estado') !== false): ?>active <?php endif; ?>">Estado <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=telefone" class="white-text templatemo-sort-by">Telefone <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'telefone',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'telefone') !== false): ?>active <?php endif; ?>">Telefone <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=telefone',Request::fullUrl())); ?> <?php if($param == 'telefone'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'telefone') !== false): ?>active <?php endif; ?>">Telefone <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                    <th colspan="3"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($empresas as $empresa): ?>
                <tr>
                    <td><?php echo e($empresa->nome); ?></td>
                    <td><?php echo e($empresa->cpf); ?></td>
                    <td><?php echo e($empresa->crm); ?></td>
                    <td><?php echo e($empresa->cidade); ?></td>
                    <td><?php echo e($empresa->estado); ?></td>
                    <td><?php echo e($empresa->telefone); ?></td>
                    <td class="small" align="center" alt="Visualizar Assinatura Digital">
                        <?php if($empresa->anexo): ?>
                        <a href="<?php echo e("storage/empresas/$empresa->id/$empresa->anexo", $empresa->anexo); ?>" target="_blank">
                            <?php echo Html::image("images/icons/print.png", "Visualizar Assinatura Digital"); ?>

                        </a>
                        <?php endif; ?>
                    </td>
                    <td class="small" align="center" alt="Editar Empresa">
                        <a href="<?php echo e(route('empresas.edit', $empresa->id)); ?>">
                            <?php echo Html::image("images/icons/edit.png", "Editar Empresa"); ?>

                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Empresa">
                        <a onclick="confirm_delete('<?php echo e(route('empresas.destroy', $empresa->id)); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            <?php echo Html::image("images/icons/delete.png", "Deletar Empresa"); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong><?php echo e($empresas->firstItem()); ?></strong> ao <strong><?php echo e($empresas->lastItem()); ?></strong> de um total de <strong><?php echo e($empresas->total()); ?></strong> registros</p>
    <?php echo $empresas->render(); ?>

</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>                
        <div class="media">
            <div class="media-body">
            <h2>Nenhum <?php echo e(substr_replace("Empresas", "", -1)); ?> encontrado!</h2>
            </div>        
        </div>                
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>