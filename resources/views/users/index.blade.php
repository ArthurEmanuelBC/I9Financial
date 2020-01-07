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
    <h2 class="margin-bottom-10">Usuários</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" @if ($filtro=="users.nome" ) selected @endif>Nome</option>
                        <option value="email" @if ($filtro=="email" ) selected @endif>Email</option>
                        <option value="permissao" @if ($filtro=="permissao" ) selected @endif>Permissão</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i>
                            Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4 col-sm-12 form-group">
            <div class="pull-right search-new"><a href="{{ route('users.create') }}" type="button"
                    class="btn btn-success"><i class="fa fa-plus"></i> Novo {{substr_replace("Usuários", "", -1)}}</a>
            </div>
        </div>
    </div>
</div>

@if($users->count())
<div class="templatemo-content-widget no-padding">
    <div class="panel panel-default table-responsive">
        <table class="table table-striped table-bordered templatemo-user-table">
            <thead>
                <tr>
                    @if(is_null($param))
                    <th><a href="{{ Request::fullUrl() }}{{ $signal }}order=id" class="white-text templatemo-sort-by">Id
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{ str_replace(str_replace(' ','%20',$param),'id',Request::fullUrl()) }}"
                            class="white-text templatemo-sort-by @if(strpos($param,'id') !== false)active @endif">Id
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{ str_replace('order='.$param,'order=id',Request::fullUrl()) }} @if($param == 'id')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'id') !== false)active @endif">Id
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif
                    @if(is_null($param))
                    <th><a href="{{ Request::fullUrl() }}{{ $signal }}order=nome"
                            class="white-text templatemo-sort-by">Nome <span class="fa fa-caret-{{$caret}}"></span></a>
                    </th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{ str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl()) }}"
                            class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{ str_replace('order='.$param,'order=nome',Request::fullUrl()) }} @if($param == 'nome')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif
                    @if(is_null($param))
                    <th><a href="{{ Request::fullUrl() }}{{ $signal }}order=email"
                            class="white-text templatemo-sort-by">Email <span class="fa fa-caret-{{$caret}}"></span></a>
                    </th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{ str_replace(str_replace(' ','%20',$param),'email',Request::fullUrl()) }}"
                            class="white-text templatemo-sort-by @if(strpos($param,'email') !== false)active @endif">Email
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{ str_replace('order='.$param,'order=email',Request::fullUrl()) }} @if($param == 'email')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'email') !== false)active @endif">Email
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif
                    @if(is_null($param))
                    <th><a href="{{ Request::fullUrl() }}{{ $signal }}order=permissao"
                            class="white-text templatemo-sort-by">Permissão <span
                                class="fa fa-caret-{{$caret}}"></span></a>
                    </th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{ str_replace(str_replace(' ','%20',$param),'permissao',Request::fullUrl()) }}"
                            class="white-text templatemo-sort-by @if(strpos($param,'permissao') !== false)active @endif">Permissão
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{ str_replace('order='.$param,'order=permissao',Request::fullUrl()) }} @if($param == 'permissao')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'permissao') !== false)active @endif">Permissão
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->permissao}}</td>
                    <td class="small" align="center" alt="Editar Usuário">
                        <a href="{{ route('users.edit', $user->id) }}">
                            {!! Html::image("/images/icons/edit.png", "Editar Usuário") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Usuário">
                        <a onclick="confirm_delete('{{ route('users.destroy', $user->id) }}')" href="javascript:;"
                            data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image('/images/icons/delete.png', 'Deletar Usuário') !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <p class="text_pagination">Exibindo do <strong>{{$users->firstItem()}}</strong> ao
                <strong>{{$users->lastItem()}}</strong> de um total de <strong>{{$users->total()}}</strong> registros
            </p>
        </div>
        <div class="col-md-4 col-sm-12">
            {!! $users->render() !!}
        </div>
    </div>
</div>
@else
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
@endif
@endsection