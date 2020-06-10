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
    <h2 class="margin-bottom-10">Médicos</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option value="nome" @if ($filtro=="nome" ) selected @endif>Nome</option>
                        <option value="cpf" @if ($filtro=="cpf" ) selected @endif>CPF</option>
                        <option value="crm" @if ($filtro=="crm" ) selected @endif>CRM</option>
                        <option value="cidade" @if ($filtro=="cidade" ) selected @endif>Cidade</option>
                        <option value="estado" @if ($filtro=="estado" ) selected @endif>Estado</option>
                        <option value="telefone" @if ($filtro=="telefone" ) selected @endif>Telefone</option>
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
                <div class="pull-right"><a href="{{ route('empresas.create') }}" type="button"
                        class="btn btn-success"><i class="fa fa-plus"></i> Novo
                        {{substr_replace("Médicos", "", -1)}}</a></div>
            </div>
        </div>
    </div>
</div>


@if($empresas->count())
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
                            Fantasia <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=nome',Request::fullUrl())}} @if($param == 'nome')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome
                            Fantasia <span class="fa fa-caret-{{$caret}}"></span></a></th>
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
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=crm" class="white-text templatemo-sort-by">CRM
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'crm',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'crm') !== false)active @endif">CRM
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=crm',Request::fullUrl())}} @if($param == 'crm')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'crm') !== false)active @endif">CRM
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=cidade"
                            class="white-text templatemo-sort-by">Cidade <span
                                class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'cidade',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'cidade') !== false)active @endif">Cidade
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=cidade',Request::fullUrl())}} @if($param == 'cidade')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'cidade') !== false)active @endif">Cidade
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=estado"
                            class="white-text templatemo-sort-by">Estado <span
                                class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'estado',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'estado') !== false)active @endif">Estado
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=estado',Request::fullUrl())}} @if($param == 'estado')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'estado') !== false)active @endif">Estado
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    @if(is_null($param))
                    <th><a href="{{Request::fullUrl()}}{{$signal}}order=telefone"
                            class="white-text templatemo-sort-by">Telefone <span
                                class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    @if(strpos($param,'desc') !== false)
                    <th><a href="{{str_replace(str_replace(' ','%20',$param),'telefone',Request::fullUrl())}}"
                            class="white-text templatemo-sort-by @if(strpos($param,'telefone') !== false)active @endif">Telefone
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @else
                    <th><a href="{{str_replace('order='.$param,'order=telefone',Request::fullUrl())}} @if($param == 'telefone')desc @endif"
                            class="white-text templatemo-sort-by @if(strpos($param,'telefone') !== false)active @endif">Telefone
                            <span class="fa fa-caret-{{$caret}}"></span></a></th>
                    @endif
                    @endif

                    <th colspan="3"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($empresas as $empresa)
                <tr>
                    <td>{{$empresa->nome}}</td>
                    <td>{{$empresa->cpf}}</td>
                    <td>{{$empresa->crm}}</td>
                    <td>{{$empresa->cidade}}</td>
                    <td>{{$empresa->estado}}</td>
                    <td>{{$empresa->telefone}}</td>
                    <td class="small" align="center" alt="Visualizar Assinatura Digital">
                        @if($empresa->anexo)
                        <a href="{{ "storage/empresas/$empresa->id/$empresa->anexo", $empresa->anexo }}"
                            target="_blank">
                            {!! Html::image("images/icons/print.png", "Visualizar Assinatura Digital") !!}
                        </a>
                        @endif
                    </td>
                    <td class="small" align="center" alt="Editar Empresa">
                        <a href="{{ route('empresas.edit', $empresa->id) }}">
                            {!! Html::image("images/icons/edit.png", "Editar Empresa") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Empresa">
                        <a onclick="confirm_delete('{{ route('empresas.destroy', $empresa->id) }}')" href="javascript:;"
                            data-toggle="modal" data-target="#confirm_delete">
                            {!! Html::image("images/icons/delete.png", "Deletar Empresa") !!}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-wrap">
    <p class="text_pagination pull-left">Exibindo do <strong>{{$empresas->firstItem()}}</strong> ao
        <strong>{{$empresas->lastItem()}}</strong> de um total de <strong>{{$empresas->total()}}</strong> registros</p>
    {!! $empresas->render() !!}
</div>
@else
<div class="templatemo-content-widget no-padding">
    <div class="templatemo-content-widget yellow-bg">
        <i class="fa fa-times"></i>
        <div class="media">
            <div class="media-body">
                <h2>Nenhum {{substr_replace("Empresas", "", -1)}} encontrado!</h2>
            </div>
        </div>
    </div>
</div>
@endif
@endsection