<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contum;
use App\Empresa;
use App\Parcela;
use App\Paciente;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use Auth;

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
		// $where = "empresa_id = ".current_empresa()->id." and tipo = $request->tipo";
		$where = "tipo = ".($request->tipo ? 'true' : 'false');
		if(blank($request->tipo_relatorio)) $request->tipo_relatorio = "0";
		if(blank($request->tipo_data)){
			$where .= " and date = CURRENT_DATE";
		} else {
			$data1 = Date::parse($request->data1);
			$data2 = Date::parse($request->data2);
			$where .= " and $request->tipo_data between '$data1' and '$data2'";
		}
		(isset($request->ocultas)) ? $ocultas = $request->ocultas : $ocultas = [];
		
		$ids = [];
		if(!blank($request->filtro) && !blank($request->valor)){
			foreach ($request->filtro_avancado as $key => $filtro) {
				$tipo = $request->tipo_avancado[$key];
				$valor = $request->valor_avancado[$key];

				if(in_array($filtro, ["tipo_pagamento","descricao"])) $tipo = 'like';
				if($tipo == 'like') $valor = "%$valor%";
				
				if($filtro == "total") {
					$valor = str_replace(",", ".", str_replace(".", "", $valor));
					$where .= " and valor-desconto $tipo $valor";
				} else {
					$where .= " and UPPER($filtro) $tipo '".strtoupper($valor)."'";
				}
			}

			if($request->tipo_relatorio == "1") $contas = Contum::join("parcelas","parcelas.conta_id","=","contas.id")->selectRaw("parcelas.id, lancamento, vencimento, pagamento, recebimento, tipo_pagamento, num_doc, qtd_parcelas, parcelas.valor as total, descricao")->whereRaw($where)->get()->keyBy("id")->toArray();
			else $contas = Contum::selectRaw("contas.id, date as lancamento, tipo_pagamento, num_doc, qtd_parcelas, valor-desconto as total, descricao")->whereRaw($where)->get()->keyBy("id")->toArray();
			
			// foreach ($contas as $id => $conta) {
			// 	foreach ($request->filtro_avancado as $key => $filtro) {
			// 		switch ($request->filtro_avancado[$key]) {
			// 			case 'total':
			// 			if($request->tipo_avancado[$key] == ">"){
			// 				if(floatval($conta[$filtro]) <= floatval(str_replace(",", ".", str_replace(".", "", $request->valor_avancado[$key])))) $ids[] = $id;
			// 			} elseif($request->tipo_avancado[$key] == "<"){
			// 				if(floatval($conta[$filtro]) >= floatval(str_replace(",", ".", str_replace(".", "", $request->valor_avancado[$key])))) $ids[] = $id;
			// 			} else {
			// 				if(abs(floatval($conta[$filtro]) - floatval(str_replace(",", ".", str_replace(".", "", $request->valor_avancado[$key])))) > 0.01) $ids[] = $id;
			// 			}
			// 			break;
						
			// 			default:
			// 			if($request->tipo_avancado[$key] == "="){
			// 				if(strtoupper($conta[$filtro]) != strtoupper($request->valor_avancado[$key]))
			// 				$ids[] = $id;
			// 			} else {
			// 				if(strpos(strtoupper($conta[$filtro]), strtoupper($request->valor_avancado[$key])) === false)
			// 				$ids[] = $id;
			// 			}
			// 			break;
			// 		}
			// 	}
			// }
		}

		$ids = array_unique($ids);
		
		if(empty($ids)){
			if($request->tipo_relatorio == "1") $contas = Contum::join("parcelas","parcelas.conta_id","=","contas.id")->selectRaw("contas.id, lancamento, vencimento, pagamento, recebimento, tipo_pagamento, num_doc, qtd_parcelas, parcelas.valor as total, descricao, parcelas.pago, cartao, pai_id")->whereRaw($where)->orderBy("lancamento","DESC");
			else $contas = Contum::selectRaw("contas.id, date as lancamento, tipo_pagamento, num_doc, qtd_parcelas, valor-desconto as total, descricao, cartao, pai_id")->whereRaw($where)->orderBy("date","DESC");
		} else {
			if($request->tipo_relatorio == "1") $contas = Contum::join("parcelas","parcelas.conta_id","=","contas.id")->selectRaw("contas.id, lancamento, vencimento, pagamento, recebimento, tipo_pagamento, num_doc, qtd_parcelas, parcelas.valor as total, descricao, parcelas.pago, cartao, pai_id")->whereRaw("$where and parcelas.id NOT IN (".join(",",$ids).")")->orderBy("lancamento","DESC");
			else $contas = Contum::selectRaw("contas.id, date as lancamento, tipo_pagamento, num_doc, qtd_parcelas, valor-desconto as total, descricao, cartao, pai_id")->whereRaw("$where and contas.id NOT IN (".join(",",$ids).")")->orderBy("date","DESC");
		}
		
		$parametros = [];
		$parametros["tipo"] = $request->tipo;
		$parametros["tipo_relatorio"] = $request->tipo_relatorio;
		(isset($request->data1)) ? $parametros["data1"] = $request->data1 : $parametros["data1"] = Date::now();
		(isset($request->data2)) ? $parametros["data2"] = $request->data2 : $parametros["data2"] = Date::now();
		$parametros["filtro"] = $request->filtro;
		$parametros["valor"] = $request->valor;
		$parametros["filtro_avancado"] = $request->filtro_avancado;
		$parametros["tipo_avancado"] = $request->tipo_avancado;
		$parametros["valor_avancado"] = $request->valor_avancado;
		
		// if(isset($request->pdf)){
			// 	($request->tipo == "0") ? $titulo = "Contas a Receber" : $titulo = "Contas a Pagar";
			// 	return \PDF::loadView('contas.index_pdf', ["contas" => $contas->get(), "tipo" => $request->tipo, "tipo_relatorio" => $request->tipo_relatorio, "ocultas" => $ocultas, 'titulo' => $titulo])->inline();
			// } else {
				return view('contas.index', ["contas" => $contas->paginate(30), "parametros" => $parametros, "tipo" => $request->tipo]);
				// }
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
				$contum->qtd_parcelas = 1;
				$contum->desconto = 0;
				$pacientes = [NULL => "Nenhum"] + Paciente::lists('nome','id')->all();
				return view('contas.form', ["contum" => $contum, "pacientes" => $pacientes, "url" => "contas.store", "method" => "post", "tipo" => $request->tipo]);
			}
			
			/**
			* Store a newly created resource in storage.
			*
			* @param Request $request
			* @return Response
			*/
			public function store(Request $request)
			{
				$pai_id = NULL;
				foreach ($request->date as $key => $value) {
					$contum = new Contum();
					$contum->date = Date::parse($request->date[$key]);
					$contum->tipo_pagamento = $request->tipo_pagamento[$key];
					$contum->num_doc = $request->num_doc;
					$contum->qtd_parcelas = $request->qtd_parcelas[$key];
					$contum->cartao = $request->cartao[$key];
					$contum->valor = str_replace(",", ".", str_replace(".", "", $request->valor));
					if($key == 0) $contum->desconto = str_replace(",", ".", str_replace(".", "", $request->desconto));
					else $contum->desconto = 0;
					$contum->pago = str_replace(",", ".", str_replace(".", "", $request->pago[$key]));
					$contum->descricao = $request->descricao;
					$contum->tipo = $request->tipo;
					$contum->morto = 0;
					$contum->user_id = Auth::user()->id;
					$contum->paciente_id = $request->paciente_id;
					if(!is_null($pai_id)) $contum->pai_id = $pai_id;
					$contum->empresa_id = Empresa::first()->id;
					$contum->save();
					
					if($key == 0) $pai_id = $contum->id;
					
					// Parcelas
					if(!isset($request->qtd_parcelas[$key])) $request->qtd_parcelas = 1;
					$vencimento = new Date($contum->date);
					foreach (range(1,$request->qtd_parcelas[$key]) as $num_parcela) {
						if($contum->tipo_pagamento == "Crédito"){
							$vencimento->addMonths(1);
						} elseif ($contum->tipo_pagamento == "Débito") {
							$vencimento->addDays(1);
						} elseif (in_array($contum->tipo_pagamento, ["Boleto","Cheque Pré-Datado"])) {
							$vencimento = Date::createFromFormat('d/m/Y', $request->vencimento[$key][$num_parcela-1]);
						}
						
						if(in_array($contum->tipo_pagamento, ["Boleto","Cheque Pré-Datado"]))
						$valor_parcela = str_replace(",", ".", str_replace(".","", $request->parcela_valor[$key][$num_parcela-1]));
						else
						$valor_parcela = $contum->pago/$request->qtd_parcelas[$key];
						
						$parcela = new Parcela();
						$parcela->lancamento = $contum->date;
						$parcela->vencimento = $vencimento;
						$parcela->valor = $valor_parcela;
						$parcela->conta_id = $contum->id;
						$parcela->save();
					}
				}
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
				$pacientes = [NULL => "Nenhum"] + Paciente::lists('nome','id')->all();
				return view('contas.form', ["contum" => $contum, "pacientes" => $pacientes, "url" => "contas.update", "method" => "put", "tipo" => $request->tipo]);
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
				foreach ($request->date as $key => $value) {
					($key == 0) ? $conta_id = $id : $conta_id = $request->ids[$key];
					$contum = Contum::findOrFail($conta_id);
					$contum->date = $request->date[$key];
					$contum->tipo_pagamento = $request->tipo_pagamento[$key];
					$contum->num_doc = $request->num_doc;
					$contum->qtd_parcelas = $request->qtd_parcelas[$key];
					$contum->valor = str_replace(",", ".", str_replace(".", "", $request->valor));
					if($key == 0) $contum->desconto = str_replace(",", ".", str_replace(".", "", $request->desconto));
					else $contum->desconto = 0;
					$contum->pago = str_replace(",", ".", str_replace(".", "", $request->pago[$key]));
					$contum->descricao = $request->descricao;
					// $contum->morto = false;
					$contum->save();
					
					// Parcelas
					$contum->parcelas()->delete();
					if(!isset($request->qtd_parcelas[$key])) $request->qtd_parcelas = 1;
					$vencimento = new Date($contum->date);
					foreach (range(1,$request->qtd_parcelas[$key]) as $num_parcela) {
						if(in_array($contum->tipo_pagamento, ["Crédito","Cheque"])){
							$vencimento->addMonths(1);
						} elseif ($contum->tipo_pagamento == "Débito") {
							$vencimento->addDays(1);
						} elseif (in_array($contum->tipo_pagamento, ["Boleto","Cheque Pré-Datado"])) {
							$vencimento = Date::createFromFormat('d/m/Y', $request->vencimento[$key][$num_parcela-1]);
						}
						
						if(in_array($contum->tipo_pagamento, ["Boleto","Cheque Pré-Datado"]))
						$valor_parcela = str_replace(",", ".", str_replace(".","", $request->parcela_valor[$key][$num_parcela-1]));
						else
						$valor_parcela = $contum->pago/$request->qtd_parcelas[$key];
						
						$parcela = new Parcela();
						$parcela->lancamento = $contum->date;
						$parcela->vencimento = $vencimento;
						$parcela->valor = $valor_parcela;
						$parcela->conta_id = $contum->id;
						$parcela->save();
					}
				}
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
				$contum->parcelas()->delete();
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
		
}

					