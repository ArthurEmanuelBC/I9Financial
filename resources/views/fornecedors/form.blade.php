@extends('template')

@section('content')
@if ($errors->any())
<div class="templatemo-content-widget yellow-bg">
    <i class="fa fa-times"></i>
    <div class="media">
        <div class="media-body">
            <ul>
                @foreach($errors->all() as $error)
                <li>
                    <h2>{{ $error }}</h2>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">
        @if(Request::is('*fornecedors/create')) Cadastrar @else Editar @endif Fornecedor
    </h2>

    {!! Form::open(['route' => [$url, $fornecedor->id], 'method' => $method, 'class' => 'form-horizontal']) !!}
    <div class="row form-group">
        <div class="col-md-6">
            {!! Html::decode(Form::label('nome', 'Nome <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])) !!}
            {!! Form::text('nome', $fornecedor->nome, ['class' => 'form-control','required' => 'true']) !!}
        </div>
        <div class="col-md-6">
            {!! Html::decode(Form::label('cnpj', 'CPF/CNPJ <span class="obrigatorio">*</span>', ['class' =>
            'control-label'])) !!}
            {!! Form::text('cnpj', $fornecedor->cnpj, ['class' => 'form-control','required' => 'true']) !!}
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="templatemo-blue-button"><i class="fa fa-plus"></i> Salvar</button>
        <a class="templatemo-white-button" href="{{ route('fornecedors.index') }}"><i class="fa fa-arrow-left"></i>
            Voltar</a>
    </div>
    {!! Form::close() !!}

</div>

<script>
    $("#cnpj").keydown(function(){
        try {
            $("#cnpj").unmask();
        } catch (e) {}

        var tamanho = $("#cnpj").val().length;

        if(tamanho < 11){
            $("#cnpj").mask("999.999.999-99");
        } else {
            $("#cnpj").mask("99.999.999/9999-99");
        }

        // ajustando foco
        var elem = this;
        setTimeout(function(){
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
</script>
@endsection