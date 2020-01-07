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
    <h2 class="margin-bottom-10"><?php if($tipo): ?> Despesa <?php else: ?> Receita <?php endif; ?></h2>
    <?php echo Form::open(['route' => 'contas.index', 'method' => 'GET']); ?>

    <?php echo Form::hidden("tipo", $tipo); ?>

    <div class="row form-group">
        <?php if(Auth::user()->permissao == 'Gerencial'): ?>
        <div class="col-md-8 col-sm-12 col-xs-12 data-search">
            <div class="input-group">
                <span class="input-group-addon">Data: </span>
                <?php echo Form::date("data1", @$parametros['data1'], ['class' => 'form-control']); ?>

                <?php echo Form::date("data2", @$parametros['data2'], ['class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Médico: </span>
                <?php echo Form::select("medico_id", $parametros["medicos"], NULL, ['id' => 'medico_id', 'class' =>
                'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Paciente: </span>
                <?php echo Form::select("paciente_id", $parametros["pacientes"], NULL, ['id' => 'paciente_id', 'class' =>
                'form-control']); ?>

            </div>
        </div>
    </div>
    <?php if($tipo == '1'): ?>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Opção: </span>
                <?php echo Form::select("opcao", ['Todos' => 'Todos', 'Livro Caixa' => 'Livro Caixa', 'Imposto de Renda' =>
                'Imposto de
                Renda'], NULL, ['id' => 'opcao', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row form-group">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">Tipo: </span>
                <?php echo Form::select("tipo_conta", $parametros["opcoes"], NULL, ['id' => 'tipo_conta', 'class' =>
                'form-control', 'required' => 'true']); ?>

            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-sm-12 col-xs-12 filtro-search">
            <div class="input-group">
                <?php echo Form::select("filtro", [NULL => "Nenhum", "num_doc" => "Número do Documento", "valor" => "Valor",
                "descricao" => "Descrição"], @$parametros['filtro'], ['class' => 'form-control
                pesquisa-avancada-filtro']); ?>

                <?php echo Form::text("valor", $parametros['valor'], ['class' => 'form-control pesquisa-avancada-valor']); ?>

                <span class="input-group-btn">
                    <a href="javascript:;" class="btn btn-success" data-toggle="modal"
                        data-target="#pesquisa-avancada"><i class="fa fa-plus"></i></a>
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                </span>
            </div>
        </div>

        <!-- Modal da pesquisa avançada -->
        <div class="modal fade" id="pesquisa-avancada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Pesquisa Avançada</h4>
                    </div>
                    <div class="modal-body">
                        <table id="table_pesquisa_avancada" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Coluna</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo Form::select("filtro_avancado[]", [NULL => "Nenhum", "num_doc" => "Número do
                                        Documento", "valor" => "Valor Total", "descricao" => "Descrição"],
                                        @$parametros['filtro'], ['class' => 'form-control filtro_avancado']); ?>

                                    </td>
                                    <td>
                                        <?php echo Form::select("tipo_avancado[]", [NULL => "Nenhum", "=" => "=", "<"=> "
                                            <", ">"=> ">", "like" => "Contém", "not like" => "Não Contém", "!=" =>
                                                "Diferente de", "in" => "Possui", "not in" => "Não Possui"], "=",
                                                ['class' => 'form-control tipo_avancado']); ?>

                                    </td>
                                    <td>
                                        <textarea class="form-control valor_avancado" name="valor_avancado[]"
                                            resizable="true" rows="1"><?php echo e($parametros["valor"]); ?></textarea>
                                    </td>
                                    <td align="center" class="table_actions">
                                        <a class="add_linha" href="javascript:;"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md col-sm-12 col-xs-12 filtro-search">
            <div class="pull-right">
                <div class="pull-right"><a href="<?php echo e(route('contas.create', ['tipo' => $tipo])); ?>" type="button"
                        class="btn btn-success"><i class="fa fa-plus"></i> Nova <?php if($tipo == '0'): ?> Receita <?php else: ?> Despesa
                        <?php endif; ?></a></div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>

</div>

<?php if(Auth::user()->permissao == 'Gerencial'): ?>
<div class="row form-group" style="margin-left:-5px">
    <div class="col-md-2 col-sm-6 col-xs-6">
        <div id="group-dropdown" class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Colunas <span class="caret"></span></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <ul style="list-style: none;padding: 0 10px;">
                    <li><input type="checkbox" id="check_lancamento" class="dropdown-check" data-column="lancamento"
                            checked> <label for="check_lancamento" class="font-weight-400"><span></span>Data de
                            Lançamento</label></li>
                    <li><input type="checkbox" id="check_paciente_id" class="dropdown-check" data-column="paciente_id"
                            checked> <label for="check_paciente_id" class="font-weight-400"><span></span><?php if($tipo): ?>
                            Fornecedor <?php else: ?> Paciente <?php endif; ?></label></li>
                    <li><input type="checkbox" id="check_num_doc" class="dropdown-check" data-column="num_doc" checked>
                        <label for="check_num_doc" class="font-weight-400"><span></span>Número do Documento</label></li>
                    <?php if($tipo == '1'): ?>
                    <li><input type="checkbox" id="check_opcao" class="dropdown-check" data-column="opcao" checked>
                        <label for="check_opcao" class="font-weight-400"><span></span>Opção</label></li>
                    <?php endif; ?>
                    <li><input type="checkbox" id="check_tipo" class="dropdown-check" data-column="tipo" checked>
                        <label for="check_tipo" class="font-weight-400"><span></span>Tipo</label></li>
                    <li><input type="checkbox" id="check_valor" class="dropdown-check" data-column="valor" checked>
                        <label for="check_valor" class="font-weight-400"><span></span>Valor</label></li>
                    <li><input type="checkbox" id="check_descricao" class="dropdown-check" data-column="descricao"
                            checked> <label for="check_descricao" class="font-weight-400"><span></span>Descrição</label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-6 form-group">
        <?php echo Form::open(['route' => 'contas.index', 'method' => 'GET', 'target' => '_blank', 'id' =>
        'form-print']); ?>

        <?php echo Form::hidden("tipo", $tipo); ?>

        <?php echo Form::hidden("pdf", true); ?>

        <?php echo Form::hidden("paciente_id", @$parametros['paciente_id']); ?>

        <?php echo Form::hidden("medico_id", @$parametros['medico_id']); ?>

        <?php echo Form::hidden("opcao", @$parametros['opcao']); ?>

        <?php echo Form::hidden("tipo_conta", @$parametros['tipo_conta']); ?>

        <?php echo Form::hidden("data1", @$parametros['data1']); ?>

        <?php echo Form::hidden("data2", @$parametros['data2']); ?>

        <?php echo Form::hidden("filtro", @$parametros['filtro']); ?>

        <?php echo Form::hidden("valor", @$parametros['valor']); ?>

        <?php if(!is_null($parametros['filtro_avancado'])): ?>
        <?php foreach($parametros['filtro_avancado'] as $filtro): ?>
        <input type="hidden" name="filtro_avancado[]" value="<?php echo e($filtro); ?>">
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!is_null($parametros['tipo_avancado'])): ?>
        <?php foreach($parametros['tipo_avancado'] as $tipo_avancado): ?>
        <input type="hidden" name="tipo_avancado[]" value="<?php echo e($tipo_avancado); ?>">
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!is_null($parametros['valor_avancado'])): ?>
        <?php foreach($parametros['valor_avancado'] as $valor): ?>
        <input type="hidden" name="valor_avancado[]" value="<?php echo e($valor); ?>">
        <?php endforeach; ?>
        <?php endif; ?>
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-print"></i> Imprimir</button>
        <?php echo Form::close(); ?>

    </div>
</div>

<?php if($contas->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th class="lancamento">Data de Lançamento</th>
                    <th class="paciente_id"><?php if($tipo): ?> Fornecedor <?php else: ?> Paciente <?php endif; ?></th>
                    <th class="num_doc">Número do Documento</th>
                    <?php if($tipo == '1'): ?>
                    <th class="opcao">Opção</th>
                    <?php endif; ?>
                    <th class="tipo">Tipo</th>
                    <th class="valor">Valor</th>
                    <th class="descricao">Descrição</th>
                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($contas as $contum): ?>
                <tr>
                    <td class="lancamento"><?php echo e(@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')); ?>

                    </td>
                    <td class="paciente_id"><?php echo e(@$contum->paciente()->nome); ?></td>
                    <td class="num_doc"><?php echo e($contum->num_doc); ?></td>
                    <?php if($tipo == '1'): ?>
                    <td class="opcao"><?php echo e($contum->opcao); ?></td>
                    <?php endif; ?>
                    <td class="tipo"><?php echo e($contum->tipo_conta); ?></td>
                    <td class="valor"><?php echo e(number_format($contum->valor,2,',','.')); ?></td>
                    <td class="descricao"><?php echo e($contum->descricao); ?></td>
                    <td class="table_actions" align="center" title="Editar Contum">
                        <a href="<?php echo e(route('contas.edit', ['id' => $contum->id, 'tipo' => $tipo])); ?>"><i
                                class="fa fa-edit"></i></a>
                    </td>
                    <td class="table_actions" align="center" title="Deletar Contum">
                        <a onclick="confirm_delete('<?php echo e(route('contas.destroy', ['id' => $contum->id, 'tipo' => $tipo])); ?>')"
                            href="javascript:;" data-toggle="modal" data-target="#confirm_delete"><i
                                class="fa fa-remove"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong><?php echo e($contas->firstItem()); ?></strong> ao
        <strong><?php echo e($contas->lastItem()); ?></strong> de um total de <strong><?php echo e($contas->total()); ?></strong> registros</p>
    <?php echo $contas->render(); ?>

</div>
<?php else: ?>
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhuma <?php if($tipo == '0'): ?> receita <?php else: ?> despesa <?php endif; ?> encontrada!</h2>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<style type="text/css">
    .data-search select,
    .data-search input {
        width: 33.3% !important;
    }

    .filtro-search select,
    .filtro-search input {
        width: 50% !important;
    }

    .linha_filho {
        background: #F0F8FF
    }
</style>

<script type="text/javascript">
    // Adiciona uma linha na tabela de pesquisa avançada
    $(document).on('click','a.add_linha',function(){
        $length = $("#table_pesquisa_avancada tbody tr").length;
        $row = $("#table_pesquisa_avancada tbody tr:last").clone();
        $("#table_pesquisa_avancada tbody tr td.table_actions").html("");
        $("#table_pesquisa_avancada tr:last").after($row);
        $("#table_pesquisa_avancada tbody tr:last").find("textarea").val("");
        $("#table_pesquisa_avancada tbody tr:last").find("select.filtro_avancado").val(null);
        $("#table_pesquisa_avancada tbody tr:last").find("select.tipo_avancado").val("=");
    });

    // Omite a coluna selecionada
    $('.dropdown-check').change(function(){
        if($("."+$(this).attr('data-column')).css('display') == 'none'){
            $("."+$(this).attr('data-column')).removeClass("hide");
            $("#form-print #print-oculta-"+$(this).attr('data-column')).remove();
        } else {
            $("."+$(this).attr('data-column')).addClass("hide");
            $("#form-print").append("<input id='print-oculta-"+$(this).attr('data-column')+"' type='hidden' name='ocultas[]' value='"+$(this).attr('data-column')+"'>");
        }
        $("#group-dropdown").addClass("open");
    });

    // Altera os campos de tipo e opções
    <?php if($tipo == '1'): ?>
    $("input[name=opcao]").change(function(){
    $("#tipo_conta").val("");

    if($(this).val() == "Livro Caixa")
        opcoes = ['Emissão de Recibo','Aluguel','Salário','Convênio','Pró-labore','Outros'];
    else
        opcoes = ['INSS','IRPF','Despesas Dedutíveis','Saúde'];

    $("#tipo_conta > option").remove();

    for (const key in opcoes)
        $("#tipo_conta").append(`<option value='${opcoes[key]}'>${opcoes[key]}</option>`);
    });
    <?php endif; ?>
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>