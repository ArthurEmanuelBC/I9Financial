@extends('template_pdf')
@section('content')
<table style="margin-top: 20px">
  <thead>
    <tr>
      <th>Data de Lançamento</th>
      <th>Fornecedor/Paciente</th>
      <th>Número do Documento</th>
      <th>Opção</th>
      <th>Tipo</th>
      <th>Valor</th>
      <th>Descrição</th>
    </tr>
  </thead>
  <tbody>
    @foreach($parcelas as $contum)
    <tr>
      <td>{{@date_format(date_create_from_format('Y-m-d', $contum->date), 'd/m/Y')}}</td>
      <td>{{@$contum->paciente_ou_fornecedor()->nome}}</td>
      <td>{{$contum->num_doc}}</td>
      <td>{{$contum->opcao}}</td>
      <td>@if($contum->tipo) Despesa @else Receita @endif</td>
      <td>{{number_format($contum->valor,2,',','.')}}</td>
      <td>{{$contum->descricao}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection