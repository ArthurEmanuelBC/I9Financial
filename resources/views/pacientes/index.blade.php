@extends('template')

@section('content')
@if (Session::has('message'))
<div class="templatemo-content-widget green-bg">
    <i class="fa fa-times"></i>
    <div class="media">
        <div class="media-body">
            <h2>{{Session::get('message')}}</h2>
        </div>
    </div>
</div>
@endif

<div class="templatemo-content-widget white-bg">
    <h2 class="margin-bottom-10">Pacientes</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option value="nome" @if ($filtro=="nome" ) selected @endif>Nome</option>
                        <option value="cpf" @if ($filtro=="cpf" ) selected @endif>CPF</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i>
                            Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('pacientes.create') }}" type="button"
                        class="btn btn-success"><i class="fa fa-plus"></i> Novo
                        {{substr_replace("Pacientes", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($pacientes->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=nome" class="white-text templatemo-sort-by">Nome
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=nome',Request::fullUrl())}} @if($param == 'nome')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=cpf" class="white-text templatemo-sort-by">CPF
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'cpf',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'cpf') !== false)active @endif">CPF
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=cpf',Request::fullUrl())}} @if($param == 'cpf')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'cpf') !== false)active @endif">CPF
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=pagador"
                            class="white-text templatemo-sort-by">Pagador <span
                                class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'pagador',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'pagador') !== false)active @endif">Pagador
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=pagador',Request::fullUrl())}} @if($param == 'pagador')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'pagador') !== false)active @endif">Pagador
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($pacientes as $paciente)
                <tr>
                    <td>{{$paciente->nome}}</td>
                    <td>{{$paciente->cpf}}</td>
                    <td>{{@$paciente->pagador()->nome}}</td>
                    <td class="small" align="center" alt="Editar Paciente">
                        <a href="{{ route('pacientes.edit', $paciente->id) }}">
                            {!! Html::image("images/icons/edit.png", "Editar Paciente") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Paciente">
                        <a onclick="confirm_delete('{{ route('pacientes.destroy', $paciente->id) }}')"
                            href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image("images/icons/delete.png", "Deletar Paciente") !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$pacientes->firstItem()}}</strong> ao
        <strong>{{$pacientes->lastItem()}}</strong> de um total de <strong>{{$pacientes->total()}}</strong> registros
    </p>
    {!! $pacientes->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhum {{substr_replace("Pacientes", "", -1)}} encontrado!</h2>
            </div>
        </div>
    </div>
</div>
@endif
@endsection