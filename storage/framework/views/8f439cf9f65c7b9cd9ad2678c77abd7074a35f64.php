<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I9Financial</title>
	<meta name="description" content="">
	<meta name="author" content="templatemo">
	<!--
		Visual Admin Template
		http://www.templatemo.com/preview/templatemo_455_visual_admin
	-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/templatemo-style.css" rel="stylesheet">
	<link href="/css/chosen.css" rel="stylesheet">
	<link href="/css/select2.css" rel="stylesheet" />
	<link rel="icon" href="/images/logo.png">

	<!-- jQuery -->
	<script src="/js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js">
	</script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<!-- Left column -->
	<div class="templatemo-flex-row">
		<div class="templatemo-sidebar">
			<header class="templatemo-site-header">
				<!-- <div class="square"></div> -->
				<div class="logo"><img src="/images/logo.png"></div>
				<h1>I9Financial</h1>
			</header>
			<!-- <div class="profile-photo-container">
					<img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">
					<div class="profile-photo-overlay"></div>
				</div>       -->
			<!-- Search box -->
			<?php if(Auth::check()): ?>
			<div class="mobile-menu-icon">
				<i class="fa fa-bars"></i>
			</div>
			<nav class="templatemo-left-nav">
				<ul>
					<li><a href="/" class="<?php if(Request::is('/')): ?> active <?php endif; ?>"><i class="fa fa-home fa-fw"></i>Início</a></li>
					<?php if(Auth::user()->permissao == 'Gerencial'): ?>
					<li><a href="/users" class="<?php if(Request::is('users*')): ?> active <?php endif; ?>"><i
								class="fa fa-user fa-fw"></i>Usuários</a></li>
					<?php endif; ?>
					<li><a href="/pacientes" class="<?php if(Request::is('pacientes*')): ?> active <?php endif; ?>"><i
								class="fa fa-users fa-fw"></i>Pacientes</a></li>
					<li><a href="/fornecedors" class="<?php if(Request::is('fornecedors*')): ?> active <?php endif; ?>"><i
								class="fa fa-truck fa-fw"></i>Fornecedores</a></li>
					<li><a href="/empresas" class="<?php if(Request::is('empresas*')): ?> active <?php endif; ?>"><i
								class="fa fa-briefcase fa-fw"></i>Médicos</a></li>
					<li><a href="/contas?tipo=0" class="<?php if(Request::is('contas*') && @$tipo == '0'): ?> active <?php endif; ?>"><i
								class="fa fa-mail-forward fa-fw"></i>Receita</a></li>
					<li><a href="/contas?tipo=1" class="<?php if(Request::is('contas*') && @$tipo == '1'): ?> active <?php endif; ?>"><i
								class="fa fa-mail-reply fa-fw"></i>Despesa</a></li>
					<li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal"><i
								class="fa fa-eject fa-fw"></i>Sair</a></li>
				</ul>
			</nav>
			<?php endif; ?>
		</div>
		<!-- Main content -->
		<div class="templatemo-content col-1 light-gray-bg">
			<?php if(Auth::check()): ?>
			<div class="templatemo-top-nav-container">
				<div class="row">
					<nav class="templatemo-top-nav col-lg-8 col-md-8 col-xs-12 form-group">
						<ul class="text-uppercase">
							<li><a href="<?php echo e(route('users.edit', ['id' => Auth::user()->id, 'config' => 'true'])); ?>"
									<?php if(!empty($config)): ?>class="active" <?php endif; ?>>Configurações</a></li>
							<li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal">Sair</a></li>
						</ul>
					</nav>
					<div class="col-md-4 col-xs-12 user_online"><span>Olá <?php echo e(Auth::user()->name); ?>!</span></div>
				</div>
			</div>
			<?php endif; ?>
			<div class="templatemo-content-container">
				<?php echo $__env->yieldContent('content'); ?>
				<footer class="text-right">
					<p>
						Copyright &copy; 2018 I9 Technology
						<a href="http://www.i9technology.com.br" target="_blank">
							<?php echo Html::image("/images/logo.png", "I9 Technology", ['id' => 'logo']); ?>

						</a>
					</p>
				</footer>
			</div>
		</div>
	</div>

	<!-- Modals -->
	<div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Deseja realmente excluir este registro?</h4>
				</div>
				<div class="modal-footer">
					<?php echo Form::open(['route' => null, 'method' => 'delete', 'id' => 'form-delete']); ?>

					<?php if(isset($responsavel)): ?> <input type="hidden" name="responsavel" value="true"> <?php endif; ?>
					<button type="submit" class="btn btn-danger">Sim</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Deseja realmente sair do sistema?</h4>
				</div>
				<div class="modal-footer">
					<a href="/auth/logout" class="btn btn-primary">Sim</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
				</div>
			</div>
		</div>
	</div>

	<!-- JS -->
	<script src="/js/jquery.mask.min.js"></script>
	<script src="/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap-filestyle.min.js"></script>
	<!-- http://markusslima.github.io/bootstrap-filestyle/ -->
	<script type="text/javascript" src="/js/templatemo-script.js"></script>
	<script src="/js/chosen.js" type="text/javascript"></script>
	<script src="/js/collapse.js" type="text/javascript"></script>
	<script src="/js/transition.js" type="text/javascript"></script>
	<script src="/js/select2.js"></script>
	<?php if(Request::is('lancamentos*')): ?> <script type="text/javascript">
		$('.submenu.lancamentos > a').trigger( "click" );
	</script> <?php endif; ?>
	<script type="text/javascript">
		$(".chzn-select").chosen();
			$('.collapse').collapse();
			$(".chzn-container-multi").each(function( index ) {
				$tamanho = $(this).width();
				$(this).width('100%');
				$(this).find(".chzn-drop").width(($tamanho-2)+"%");
			});
	</script>
</body>

</html>