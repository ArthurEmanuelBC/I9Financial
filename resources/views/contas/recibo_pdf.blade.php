@extends('template_pdf')
@section('content')
<style type="text/css">
  table { margin-bottom: 100px }
  table tr td { font-size: 18px; }
  p { font-size: 24px; }
  #footer { bottom: 200px; }
</style>

<table class="no-border">
  <tr>
    <td align="left">{{$conta->medico()->nome}}</td>
    <td align="right">{{$conta->medico()->logradouro}}, {{$conta->medico()->numero}}</td>
  </tr>
  <tr>
    <td align="left">CRM/PB: {{$conta->medico()->crm}}</td>
    <td align="right">{{$conta->medico()->bairro}}, CEP {{$conta->medico()->cep}}, {{$conta->medico()->cidade}}/{{$conta->medico()->estado}}</td>
  </tr>
  <tr>
    <td align="left">CPF: {{$conta->medico()->cpf}}</td>
    <td align="right">Telefone: {{$conta->medico()->telefone}}</td>
  </tr>
</table>

<div>
  <strong>
    <h1 align="center" style="float: left; width: 80%;">RECIBO</h1>
    <h3 align="right" style="float: right; width: 20%;">Nº {{$conta->num_doc}}</h3>
  </strong>
</div>

@endsection

<style>
  .assinatura { max-width: 100px; }
</style>