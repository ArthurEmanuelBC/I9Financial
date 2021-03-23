@extends('template_pdf')
@section('content')

@if(isset($medico) && $margem == 'true')
<table>
  <thead>
    <tr>
      <th colspan="6">Margem Mensal de {{$medico->nome}}</th>
    </tr>
  </thead>
  <tbody>
    @php($ano = date('Y'))
    @foreach($medico->margem_mensal() as $mes => $valor)
    @if(in_array($mes, ["01/$ano","04/$ano","07/$ano","10/$ano"])) <tr> @endif
      <td align="right"><strong>{{$mes}}: </strong></td>
      <td>{{number_format($valor,2,',','.')}}</td>
      @if(in_array($mes, ["03/$ano","06/$ano","09/$ano","12/$ano"]))
    <tr> @endif
      @endforeach

    <tr>
      <td align="right" colspan="5"><strong>Valor Real da Margem Atual: </strong></td>
      <td>{{number_format($medico->margem_atual(),2,',','.')}}</td>
    </tr>
  </tbody>
</table>
@endif

<table style="margin-top: 20px">
  <thead>
    @if(!in_array('lancamento', $ocultas)) <th class="lancamento">Data de Lançamento</th> @endif
    @if(!in_array('paciente_id', $ocultas)) <th class="paciente_id">@if($tipo) Fornecedor @else Paciente @endif</th>
    @endif
    @if(!in_array('cnpj_cpf', $ocultas)) <th class="cnpj_cpf">@if($tipo) CNPJ @else CPF @endif</th>
    @endif
    @if(!$tipo)
    @if(!in_array('pagador_nome', $ocultas)) <th class="pagador_nome">Nome do Pagador</th>@endif
    @if(!in_array('pagador_cpf', $ocultas)) <th class="pagador_cpf">CPF do Pagador</th>@endif
    @endif
    @if(!in_array('num_doc', $ocultas)) <th class="num_doc">Número do Documento</th> @endif
    @if(!in_array('opcao', $ocultas)) <th class="opcao">Opção</th> @endif
    @if(!in_array('tipo', $ocultas)) <th class="tipo">Tipo</th> @endif
    @if(!in_array('valor', $ocultas)) <th class="valor">Valor</th> @endif
    @if(!in_array('descricao', $ocultas)) <th class="descricao">Descrição</th> @endif
  </thead>
  <tbody>
    <tr class="linha_total">
      @if(!in_array('lancamento', $ocultas)) <td class="lancamento"></td>@endif
      @if(!in_array('paciente_id', $ocultas)) <td class="paciente_id"></td>@endif
      @if(!in_array('cnpj_cpf', $ocultas)) <td class="cnpj_cpf"></td>@endif
      @if(!$tipo)
      @if(!in_array('pagador_nome', $ocultas)) <td class="pagador_nome"></td>@endif
      @if(!in_array('pagador_cpf', $ocultas)) <td class="pagador_cpf"></td>@endif
      @endif
      @if(!in_array('num_doc', $ocultas)) <td class="num_doc"></td>@endif
      @if(!in_array('opcao', $ocultas)) <td class="opcao"></td>@endif
      @if(!in_array('tipo', $ocultas)) <td class="tipo"></td>@endif
      @if(!in_array('valor', $ocultas)) <td class="valor">{{number_format($total,2,',','.')}}</td>@endif
      @if(!in_array('descricao', $ocultas)) <td class="descricao"></td>@endif
    </tr>
    @foreach($contas as $contum)
    <tr>
      @if(!in_array('lancamento', $ocultas)) <td class="lancamento">
        {{@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')}}
      </td>@endif
      @if(!in_array('paciente_id', $ocultas)) <td class="paciente_id">{{@$contum->paciente_ou_fornecedor()->nome}}</td>
      @endif
      @if(!in_array('cnpj_cpf', $ocultas)) <td class="cnpj_cpf">@if($tipo) {{@$contum->paciente_ou_fornecedor()->cnpj}} @else {{@$contum->paciente_ou_fornecedor()->cpf}} @endif</td>
      @endif
      @if(!$tipo)
      @if(!in_array('pagador_nome', $ocultas)) <td class="pagador_nome">{{@$contum->paciente_ou_fornecedor()->pagador()->nome}}</td>@endif
      @if(!in_array('pagador_cpf', $ocultas)) <td class="pagador_cpf">{{@$contum->paciente_ou_fornecedor()->pagador()->cpf}}</td>@endif
      @endif
      @if(!in_array('num_doc', $ocultas)) <td class="num_doc">{{$contum->num_doc}}</td> @endif
      @if(!in_array('opcao', $ocultas)) <td class="opcao">{{$contum->opcao}}</td> @endif
      @if(!in_array('tipo', $ocultas)) <td class="tipo">{{@$contum->tipo()->nome}}</td> @endif
      @if(!in_array('valor', $ocultas)) <td class="valor">{{number_format($contum->valor,2,',','.')}}</td> @endif
      @if(!in_array('descricao', $ocultas)) <td class="descricao">{{$contum->descricao}}</td> @endif
    </tr>
    @endforeach
  </tbody>
</table>
@endsection