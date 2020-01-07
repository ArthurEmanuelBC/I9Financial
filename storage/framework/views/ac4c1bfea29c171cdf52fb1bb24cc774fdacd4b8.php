<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="templatemo-content-widget yellow-bg">
  <i class="fa fa-times"></i>
  <div class="media">
    <div class="media-body">
      <ul>
        <?php foreach($errors->all() as $error): ?>
        <li>
          <h2><?php echo e($error); ?></h2>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="templatemo-content-widget white-bg">
  <h2 class="margin-bottom-10">
    <?php if(Request::is('users/create')): ?>
    Novo <?php echo e(substr_replace("Usuários", "", -1)); ?>

    <?php else: ?>
    Editar <?php echo e(substr_replace("Usuários", "", -1)); ?> #<?php echo e($user->id); ?>

    <?php endif; ?>
  </h2>
  <?php echo Form::open(['route' => [$url, $user->id], 'method' => $method, 'enctype' => 'multipart/form-data']); ?>

  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>Dados</h2>
    </div>
    <div class="panel-body">
      <input type="hidden" name="config" value="true">
      <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
          <?php echo Html::decode(Form::label('name', 'Nome <span class="obrigatorio">*</span>', ['class' =>
          'control-label'])); ?>

          <?php echo Form::text('name', $user->name, ['required' => 'true', 'class' => 'form-control']); ?>

        </div>
        <div class="col-md-4 col-sm-12 form-group">
          <?php echo Html::decode(Form::label('email', 'Email <span class="obrigatorio">*</span>', ['class' =>
          'control-label'])); ?>

          <?php echo Form::email('email', $user->email, ['required' => 'true', 'class' => 'form-control']); ?>

        </div>
      </div>
      <div class="row">
        <?php echo Html::decode(Form::label('permissao', 'Permiss?o <span class="obrigatorio">*</span>', ['class' =>
        'control-label'])); ?>

        <div class="col-md-12 col-sm-12 form-group">
          <input type="radio" name="permissao" id="gerencial" value="Gerencial" <?php if($user->permissao ==
          'Gerencial'): ?> checked <?php endif; ?>>
          <label for="gerencial" class="font-weight-400"><span></span>Gerencial</label>
          <br>
          <input type="radio" name="permissao" id="tecnico" value="T?cnico" <?php if($user->permissao == 'T?cnico'): ?>
          checked <?php endif; ?>>
          <label for="tecnico" class="font-weight-400"><span></span>T?cnico</label>
        </div>
      </div>
    </div>
  </div>

  <?php if($config || Request::is('users/create')): ?>
  <div class="panel panel-default no-border">
    <div class="panel-heading border-radius-10">
      <h2>Credenciais</h2>
    </div>
    <div class="panel-body panel-credenciais">
      <?php if($config): ?>
      <div class="row">
        <div class="col-md-6 col-sm-12 form-group">
          <div class="templatemo-block margin-bottom-5">
            <input type="checkbox" name="alterar_credenciais" id="credenciais" value="true">
            <label for="credenciais" class="font-weight-400"><span></span>Alterar Credenciais</label>
          </div>
        </div>
      </div>
      <?php endif; ?>
      <div class="row has-error">
        <?php if($config): ?>
        <div class="col-md-4 col-sm-12 form-group col-password has-error">
          <?php echo Html::decode(Form::label('password_antigo', 'Senha Antiga <span class="obrigatorio">*</span>',
          ['class' => 'control-label'])); ?>

          <input type="password" required="true" class="form-control" disabled="true" name="password_antigo"
            type="password_antigo" value="" id="password_antigo">
        </div>
        <?php endif; ?>
        <div class="col-md-4 col-sm-12 row-password form-group">
          <?php echo Html::decode(Form::label('password', 'Nova Senha <span class="obrigatorio">*</span>', ['class'
          => 'control-label'])); ?>

          <?php echo Form::password('password', ['required' => 'true', 'class' => 'form-control', 'disabled' =>
          'true']); ?>

        </div>
        <div class="col-md-4 col-sm-12 row-password form-group">
          <?php echo Html::decode(Form::label('password_confirmation', 'Repetir Nova Antiga <span
            class="obrigatorio">*</span>', ['class' => 'control-label'])); ?>

          <?php echo Form::password('password_confirmation', ['required' => 'true', 'class' => 'form-control',
          'disabled' => 'true']); ?>

        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <div class="form-group text-right">
    <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
    <?php if(empty($config)): ?>
    <a href="<?php echo e(route('users.index')); ?>" class="templatemo-white-button"><i class="fa fa-arrow-left"></i>
      Cancelar</a>
    <?php endif; ?>
  </div>
</div>
<?php echo Form::close(); ?>

</div>
<style type="text/css">
  .panel-empresas {
    border-bottom: 1px solid #ddd;
  }
</style>
<script type="text/javascript">
  // Habilita e desabilita as credenciais
    $("#credenciais").change(function(){
        if($(this).is(':checked'))
            $(".panel-credenciais .form-group input").attr("disabled",false);
        else
            $(".panel-credenciais .form-group input").attr("disabled",true);
    });
    <?php if(Request::is('users/create')): ?>
    $(".panel-credenciais .form-group input").attr("disabled",false);
    <?php endif; ?>

    // Verifica o password antigo e os dois novos
    $("input[type=password]").keyup(function(){
        if($(this).attr('id') == "password_antigo"){
            $.ajax({
                type: "GET",
                url: "/user_verificar_password",
                dataType: "html",
                data: "password=" + $(this).val(),
                success: function(response){
                    if(response == "true"){
                        $(".col-password").removeClass('has-error');
                        $(".col-password").addClass('has-success');
                    } else {
                        $(".col-password").removeClass('has-success');
                        $(".col-password").addClass('has-error');
                    }
                }
            });
        } else {
            if($("#password").val() == $("#password_confirmation").val()){
                $("").removeClass('has-error');
                $("").addClass('has-success');
            } else {
                $("").removeClass('has-success');
                $("").addClass('has-error');
            }
        }
    });

    // Verifica se o login já existe
    $("input#login").keyup(function(){
        $.ajax({
            type: "GET",
            url: "/user_verificar_login",
            dataType: "html",
            data: "login=" + $(this).val() + "&method=<?php echo e($method); ?>",
            success: function(response){
                if(response == "true"){
                    $(".col-login").removeClass('has-error');
                    $(".col-login").addClass('has-success');
                } else {
                    $(".col-login").removeClass('has-success');
                    $(".col-login").addClass('has-error');
                }
            }
        });
    });

    // Alterna o campo entre CNPJ e CPF
    $( document ).ready(function() {
        $("#cnpj_1").mask("00.000.000/0000-00");
    });
    function change_tipo(tipo,elemento) {
        var panel = $(elemento).parent().parent().parent();
        var count = $(elemento).attr("name").charAt($(elemento).attr("name").length-1);
        ($(elemento).attr("name") == "tipo_1") ? obrigatorio = " <span class='obrigatorio'>*</span>" : obrigatorio = "";
        $(panel).find(".cnpj").val("");
        if(tipo == "cnpj"){
            $(panel).find("#cnpj_"+count).mask("00.000.000/0000-00");
            $(panel).find("#label_cnpj").html("CNPJ"+obrigatorio);
        } else {
            $(panel).find("#cnpj_"+count).mask("000.000.000-00");
            $(panel).find("#label_cnpj").html("CPF"+obrigatorio);
        }
    }

    // Add uma nova empresa
    $(".add").click(function(){
        var count = $(".panel-body-empresas .panel-empresas").size() + 1;
        var row = $(".panel-body-empresas .panel-empresas:first").clone();
        $(row).find(".bootstrap-filestyle").remove();
        $(row).find("input,textarea").val("");
        $(row).find("input").attr("required",false);
        $(row).find("span.obrigatorio").remove();
        $.each($(row).find("label"), function( index, value ) {
            $(value).attr("for",$(value).prop("for").replace("_1","_"+count));
        });
        $.each($(row).find("input"), function( index, value ) {
            $(value).attr("id",$(value).prop("id").replace("_1","_"+count));
        });
        $.each($(row).find("input[type=radio]"), function( index, value ) {
            $(value).attr("name",$(value).prop("name").replace("_1","_"+count));
        });
        $(".panel-body-empresas").append(row);
        $("#cnpj_"+count).mask("00.000.000/0000-00");
        $(row).find("input.filestyle").filestyle();
    });

    // Adiciona os valores de endereço a partir do blur no campo de cep
    $(".panel-body-empresas").on("blur",".cep",function(){
        var panel = $(this).parent().parent().parent();
        var cep_code = $(this).val();
        if( cep_code.length <= 0 ) return;
        $.get("http://apps.widenet.com.br/busca-cep/api/cep.json", { code: cep_code },
            function(result){
                if( result.status!=1 )
                    return;
                $(panel).find("input.cep").val( result.code );
                $(panel).find("input.cidade").val( result.city );
                $(panel).find("input.bairro").val( result.district );
                $(panel).find("input.endereco").val( result.address );
                $(panel).find("input.estado").val( result.state );
            });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>