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
    <h2 class="margin-bottom-10">Empresas</h2>
    <div class="row">
        <div class="col-md-8 col-sm-12 form-group">
            <form role="form" class="form-search" method="get">
                <div class="input-group">
                    <select class="form-control search-filtro" name="filtro">
                        <option>Limpar</option>
                        <option value="nome" @if ($filtro == "nome") selected @endif>Nome Fantasia</option>
                    <option value="cnpj" @if ($filtro == "cnpj") selected @endif>CNPJ/CPF</option>
                    <option value="cep" @if ($filtro == "cep") selected @endif>CEP</option>
                    <option value="logradouro" @if ($filtro == "logradouro") selected @endif>Logradouro</option>
                    <option value="bairro" @if ($filtro == "bairro") selected @endif>Bairro</option>
                    <option value="cidade" @if ($filtro == "cidade") selected @endif>Cidade</option>
                    <option value="estado" @if ($filtro == "estado") selected @endif>Estado</option>
                    <option value="numero" @if ($filtro == "numero") selected @endif>Número</option>
                    </select>
                    <input type="text" class="form-control search-valor" name="valor" value="{{$valor}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info search-button"><i class="fa fa-search"></i> Pesquisar</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
                <div class="pull-right"><a href="{{ route('empresas.create') }}" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo {{substr_replace("Empresas", "", -1)}}</a></div>
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
<th><a href="{{Request::fullUrl()}}{{$signal}}order=nome" class="white-text templatemo-sort-by">Nome Fantasia <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'nome',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome Fantasia <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=nome',Request::fullUrl())}} @if($param == 'nome')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'nome') !== false)active @endif">Nome Fantasia <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=tipo" class="white-text templatemo-sort-by">Tipo <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'tipo',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'tipo') !== false)active @endif">Tipo <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=tipo',Request::fullUrl())}} @if($param == 'tipo')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'tipo') !== false)active @endif">Tipo <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=cnpj" class="white-text templatemo-sort-by">CNPJ/CPF <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'cnpj',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'cnpj') !== false)active @endif">CNPJ/CPF <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=cnpj',Request::fullUrl())}} @if($param == 'cnpj')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'cnpj') !== false)active @endif">CNPJ/CPF <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=cep" class="white-text templatemo-sort-by">CEP <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'cep',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'cep') !== false)active @endif">CEP <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=cep',Request::fullUrl())}} @if($param == 'cep')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'cep') !== false)active @endif">CEP <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=logradouro" class="white-text templatemo-sort-by">Logradouro <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'logradouro',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'logradouro') !== false)active @endif">Logradouro <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=logradouro',Request::fullUrl())}} @if($param == 'logradouro')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'logradouro') !== false)active @endif">Logradouro <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=bairro" class="white-text templatemo-sort-by">Bairro <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'bairro',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'bairro') !== false)active @endif">Bairro <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=bairro',Request::fullUrl())}} @if($param == 'bairro')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'bairro') !== false)active @endif">Bairro <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=cidade" class="white-text templatemo-sort-by">Cidade <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'cidade',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'cidade') !== false)active @endif">Cidade <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=cidade',Request::fullUrl())}} @if($param == 'cidade')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'cidade') !== false)active @endif">Cidade <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=estado" class="white-text templatemo-sort-by">Estado <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'estado',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'estado') !== false)active @endif">Estado <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=estado',Request::fullUrl())}} @if($param == 'estado')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'estado') !== false)active @endif">Estado <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                        @if(is_null($param))
<th><a href="{{Request::fullUrl()}}{{$signal}}order=numero" class="white-text templatemo-sort-by">Número <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
@if(strpos($param,'desc') !== false)
<th><a href="{{str_replace(str_replace(' ','%20',$param),'numero',Request::fullUrl())}}" class="white-text templatemo-sort-by @if(strpos($param,'numero') !== false)active @endif">Número <span class="fa fa-caret-{{$caret}}"></span></a></th>
@else
<th><a href="{{str_replace('order='.$param,'order=numero',Request::fullUrl())}} @if($param == 'numero')desc @endif" class="white-text templatemo-sort-by @if(strpos($param,'numero') !== false)active @endif">Número <span class="fa fa-caret-{{$caret}}"></span></a></th>
@endif
@endif

                    <th colspan="2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($empresas as $empresa)
                <tr>
                    <td>{{$empresa->nome}}</td>
                    <td>@if($empresa->tipo == 'CPF') Pessoa Física @else Pessoa Jurídica @endif</td>
                    <td>{{$empresa->cnpj}}</td>
                    <td>{{$empresa->cep}}</td>
                    <td>{{$empresa->logradouro}}</td>
                    <td>{{$empresa->bairro}}</td>
                    <td>{{$empresa->cidade}}</td>
                    <td>{{$empresa->estado}}</td>
                    <td>{{$empresa->numero}}</td>
                    <td class="small" align="center" alt="Editar Empresa">
                        <a href="{{ route('empresas.edit', $empresa->id) }}">
                            {!! Html::image("images/icons/edit.png", "Editar Empresa") !!}
                        </a>
                    </td>
                    <td class="small" align="center" alt="Deletar Empresa">
                        <a onclick="confirm_delete('{{ route('empresas.destroy', $empresa->id) }}')" href="javascript:;" data-toggle="modal" data-target="#confirm_delete">
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
    <p class="text_pagination pull-left">Exibindo do <strong>{{$empresas->firstItem()}}</strong> ao <strong>{{$empresas->lastItem()}}</strong> de um total de <strong>{{$empresas->total()}}</strong> registros</p>
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
