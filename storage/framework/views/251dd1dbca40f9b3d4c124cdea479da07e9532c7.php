<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>                
    <div class="media">
        <div class="media-body">
            <ul>
                <?php foreach($errors->all() as $error): ?>
                <li><h2><?php echo e($error); ?></h2></li>
                <?php endforeach; ?>
            </ul>
        </div>        
    </div>           
</div>     
<?php endif; ?>

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        <?php if(Request::is('*contas/create')): ?>
        Cadastrar <?php echo e(substr_replace("Contas", "", -1)); ?> <?php if($tipo == '0'): ?> a Pagar <?php else: ?> a Receber <?php endif; ?>
        <?php else: ?>
        Editar <?php echo e(substr_replace("Contas", "", -1)); ?> <?php if($tipo == '0'): ?> a Pagar <?php else: ?> a Receber <?php endif; ?> #<?php echo e($contum->id); ?>

        <?php endif; ?>
    </h2>
    
    <?php echo Form::open(['route' => [$url, $contum->id], 'method' => $method, 'class' => 'form-horizontal']); ?>

    <?php echo Form::hidden('tipo', $tipo); ?>

    <div id="formulario_0" class="formulario">
        <div class="row form-group row-multiple">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('date', 'Data de Lançamento <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::date('date[0]', $contum->date, ['class' => 'form-control date','required' => 'true','readonly' => true]); ?>

            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('tipo_pagamento', 'Tipo de Pagamento <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($tipo == "0"): ?>
                <?php echo Form::select("tipo_pagamento[0]", ['Crédito' => 'Crédito', 'Débito' => 'Débito', 'Boleto' => 'Boleto', 'Cheque' => 'Cheque', 'Nota Fiscal' => 'Nota Fiscal', 'Recibo' => 'Recibo', 'Espécie' => 'Espécie', 'Transferência' => 'Transferência'], $contum->tipo_pagamento, ['id' => 'tipo_pagamento_0', 'class' => 'form-control select2-search tipo_pagamento', 'required' => 'true']); ?>

                <?php else: ?>
                <?php echo Form::select("tipo_pagamento[0]", ['Crédito' => 'Crédito', 'Débito' => 'Débito', 'Boleto' => 'Boleto', 'Cheque à Vista' => 'Cheque à Vista', 'Cheque Pré-Datado' => 'Cheque Pré-Datado', 'Depósito' => 'Depósito', 'Espécie' => 'Espécie', 'Transferência' => 'Transferência'], $contum->tipo_pagamento, ['id' => 'tipo_pagamento_0', 'class' => 'form-control select2-search tipo_pagamento', 'required' => 'true']); ?>

                <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('qtd_parcelas', 'Qtd Parcelas <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::number('qtd_parcelas[0]', $contum->qtd_parcelas, ['class' => 'form-control qtd_parcelas','onKeyPress' => 'validar_numero(event)', 'required' => 'true']); ?>

            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('cartao', 'Cartão <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::select("cartao[0]", ["Visa" => "Visa", "Mastercard" => "Mastercard", "American Express" => "American Express", "Elo" => "Elo", "Discover Network" => "Discover Network"], $contum->cartao, ['id' => 'cartao', 'class' => 'form-control select2-search cartao', 'required' => 'true']); ?>

            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php if($tipo): ?>
                <?php echo Html::decode(Form::label('paciente_id', 'Paciente <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::select("paciente_id", $pacientes, $contum->paciente_id, ['id' => 'paciente', 'class' => 'form-control select2-search paciente_id', 'required' => 'true']); ?>

                <?php else: ?>
                <?php echo Form::label('fornecedor', 'Fornecedor', ['class' => 'control-label']); ?>

                <?php echo Form::text('fornecedor', $contum->fornecedor, ['class' => 'form-control fornecedor',]); ?>

                <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <?php echo Form::label('num_doc', 'Núm Documento', ['class' => 'control-label']); ?>

                <?php echo Form::text('num_doc', $contum->num_doc, ['class' => 'form-control num_doc',]); ?>

            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('valor', 'Valor Total <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::text('valor', NULL, ['class' => 'form-control valor','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php else: ?> <?php echo Form::text('valor', number_format($contum->valor,2,',','.'), ['class' => 'form-control', 'onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('desconto', 'Desconto <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::text('desconto', NULL, ['class' => 'form-control desconto','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php else: ?> <?php echo Form::text('desconto', number_format($contum->desconto,2,',','.'), ['class' => 'form-control', 'onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('pago', 'Pago <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::text('pago[0]', NULL, ['class' => 'form-control pago','onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php else: ?> <?php echo Form::text('pago[0]', number_format($contum->pago,2,',','.'), ['class' => 'form-control', 'onKeyDown' => 'Formata(this,20,event,2)', 'required' => 'true']); ?> <?php endif; ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php echo Form::label('descricao', 'Descrição', ['class' => 'control-label']); ?>

                <?php echo Form::textarea('descricao', $contum->descricao, ['class' => 'form-control descricao','rows' => '3']); ?>

            </div>
        </div>
        
        <?php if(in_array($contum->tipo_pagamento, ["Boleto","Cheque Pré-Datado"])): ?>
        <div class="row linha_parcela">
            <?php foreach($contum->parcelas()->get() as $index => $parcela): ?>
            <div class="col-md-3">
                <?php echo Html::decode(Form::label('vencimento', ($index+1)."º Vencimento <span class='obrigatorio'>*</span>", ['class' => 'control-label'])); ?>

                <?php echo Form::text("vencimento[0][]", @date_format(date_create_from_format('Y-m-d', $parcela->vencimento), 'd/m/Y'), ['class' => 'form-control datepicker', 'required' => 'true']); ?>

            </div>
            <div class="col-md-3">
                <?php echo Html::decode(Form::label('parcela_valor', ($index+1)."º Valor <span class='obrigatorio'>*</span>", ['class' => 'control-label'])); ?>

                <?php echo Form::text("parcela_valor[0][]", number_format($parcela->valor,2,',','.'), ['class' => 'form-control parcela_valor','onKeyDown' => 'Formata(this,20,event,2)','onKeyPress' => 'validar_numero(event)', 'required' => 'true']); ?>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <?php foreach($contum->contas()->get() as $key => $conta): ?>
    <?php echo Form::hidden("ids[".($key+1)."]", $conta->id); ?>

    <div id="formulario_<?php echo e($key+1); ?>" class="formulario">
        <hr id="hr_<?php echo e(($key+1)); ?>" />
        <div id="formulario_<?php echo e(($key+1)); ?>" class="formulario formulario-multiple">
            <a href="javascript:;" class="fechar-formulario" data-id-formulario="<?php echo e(($key+1)); ?>"><i class="fa fa-remove"></i></a>
        </div>
        <div class="row form-group row-multiple">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('data', 'Data de Lançamento <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::date("date[".($key+1)."]", NULL, ['class' => 'form-control date','required' => 'true','readonly' => true]); ?> <?php else: ?> <?php echo Form::date("date[".($key+1)."]", $conta->date, ['class' => 'form-control date','required' => 'true','readonly' => true]); ?> <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('tipo_pagamento', 'Tipo de Pagamento <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($tipo == "0"): ?>
                <?php echo Form::select("tipo_pagamento[".($key+1)."]", ['Crédito' => 'Crédito', 'Débito' => 'Débito', 'Boleto' => 'Boleto', 'Cheque' => 'Cheque', 'Nota Fiscal' => 'Nota Fiscal', 'Recibo' => 'Recibo', 'Espécie' => 'Espécie', 'Transferência' => 'Transferência'], $conta->tipo_pagamento, ['id' => 'tipo_pagamento_0', 'class' => 'form-control select2-search tipo_pagamento', 'required' => 'true']); ?>

                <?php else: ?>
                <?php echo Form::select("tipo_pagamento[".($key+1)."]", ['Crédito' => 'Crédito', 'Débito' => 'Débito', 'Boleto' => 'Boleto', 'Cheque à Vista' => 'Cheque à Vista', 'Cheque Pré-Datado' => 'Cheque Pré-Datado', 'Depósito' => 'Depósito', 'Espécie' => 'Espécie', 'Transferência' => 'Transferência'], $conta->tipo_pagamento, ['id' => 'tipo_pagamento_0', 'class' => 'form-control select2-search tipo_pagamento', 'required' => 'true']); ?>

                <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 <?php if(!in_array($conta->tipo_pagamento, ['Crédito','Boleto','Cheque Pré-Datado','Cheque'])): ?> hide <?php endif; ?>">
                <?php echo Html::decode(Form::label('qtd_parcelas', 'Qtd de Parcelas <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::text("qtd_parcelas[".($key+1)."]", $conta->qtd_parcelas, ['class' => 'form-control qtd_parcelas','onKeyPress' => 'validar_numero(event)', 'required' => 'true', 'maxlength' => '11']); ?>

            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <?php echo Html::decode(Form::label('cartao', 'Cartão <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php if($method == 'post'): ?> <?php echo Form::select("cartao[".($key+1)."]", ["Visa" => "Visa", "Mastercard" => "Mastercard", "American Express" => "American Express", "Elo" => "Elo", "Discover Network" => "Discover Network"], NULL, ['id' => 'cartao', 'class' => 'form-control select2-search cartao', 'required' => 'true']); ?> <?php else: ?> <?php echo Form::select("cartao[".($key+1)."]", ["Visa" => "Visa", "Mastercard" => "Mastercard", "American Express" => "American Express", "Elo" => "Elo", "Discover Network" => "Discover Network"], $conta->cartao, ['id' => 'cartao', 'class' => 'form-control select2-search cartao', 'required' => 'true']); ?> <?php endif; ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2 col-sm-6 col-xs-6 margin-bottom-15'>
                <?php echo Html::decode(Form::label('pago', 'Pago <span class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

                <?php echo Form::text("pago[".($key+1)."]", number_format($conta->pago,2,',','.'), ['class' => 'form-control pago','onKeyDown' => 'Formata(this,20,event,2)','onKeyPress' => 'validar_numero(event)', 'required' => 'true']); ?>

            </div>
        </div>
        <?php if(in_array($conta->tipo_pagamento, ["Boleto","Cheque Pré-Datado"])): ?>
        <div class="row linha_parcela">
            <?php foreach($conta->parcelas()->get() as $index => $parcela): ?>
            <div class="col-md-3">
                <?php echo Html::decode(Form::label('vencimento', ($index+1)."º Vencimento <span class='obrigatorio'>*</span>", ['class' => 'control-label'])); ?>

                <?php echo Form::text("vencimento[".($key+1)."][]", @date_format(date_create_from_format('Y-m-d', $parcela->vencimento), 'd/m/Y'), ['class' => 'form-control datepicker', 'required' => 'true']); ?>

            </div>
            <div class="col-md-3">
                <?php echo Html::decode(Form::label('parcela_valor', ($index+1)."º Valor <span class='obrigatorio'>*</span>", ['class' => 'control-label'])); ?>

                <?php echo Form::text("parcela_valor[".($key+1)."][]", number_format($parcela->valor,2,',','.'), ['class' => 'form-control parcela_valor','onKeyDown' => 'Formata(this,20,event,2)','onKeyPress' => 'validar_numero(event)', 'required' => 'true']); ?>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="<?php echo e(route('contas.index', ['tipo' => $tipo])); ?>"><i class="fa fa-arrow-left"></i> Voltar</a>
    </div>
    <?php echo Form::close(); ?>

    
</div>

<?php if($contum->parcelas()->count()): ?>
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    <th>Data de Lançamento</th>
                    <th>Data de Vencimento</th>
                    <th>Data de Conferência</th>
                    <th>Data de Pagamento</th>
                    <th>Valor</th>
                    <th>Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($contum->parcelas()->get() as $parcela): ?>
                <tr>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->lancamento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->vencimento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->conferencia), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->pagamento), 'd/m/Y')); ?></td>
                    <td><?php echo e(number_format($parcela->valor,2,',','.')); ?></td>
                    <td class="small" align="center" title="Pago">
                        <?php if($parcela->pago): ?>
                        <a onclick="confirm_pagar('<?php echo e(route('parcelas.pagar', ['ids' => [$parcela->id], 'tipo' => $tipo, 'desfazer' => true])); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_pagar"><i class="fa fa-check-square"></i></a>
                        <?php else: ?>
                        <a onclick="confirm_pagar('<?php echo e(route('parcelas.pagar', ['ids' => [$parcela->id], 'tipo' => $tipo])); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_pagar"><i class="fa fa-square-o"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php foreach($contum->contas()->get() as $conta): ?>
                <?php foreach($conta->parcelas()->get() as $parcela): ?>
                <tr>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->lancamento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->vencimento), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->conferencia), 'd/m/Y')); ?></td>
                    <td><?php echo e(@date_format(date_create_from_format('Y-m-d', $parcela->pagamento), 'd/m/Y')); ?></td>
                    <td><?php echo e(number_format($parcela->valor,2,',','.')); ?></td>
                    <td class="small" align="center" title="Pago">
                        <?php if($parcela->pago): ?>
                        <a onclick="confirm_pagar('<?php echo e(route('parcelas.pagar', ['ids' => [$parcela->id], 'tipo' => $tipo, 'desfazer' => true])); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_pagar"><i class="fa fa-check-square"></i></a>
                        <?php else: ?>
                        <a onclick="confirm_pagar('<?php echo e(route('parcelas.pagar', ['ids' => [$parcela->id], 'tipo' => $tipo])); ?>')" href="javascript:;" data-toggle="modal" data-target="#confirm_pagar"><i class="fa fa-square-o"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
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

<style type="text/css">
    a.fechar-formulario {
        font-size: 18px;
        color: #c9302c;
    }
</style>

<script type="text/javascript">
    // Oculta/exibe o campo de desconto
    $(document).on('change','select.tipo_pagamento',function(){
        $formulario = $(this).parent().parent().parent();
        switch ($(this).val()) {
            case "Crédito":
            $formulario.find("select.cartao").parent().removeClass('hide');
            $formulario.find("input.qtd_parcelas").prop("readonly",false);
            break;
            
            case "Boleto":
            case "Cheque Pré-Datado":
            $formulario.find("select.cartao").parent().addClass('hide');
            $formulario.find("input.qtd_parcelas").prop("readonly",false);
            break;
            
            default:
            $formulario.find("select.cartao").parent().addClass('hide');
            $formulario.find("input.qtd_parcelas").prop("readonly",true);
            break;
        }
        // $formulario.find("input.qtd_parcelas").val(1);
    });
    $("select.tipo_pagamento").change();
    
    // Calcula o valor pago
    $(document).on('keyup','input.valor,input.desconto',function(){
        $formulario = $(this).parent().parent().parent();
        $total = parseFloat($formulario.find("input.valor").val().replace(/\./g, "").replace(",", "."));
        if(isNaN($total)) $total = 0;
        $desconto = parseFloat($formulario.find("input.desconto").val().replace(/\./g, "").replace(",", "."));
        if(isNaN($desconto)) $desconto = 0;
        $formulario.find("input.pago").val(number_format($total-$desconto,2,',','.'));
    });
    
    // Valida os totais do formulário
    function valida_form(){
        $confirmar = true;
        if(confirm("Deseja realmente receber este pagamento?")){
            // Valida total das parcelas
            $valor = parseFloat($("input.valor").val().replace(/\./g, "").replace(",", "."));
            $desconto = parseFloat($("input.desconto").val().replace(/\./g, "").replace(",", "."));
            if(isNaN($valor))
            $valor = 0;
            if(isNaN($desconto))
            $desconto = 0;
            $total = $valor - $desconto;
            $soma = 0;
            $.each($("select.tipo_pagamento"), function( index, value ) {
                if(["Boleto","Cheque Pré-Datado"].includes($(value).val())){
                    $soma_boleto = 0;
                    $pago = parseFloat($(value).parent().parent().parent().find("input.pago").val().replace(/\./g, "").replace(",", "."));
                    $soma += $pago;
                    $.each($("input.parcela_valor"), function( index2, value2 ) {
                        $soma_boleto += parseFloat($(value2).val().replace(/\./g, "").replace(",", "."));
                    });
                    if($pago != $soma_boleto){
                        modal_alert("A soma das parcelas difere do valor pago!");
                        $confirmar = false;
                    }
                } else {
                    $soma += parseFloat($(value).parent().parent().parent().find("input.pago").val().replace(/\./g, "").replace(",", "."));
                }
            });
            
            if($total != $soma){
                modal_alert("A soma dos pagamentos difere do valor total!");
                $confirmar = false;
            }
            
            if($confirmar) return true;
            else return false;
        } else {
            return false;
        }
    }
    
    // Copia o formulário caso precise de uma conta filha
    $(document).on('blur','input.pago',function(){
        $formulario = $(this).parent().parent().parent();
        $total = parseFloat($("input.valor").val().replace(/\./g, "").replace(",", "."));
        if(isNaN($total)) $total = 0;
        $desconto = parseFloat($("input.desconto").val().replace(/\./g, "").replace(",", "."));
        if(isNaN($desconto)) $desconto = 0;
        $pago = 0;
        $("div.formulario input.pago").each(function( index ) {
            $pago += parseFloat($(this).val().replace(/\./g, "").replace(",", "."));
        });
        $row = $formulario.find("div.row-multiple").clone();
        $row.find("div.paciente").remove();
        if($pago < ($total - $desconto)){
            $length = $(".formulario").length;
            $("div.formulario:last").after("<hr id='hr_"+$length+"' /><div id='formulario_"+$length+"' class='formulario formulario-multiple'><a href='javascript:;' class='fechar-formulario' data-id-formulario='"+$length+"'><i class='fa fa-remove'></i></a></div>");
            $("div.formulario:last").append($row);
            $("div.formulario:last").append("<div class='row'><div class='col-md-2 margin-bottom-15'><label for='pago' class='control-label pago'>Valor Pago <span class='obrigatorio'>*</span></label><input type='text' class='form-control pago' id='pago' name='pago["+$length+"]' onkeydown='Formata(this,20,event,2)' value='"+number_format($total - $desconto - $pago,2,',','.')+"' required></div></div><h1 class='pull-left transferencia hide'>Importar Comprovante</h1><div class='row transferencia hide'><div class='col-md-12 margin-bottom-15'><div class='row'><div class='col-md-6 margin-bottom-15'><label for='imagem'>Comprovante:</label><input type='hidden' name='MAX_FILE_SIZE' value='5000000'><input type='file' class='filestyle' name='imagem["+$length+"]' data-buttonText='Selecionar Imagem' data-iconName='fa fa-upload'><strong>Importe apenas imagens no formato jpg!</strong></div></div></div></div></div>");
            $("div.formulario:last").find("input.qtd_parcelas").val(1);
            $row.find("select.tipo_pagamento").val($formulario.find("select.tipo_pagamento").val());
            $("div.formulario:last").find("input,select").each(function() {
                $(this).prop("name", $(this).prop("name").substr(0,($(this).prop("name").length - 3)) + "["+$length+"]");
            });
            // Select2
            $("div.formulario:last").find("span.select2").remove();
            $.each(['tipo_pagamento','cartao'], function( index, value ) {
                $("div.formulario:last").find("select."+value).prop("id",value+"_"+$length).attr("data-select2-id",value+"_"+$length);
                $("#"+value+"_"+$length).select2();
                $("#"+value+"_"+$length).select2('destroy').val("").select2();
            });
            $("div.formulario:last").load();
        }
    });
    
    // Fechar formulário
    $(document).on('click','a.fechar-formulario',function(){
        $("#formulario_"+$(this).attr("data-id-formulario")+", #hr_"+$(this).attr("data-id-formulario")).remove();
    });
    
    // Adiciona o campo de vencimento caso o tipo de pagamento seja boleto
    $(document).on('change','input.qtd_parcelas,select.tipo_pagamento',function(){
        $formulario = $(this).parent().parent().parent();
        $form_index = $formulario.attr('id').split('_')[1];
        if(["Boleto","Cheque Pré-Datado"].includes($formulario.find('select.tipo_pagamento').val())){
            $formulario.find(".linha_parcela").remove();
            $formulario.append("<div class='row linha_parcela'></div>");
            $p = parseInt($formulario.find("input.qtd_parcelas").val());
            if($p == "")
            $p = 0;
            for ($i = 1; $i <= $p; $i++)
            $formulario.find(".linha_parcela").append("<div class='col-md-3'><label for='vencimento_"+$i+"' class='control-label'>"+$i+"º Vencimento <span class='obrigatorio'>*</span></label><input type='date' name='vencimento["+$formulario.attr('id').slice(-1)+"][]' class='form-control' required></div><div class='col-md-3'><label for='valor_"+$i+"' class='control-label'>"+$i+"º Valor <span class='obrigatorio'>*</span></label><input type='text' name='parcela_valor["+$formulario.attr('id').slice(-1)+"][]' class='form-control parcela_valor' onKeyDown='Formata(this,20,event,2)' onKeyPress='validar_numero(event)' required></div>");
        } else {
            $formulario.find(".linha_parcela").html("");
        }
    });
    
    // Popula o form de confirmação de pagamento da parcela
    function confirm_pagar(url) {
        $('#form-pagar').attr('action', url);
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>