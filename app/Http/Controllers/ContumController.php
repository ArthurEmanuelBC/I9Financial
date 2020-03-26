<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contum;
use App\Empresa;
use App\Parcela;
use App\Paciente;
use App\Fornecedor;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use Auth;
use Redirect;

class ContumController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request)
	{
		// Ordenação
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		(isset($request->order)) ? $order = $request->order : $order = "id";

		// Cláusuras
		$where = "tipo = ".($request->tipo ? 'true' : 'false');
		if(!isset($request->data1)) $request->data1 = date('Y-m-d');
		if(!isset($request->data2)) $request->data2 = date('Y-m-d');
		$where .= " and date between '$request->data1' and '$request->data2'";
		if(!blank($request->paciente_id) && $request->paciente_id != 'Todos') $where .= " and paciente_id = $request->paciente_id";
		if(!blank($request->opcao) && $request->opcao != 'Todos') $where .= " and opcao = '$request->opcao'";
		if(!blank($request->tipo_conta) && $request->tipo_conta != 'Todos') $where .= " and tipo_conta = '$request->tipo_conta'";

		if(blank($request->medico_id) || $request->medico_id == 'Nenhum')
			$where .= " and empresa_id IS NULL";
		else
			$where .= " and empresa_id = $request->medico_id";

		(isset($request->ocultas)) ? $ocultas = $request->ocultas : $ocultas = [];

		if(!blank($request->filtro) && !blank($request->valor)){
			foreach ($request->filtro_avancado as $key => $filtro) {
				$tipo = $request->tipo_avancado[$key];
				$valor = $request->valor_avancado[$key];

				if(in_array($filtro, ["descricao"])) $tipo = 'like';
				if($tipo == 'like') $valor = "%$valor%";

				if($filtro == "valor") {
					$where .= " and valor $tipo $valor";
				} else {
					$where .= " and UPPER($filtro) $tipo '".strtoupper($valor)."'";
				}
			}

		}

		$contas = Contum::whereRaw($where)->orderBy("date","DESC");

		$parametros = [];
		$parametros["tipo"] = $request->tipo;
		$parametros["opcao"] = $request->opcao;
		$parametros["tipo_conta"] = $request->tipo_conta;
		if(!blank($request->paciente_id) && $request->paciente_id != 'Todos') $parametros["paciente"] = Paciente::findOrFail($request->paciente_id)->nome;
		if(!blank($request->fornecedor_id) && $request->fornecedor_id != 'Todos') $parametros["fornecedor"] = Paciente::findOrFail($request->fornecedor_id)->nome;
		if(!blank($request->medico_id) && $request->medico_id != 'Nenhum') $parametros["medico"] = Empresa::findOrFail($request->medico_id);
		$parametros["tipo_relatorio"] = $request->tipo_relatorio;
		(isset($request->data1)) ? $parametros["data1"] = $request->data1 : $parametros["data1"] = Date::now();
		(isset($request->data2)) ? $parametros["data2"] = $request->data2 : $parametros["data2"] = Date::now();
		$parametros["filtro"] = $request->filtro;
		$parametros["valor"] = $request->valor;
		$parametros["filtro_avancado"] = $request->filtro_avancado;
		$parametros["tipo_avancado"] = $request->tipo_avancado;
		$parametros["valor_avancado"] = $request->valor_avancado;
		if($request->tipo == '0')
			$parametros["pacientes"] = [NULL => "Todos"] + Paciente::lists('nome','id')->all();
		else
			$parametros["fornecedores"] = [NULL => "Todos"] + Fornecedor::lists('nome','id')->all();
		$parametros["medicos"] = [NULL => "Nenhum"] + Empresa::lists('nome','id')->all();

		if($request->tipo == '1')
					$parametros["opcoes"] = ['Todos' => 'Todos', 'Pessoal' => 'Pessoal', 'Material Médico' => 'Material Médico', 'Material de Custeio' => 'Material de Custeio', 'Marketing/divulgação' => 'Marketing/divulgação', 'Outros' => 'Outros'];
				else
					$parametros["opcoes"] = ['Todos' => 'Todos', 'Emissão de Recibo' => 'Emissão de Recibo', 'Aluguel' => 'Aluguel', 'Salário' => 'Salário', 'Convênio' => 'Convênio', 'Pró-labore' => 'Pró-labore', 'Outros' => 'Outros'];

		if(isset($request->pdf)){
			($request->tipo == "0") ? $titulo = "Relatório de Receitas" : $titulo = "Relatório de Despesas";
			$cabecalho = ["Data Inicial" => date_format(date_create_from_format('Y-m-d', $parametros["data1"]), 'd/m/Y'), "Data Final" => date_format(date_create_from_format('Y-m-d', $parametros["data2"]), 'd/m/Y'), "Médico" => @$parametros["medico"]->nome, "Paciente" => @$parametros["paciente"], "Opção" => $parametros["opcao"], "Tipo" => $parametros["tipo_conta"]];
			return \PDF::loadView('contas.index_pdf', ["contas" => $contas->get(), "tipo" => $request->tipo, "ocultas" => $ocultas, 'titulo' => $titulo, 'medico' => @$parametros["medico"], 'parametros' => $cabecalho])->inline();
		} else {
			return view('contas.index', ["contas" => $contas->paginate(30), "parametros" => $parametros, "tipo" => $request->tipo]);
			}
		}

			/**
			* Show the form for creating a new resource.
			*
			* @return Response
			*/
			public function create(Request $request)
			{
				$contum = new Contum();
				$contum->date = Date::today();
				$medicos = [NULL => "Nenhum"] + Empresa::lists('nome','id')->all();
				Auth::user()->permissao == 'Gerencial' ? $data_disabled = false : $data_disabled = true;

				if($request->tipo == '0')
					$nomes = [NULL => "Nenhum"] + Paciente::lists('nome','id')->all();
				else
					$nomes = [NULL => "Nenhum"] + Fornecedor::lists('nome','id')->all();

				$contum->num_doc = Contum::max('num_doc');
				if(is_null($contum->num_doc))
					$contum->num_doc = 1501;
				else
					$contum->num_doc += 1;

				if($request->tipo == '1')
					$opcoes = ['Pessoal' => 'Pessoal', 'Material Médico' => 'Material Médico', 'Material de Custeio' => 'Material de Custeio', 'Marketing/divulgação' => 'Marketing/divulgação', 'Outros' => 'Outros'];
				else
					$opcoes = ['Emissão de Recibo' => 'Emissão de Recibo', 'Aluguel' => 'Aluguel', 'Salário' => 'Salário', 'Convênio' => 'Convênio', 'Pró-labore' => 'Pró-labore', 'Outros' => 'Outros'];

				return view('contas.form', ["contum" => $contum, "nomes" => $nomes, "medicos" => $medicos, "url" => "contas.store", "method" => "post", "tipo" => $request->tipo, 'opcoes' => $opcoes, 'data_disabled' => $data_disabled]);
			}

			/**
			* Store a newly created resource in storage.
			*
			* @param Request $request
			* @return Response
			*/
			public function store(Request $request)
			{
				if($request->tipo == '0') {
					$medico = Empresa::findOrFail($request->empresa_id);
					if($medico->margem_atual() < floatval(str_replace(",", ".", str_replace(".", "", $request->valor))))
						return Redirect::back()->withErrors(['Não há margem suficiente!']);
				}

				$contum = new Contum();
				$contum->date = Date::parse($request->date);
				$contum->fornecedor = $request->fornecedor;
				$contum->num_doc = $request->num_doc;
				$contum->valor = str_replace(",", ".", str_replace(".", "", $request->valor));
				$contum->descricao = $request->descricao;
				$contum->tipo = $request->tipo;
				$contum->tipo_conta = $request->tipo_conta;
				$contum->opcao = $request->opcao;
				$contum->user_id = Auth::user()->id;
				if($request->tipo == '0')
					$contum->paciente_id = $request->nome_id;
				else
					$contum->fornecedor_id = $request->nome_id;
				$contum->empresa_id = $request->empresa_id;
				$contum->save();
				return redirect()->route('contas.index', ["tipo" => $request->tipo])->with('message', 'Conta cadastrada com sucesso!');
			}

			/**
			* Show the form for editing the specified resource.
			*
			* @param  int  $id
			* @return Response
			*/
			public function edit(Request $request, $id)
			{
				$contum = Contum::findOrFail($id);
				$medicos = [NULL => "Nenhum"] + Empresa::lists('nome','id')->all();
				Auth::user()->permissao == 'Gerencial' ? $data_disabled = false : $data_disabled = true;

				if($request->tipo == '0')
					$nomes = [NULL => "Nenhum"] + Paciente::lists('nome','id')->all();
				else
					$nomes = [NULL => "Nenhum"] + Fornecedor::lists('nome','id')->all();

				if($request->tipo == '1')
					if($contum->opcao == 'Livro Caixa')
						$opcoes = ['Pessoal' => 'Pessoal', 'Material Médico' => 'Material Médico', 'Material de Custeio' => 'Material de Custeio', 'Marketing/divulgação' => 'Marketing/divulgação', 'Outros' => 'Outros'];
					else
						$opcoes = ['INSS' => 'INSS', 'IRPF' => 'IRPF', 'Despesas Dedutíveis' => 'Despesas Dedutíveis', 'Saúde' => 'Saúde'];
				else
					$opcoes = ['Emissão de Recibo' => 'Emissão de Recibo', 'Aluguel' => 'Aluguel', 'Salário' => 'Salário', 'Convênio' => 'Convênio', 'Pró-labore' => 'Pró-labore', 'Outros' => 'Outros'];

				return view('contas.form', ["contum" => $contum, "nomes" => $nomes, "medicos" => $medicos, "url" => "contas.update", "method" => "put", "tipo" => $request->tipo, 'opcoes' => $opcoes, 'data_disabled' => $data_disabled]);
			}

			/**
			* Update the specified resource in storage.
			*
			* @param  int  $id
			* @param Request $request
			* @return Response
			*/
			public function update(Request $request, $id)
			{
				$contum = Contum::findOrFail($id);
				$contum->date = $request->date;
				$contum->fornecedor = $request->fornecedor;
				$contum->num_doc = $request->num_doc;
				$contum->valor = str_replace(",", ".", str_replace(".", "", $request->valor));
				$contum->descricao = $request->descricao;
				if($request->tipo == '0')
					$contum->paciente_id = $request->nome_id;
				else
					$contum->fornecedor_id = $request->nome_id;
				$contum->tipo_conta = $request->tipo_conta;
				$contum->opcao = $request->opcao;
				$contum->save();

				return redirect()->route('contas.index', ["tipo" => $request->tipo])->with('message', 'Conta atualizada com sucesso!');
			}

			/**
			* Remove the specified resource from storage.
			*
			* @param  int  $id
			* @return Response
			*/
			public function destroy(Request $request, $id)
			{
				$contum = Contum::findOrFail($id);
				$contum->delete();
				return redirect()->route('contas.index', ["tipo" => $request->tipo])->with('message', 'Conta deletada com sucesso!');
			}

			/**
			* Listagem de parcelas.
			*
			* @param Request $request
			* @param int $id da Conta
			* @return Response
			*/
			public function parcelas(Request $request)
			{
				$parametros = [];

				if(isset($request->data1) && isset($request->data2)){
					$data1 = Date::parse($request->data1);
					$data2 = Date::parse($request->data2);
				} else {
					$data1 = Date::now();
					$data2 = Date::now();
				}
				$where = "1=1";
				$where .= " and lancamento between '".$data1->format("Y-m-d")."' and '".$data2->format("Y-m-d")."'";

				if(!blank($request->operacao)) $where .= " and tipo = $request->operacao";
				if(!blank($request->filtro) && !blank($request->valor)){
					if(in_array($request->filtro, ["vencimento","pagamento"])) $valor = Date::createFromFormat('d/m/Y', $request->valor)->format("Y-m-d");
					elseif(in_array($request->filtro, ["valor","desconto"])) $valor = str_replace(",", ".", str_replace(".", "", $request->valor));
					else $valor = $request->valor;

					if(in_array($request->filtro, ["num_doc","descricao"])) $where .= " and $request->filtro LIKE '%$valor%'";
					// elseif($request->filtro == "valor") $where .= " and (valor-desconto) = '$valor'";
					else $where .= " and $request->filtro = '$valor'";
				}

				$parametros["tipo"] = $request->tipo;
				// $parametros["status"] = $status;
				$parametros["data1"] = $data1->format("d/m/Y");
				$parametros["data2"] = $data2->format("d/m/Y");
				$parametros["filtro"] = $request->filtro;
				$parametros["valor"] = $request->valor;
				$parametros["paciente_ids"] = [];
				if(!blank($request->paciente_ids)){
					foreach ($request->paciente_ids as $paciente_id)
					$parametros["paciente_ids"][] = intval($paciente_id);
				}

				// if(!blank($request->pdf)){
					// 	if($request->tipo != "2")
					// 		$where .= " and pai_id IS NULL";
					// 	$parcelas = Parcela::join("contas","contas.id","=","parcelas.conta_id")->selectRaw("parcelas.id,lancamento,STRING_AGG(DATE_FORMAT(vencimento,'%d/%m/%Y'), ', ') as vencimento,pagamento,qtd_parcelas,tipo_user,user_id,descricao,observacao,desconto,contas.pago,tipo_pagamento,conta_id,autor_id,contas.tipo")->whereRaw($where)->groupBy("contas.id")->get();
					// 	$id_contas = [];
					// 	$contas_filhas = [];
					// 	foreach ($parcelas->pluck('conta_id') as $conta_id)
					// 		$id_contas[] = $conta_id;
					// 	foreach (Contum::whereIn("pai_id",$id_contas)->get() as $conta){
						// 		if(!isset($contas_filhas[$conta->pai_id]))
						// 			$contas_filhas[$conta->pai_id] = [];
						// 		$contas_filhas[$conta->pai_id][] = $conta;
						// 	}
						// 	return \PDF::loadView('contas.parcelas_pdf', ["parcelas" => $parcelas, "contas_filhas" => $contas_filhas, "tipo" => $request->tipo, "titulo" => $titulos["$request->tipo-$request->admin"]])->inline();
						// } else {
							$parcelas = Parcela::selectRaw("*,STRING_AGG(id::character varying, ',') as ids")->whereRaw($where)->groupBy('id')->paginate(30);
							// $verificacoes = ParcelaVerificacao::where("data",$data1->format("Y-m-d"))->where("empresa_id",current_empresa()->id)->get()->keyBy('tipo');
							// $nome_verificacoes = ["recepcao" => "Recepção", "financeiro" => "Financeiro", "admin" => "Administrador"];
							return view('contas.parcelas', ["parcelas" => $parcelas, "parametros" => $parametros, "data1" => $data1, "data2" => $data2]);
							// }
						}

						/**
						* Pagar a parcela.
						*
						* @param Request $request
						* @return Response
						*/
						public function pagar(Request $request)
						{
							$parcelas = Parcela::whereIn("id",$request->ids);
							if(isset($request->desfazer)) $parcelas->update(['pago' => false, 'pagamento' => NULL]);
							else $parcelas->update(['pago' => true, 'pagamento' => date("Y-m-d")]);

							if(isset($request->data1) && isset($request->data2)) return redirect()->route('parcelas.index', ["tipo" => $request->tipo, "data1" => $request->data1, "data2" => $request->data2, "paciente_ids" => $request->paciente_ids])->with('message', 'Pagamento realizado com sucesso.')->with('type', 'success');
							else return redirect()->route('contas.edit', ["id" => $parcelas->first()->conta_id, "tipo" => $request->tipo])->with('message', 'Pagamento realizado com sucesso.')->with('type', 'success');
						}

						/**
						* Pagar a parcela.
						*
						* @param Request $request
						* @return Response
						*/
						public function recibo($id)
						{
							$conta = Contum::findOrFail($id);
							return \PDF::loadView('contas.recibo_pdf', ["conta" => $conta, 'titulo' => 'Recibo'])->inline();
						}

						/**
						* Relatório de parcelas por mês.
						*
						* @param Request $request
						* @return Response
						*/
						public function controle(Request $request)
						{
							$medicos = [NULL => "Nenhum"] + Empresa::lists('nome','id')->all();
							$tipos = [NULL => 'Todos', 0 => 'Receita', 1 => 'Despesa'];
							$meses = ['01' => 'Janeiro','02' => 'Fevereiro','03' => 'Março','04' => 'Abril','05' => 'Maio','06' => 'Junho','07' => 'Julho','08' => 'Agosto','09' => 'Setembro','10' => 'Outubro','11' => 'Novembro','12' => 'Dezembro'];

							isset($request->ano) ? $ano = $request->ano : $ano = date('Y');
							if($request->mes) {
								$data1 = Date::parse("$ano-$request->mes-01");
								$data2 = Date::parse("$ano-$request->mes-01")->endOfMonth();
							} else {
								$data1 = Date::parse("$ano-01-01");
								$data2 = Date::parse("$ano-12-31");
							}

							$parcelas = Contum::whereRaw('1=2');
							$medico = NULL;
							if(!blank($request->medico_id)) {
								$medico = Empresa::findOrFail($request->medico_id);
								$parcelas = Contum::whereBetween('date',[$data1,$data2])->where('empresa_id',$request->medico_id);

								if(!blank($request->tipo) && !blank($parcelas))
									$parcelas = $parcelas->where('tipo',$request->tipo);
							}

							if(!blank($request->pdf)){
								$titulo = "Relatório de Controle de Receitas/Despesas";
								$request->tipo == '1' ? $tipo = 'Despesa' : $tipo = 'Receita';
								$cabecalho = ["Período" => $data1->format('d/m/Y')." à ".$data2->format('d/m/Y'), "Tipo" => $tipo, "Médico" => $medico->nome, "Margem Atual" => "R$ ".number_format($medico->margem_atual(),2,',','.')];
								return \PDF::loadView('contas.controle_pdf', ["parcelas" => $parcelas->get(), 'meses' => $meses, "ano" => $ano, 'mes' => $request->mes, 'medicos' => $medicos, 'medico' => $medico, 'tipos' => $tipos, 'tipo' => $request->tipo, 'titulo' => $titulo, 'parametros' => $cabecalho])->inline();
							} else {
								return view('contas.controle', ["parcelas" => $parcelas->paginate(30), 'meses' => $meses, "ano" => $ano, 'mes' => $request->mes, 'medicos' => $medicos, 'medico' => $medico, 'tipos' => $tipos, 'tipo' => $request->tipo]);
							}
						}

}

