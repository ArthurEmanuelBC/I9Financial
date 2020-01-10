@extends('template_pdf')
@section('content')
<style type="text/css">
  p,
  table tr td {
    font-size: 24px;
  }
</style>

<h2 align="center">{{$conta->medico()->nome}}</h2>

<table class="no-border">
  <tr>
    <td colspan="2">{{$conta->medico()->cpf}}</td>
  </tr>
  <tr>
    <td>{{$conta->medico()->logradouro}}</td>
    <td>{{$conta->medico()->bairro}}</td>
  </tr>
  <tr>
    <td>{{$conta->medico()->cidade}}</td>
    <td>{{$conta->medico()->estado}}</td>
  </tr>
  <tr>
    <td>{{$conta->medico()->cep}}</td>
    <td>Fone: {{$conta->medico()->telefone}}</td>
  </tr>
</table>

<p style="text-align: right"><strong>Nº {{$conta->num_doc}}</strong></p>

<p style="text-align: right">R$ {{number_format($conta->valor,2,',','.')}}</p>

<p>
  Recebemos do(a) Sr(a). @if($conta->paciente()->pagador()) {{$conta->paciente()->pagador()->nome}}, CPF nº
  {{$conta->paciente()->pagador()->cpf}}, @else
  {{$conta->paciente()->nome}}, CPF nº {{$conta->paciente()->cpf}}, @endif a importância de R$
  {{number_format($conta->valor,2,',','.')}}, referente a(s) despesa(s) decorrente do atendimento do paciente
  {{$conta->paciente()->nome}}, neste estabelecimento.
</p>
@endsection