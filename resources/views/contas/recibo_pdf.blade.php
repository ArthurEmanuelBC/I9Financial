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

<p style="font-align: justify; position: absolute; top: 30%">
  Recebemos do(a) Sr(a). @if(@$conta->paciente_ou_fornecedor()->pagador()) {{@$conta->paciente_ou_fornecedor()->pagador()->nome}}, CPF nº {{@$conta->paciente_ou_fornecedor()->pagador()->cpf}}, @else {{@$conta->paciente_ou_fornecedor()->nome}}, CPF nº {{@$conta->paciente_ou_fornecedor()->cpf}}, @endif a quantia de R$ {{number_format($conta->valor,2,',','.')}}, referente a(s) despesa(s) decorrente de atendimento do(a) paciente: {{@$conta->paciente_ou_fornecedor()->nome}}, CPF nº {{@$conta->paciente_ou_fornecedor()->cpf}}, neste estabelecimento.
</p>
<div id="footer">
  <p style="text-align: justify">Atendido pelo médico: {{$conta->medico()->nome}}, CRM/PB {{$conta->medico()->crm}}, pelo qual dou plena e total quitação. Com conhecimento do(a) paciente.</p>
  <p style="margin-top: 30px; margin-bottom: 60px">João Pessoa, {{@date_format(date_create_from_format('Y-m-d', $conta->date), 'd/m/Y')}}</p>
  <p style="text-align: center">{!! Html::image('/storage/empresas/'.$conta->medico()->id.'/'.$conta->medico()->anexo, "Assinatura", ['class' => 'assinaturas']) !!}</p>
</div>
@endsection

<style>
  .assinatura { max-width: 100px; }
</style>