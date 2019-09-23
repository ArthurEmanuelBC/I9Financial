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
    <h2 class="margin-bottom-10">Empresas</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" <?php if($filtro == "nome"): ?> selected <?php endif; ?>>Nome Fantasia</option>
                    <option value="cnpj" <?php if($filtro == "cnpj"): ?> selected <?php endif; ?>>CNPJ/CPF</option>
                    <option value="cep" <?php if($filtro == "cep"): ?> selected <?php endif; ?>>CEP</option>
                    <option value="logradouro" <?php if($filtro == "logradouro"): ?> selected <?php endif; ?>>Logradouro</option>
                    <option value="bairro" <?php if($filtro == "bairro"): ?> selected <?php endif; ?>>Bairro</option>
                    <option value="cidade" <?php if($filtro == "cidade"): ?> selected <?php endif; ?>>Cidade</option>
                    <option value="estado" <?php if($filtro == "estado"): ?> selected <?php endif; ?>>Estado</option>
                    <option value="numero" <?php if($filtro == "numero"): ?> selected <?php endif; ?>>Número</option>
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
                <div class="pull-right"><a href="<?php echo e(route('empresas.create')); ?>" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo <?php echo e(substr_replace("Empresas", "", -1)); ?></a></div>
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
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=nome" class="white-text templatemo-sort-by">Nome Fantasia <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'nome') !== false): ?>active <?php endif; ?>">Nome Fantasia <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=nome',Request::fullUrl())); ?> <?php if($param == 'nome'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'nome') !== false): ?>active <?php endif; ?>">Nome Fantasia <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=tipo" class="white-text templatemo-sort-by">Tipo <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'tipo',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'tipo') !== false): ?>active <?php endif; ?>">Tipo <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=tipo',Request::fullUrl())); ?> <?php if($param == 'tipo'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'tipo') !== false): ?>active <?php endif; ?>">Tipo <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=cnpj" class="white-text templatemo-sort-by">CNPJ/CPF <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'cnpj',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cnpj') !== false): ?>active <?php endif; ?>">CNPJ/CPF <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=cnpj',Request::fullUrl())); ?> <?php if($param == 'cnpj'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cnpj') !== false): ?>active <?php endif; ?>">CNPJ/CPF <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=cep" class="white-text templatemo-sort-by">CEP <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'cep',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cep') !== false): ?>active <?php endif; ?>">CEP <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=cep',Request::fullUrl())); ?> <?php if($param == 'cep'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'cep') !== false): ?>active <?php endif; ?>">CEP <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=logradouro" class="white-text templatemo-sort-by">Logradouro <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'logradouro',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'logradouro') !== false): ?>active <?php endif; ?>">Logradouro <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=logradouro',Request::fullUrl())); ?> <?php if($param == 'logradouro'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'logradouro') !== false): ?>active <?php endif; ?>">Logradouro <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                        <?php if(is_null($param)): ?>
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=bairro" class="white-text templatemo-sort-by">Bairro <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'bairro',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'bairro') !== false): ?>active <?php endif; ?>">Bairro <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=bairro',Request::fullUrl())); ?> <?php if($param == 'bairro'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'bairro') !== false): ?>active <?php endif; ?>">Bairro <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
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
<th><a href="<?php echo e(Request::fullUrl()); ?><?php echo e($signal); ?>order=numero" class="white-text templatemo-sort-by">Número <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<?php if(strpos($param,'desc') !== false): ?>
<th><a href="<?php echo e(str_replace(str_replace(' ','%20',$param),'numero',Request::fullUrl())); ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'numero') !== false): ?>active <?php endif; ?>">Número <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php else: ?>
<th><a href="<?php echo e(str_replace('order='.$param,'order=numero',Request::fullUrl())); ?> <?php if($param == 'numero'): ?>desc <?php endif; ?>" class="white-text templatemo-sort-by <?php if(strpos($param,'numero') !== false): ?>active <?php endif; ?>">Número <span class="fa fa-caret-<?php echo e($caret); ?>"></span></a></th>
<?php endif; ?>
<?php endif; ?>

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($empresas as $empresa): ?>
                <tr>
                    <td><?php echo e($empresa->nome); ?></td>
                    <td><?php if($empresa->tipo == 'CPF'): ?> Pessoa Física <?php else: ?> Pessoa Jurídica <?php endif; ?></td>
                    <td><?php echo e($empresa->cnpj); ?></td>
                    <td><?php echo e($empresa->cep); ?></td>
                    <td><?php echo e($empresa->logradouro); ?></td>
                    <td><?php echo e($empresa->bairro); ?></td>
                    <td><?php echo e($empresa->cidade); ?></td>
                    <td><?php echo e($empresa->estado); ?></td>
                    <td><?php echo e($empresa->numero); ?></td>
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