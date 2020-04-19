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
  Recebemos do(a) Sr(a). @if($conta->paciente_ou_fornecedor()->pagador())
  {{$conta->paciente_ou_fornecedor()->pagador()->nome}}, CPF nº
  {{$conta->paciente_ou_fornecedor()->pagador()->cpf}}, @else
  {{$conta->paciente_ou_fornecedor()->nome}}, CPF nº {{$conta->paciente_ou_fornecedor()->cpf}}, @endif a importância de
  R$
  {{number_format($conta->valor,2,',','.')}}, referente a(s) despesa(s) decorrente do atendimento do paciente
  {{$conta->paciente_ou_fornecedor()->nome}}, neste estabelecimento.
</p>
<div id="footer">
  <p>Atendido pelo médico: {{$conta->medico()->nome}}, CRM{{$conta->medico()->crm}}, pelo qual dou plena e total
    quitação.</p>
  <div style="text-align: center;">
    <div style="float: left; width: 50%;">
      <p>João Pessoa, {{@date_format(date_create_from_format('Y-m-d', $conta->date), 'd/m/Y')}}</p>
      <p>Com conhecimento do paciente</p>
    </div>
    <div style="float: left; width: 50%;">
      <p>{!! Html::image('/storage/empresas/'.$conta->medico()->id.'/'.$conta->medico()->anexo, "Assinatura", ['class'
        => 'assinaturas']) !!}</p>
      <p>Assinatura</p>
    </div>
  </div>
</div>
@endsection

<style>
  .assinatura {
    max-width: 100px;
  }
</style>