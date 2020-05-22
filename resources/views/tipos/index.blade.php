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
    <h2 class="margin-bottom-10">Tipos</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" @if ($filtro=="nome" ) selected @endif>Nome</option>
                        <option value="tipo" @if ($filtro=="tipo" ) selected @endif>Tipo</option>
                        <option value="opcao" @if ($filtro=="opcao" ) selected @endif>Opcao</option>
                        <option value="perfil" @if ($filtro=="perfil" ) selected @endif>Perfil</option>
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
                <div class="pull-right"><a href="{{ route('tipos.create') }}" type="button" class="btn btn-success"><i
                            class="fa fa-plus"></i> Novo {{substr_replace("Tipos", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($tipos->count())
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
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=tipo" class="white-text templatemo-sort-by">Tipo
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'tipo',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'tipo') !== false)active @endif">Tipo
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=tipo',Request::fullUrl())}} @if($param == 'tipo')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'tipo') !== false)active @endif">Tipo
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=opcao"
                            class="white-text templatemo-sort-by">Opcao <span class="fa fa-caret-{{$caret}}"></span></a>
                    </th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'opcao',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'opcao') !== false)active @endif">Opcao
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=opcao',Request::fullUrl())}} @if($param == 'opcao')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'opcao') !== false)active @endif">Opcao
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=perfil"
                            class="white-text templatemo-sort-by">Perfil <span
                                class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'perfil',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'perfil') !== false)active @endif">Perfil
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=perfil',Request::fullUrl())}} @if($param == 'perfil')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'perfil') !== false)active @endif">Perfil
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($tipos as $tipo)
                <tr>
                    <td>{{$tipo->nome}}</td>
                    <td>@if($tipo->tipo) Despesa @else Receita @endif</td>
                    <td>{{$tipo->opcao}}</td>
                    <td>{{$tipo->perfil}}</td>
                    <td class="small" align="center" alt="Editar Tipo">
                        <a href="{{ route('tipos.edit', $tipo->id) }}">
                            {!! Html::image("images/icons/edit.png", "Editar Tipo") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Tipo">
                        <a onclick="confirm_delete('{{ route('tipos.destroy', $tipo->id) }}')" href="javascript:;"
                            data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image("images/icons/delete.png", "Deletar Tipo") !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$tipos->firstItem()}}</strong> ao
        <strong>{{$tipos->lastItem()}}</strong> de um total de <strong>{{$tipos->total()}}</strong> registros</p>
    {!! $tipos->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhum {{substr_replace("Tipos", "", -1)}} encontrado!</h2>
            </div>
        </div>
    </div>
</div>
@endif
@endsection