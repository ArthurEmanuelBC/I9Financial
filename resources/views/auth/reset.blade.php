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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
.input-group { width: 100%; }
</style>
</head>
<body class="light-gray-bg">
    <div class="templatemo-content-widget templatemo-login-widget white-bg">
        <header class="text-center">
            <div class="logo"><img src="/images/logo.png"></div>
            <h1>I9Financial</h1>
        </header>
        <div class="templatemo-content-widget yellow-bg">
            <div class="media">
                <div class="media-body">
                    <p>Digite seu email e confirme sua nova senha</p>
                </div>        
            </div>                
        </div>
        @if ($errors->any())
        <div class="templatemo-content-widget red-bg">
            <i class="fa fa-times"></i>                
            <div class="media">
                <div class="media-body">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        {!! Form::open(['url'=>'/password/reset']) !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
            </div>  
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>
                    <input type="password" class="form-control" name="password" placeholder="******">
                </div>
            </div>  
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="******">
                </div>
            </div>  
        </div>
        <div class="form-group">
            <button type="submit" class="templatemo-blue-button width-100">Atualizar Senha</button>
        </div>
        {!! Form::close() !!}
    </div>
</body>
</html>