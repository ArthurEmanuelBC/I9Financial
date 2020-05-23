<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Empresa;
use Illuminate\Http\Request;

use Storage;
use Auth;

class EmpresaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		(strpos($request->fullUrl(),'order=')) ? $param = $request->order : $param = null;
		(strpos($request->fullUrl(),'?')) ? $signal = '&' : $signal = '?';
		(strpos($param,'desc')) ? $caret = 'up' : $caret = 'down';
		(isset($request->order)) ? $order = $request->order : $order = "id";
		if(isset($request->filtro)){
			if($request->filtro == "Limpar"){
				$request->valor = NULL;
				$empresas = Empresa::where('grupo_id', Auth::user()->grupo_id)->orderByRaw($order)->paginate(30);
			}
			else{
				switch ($request->filtro) {
					case 'data':
					$valor = date_format(date_create_from_format('d/m/Y', $request->valor), 'Y-m-d');
					break;
					case 'valor':
					$valor = str_replace(",", ".", str_replace(".", "", $request->valor));
					break;
					default:
					$valor = $request->valor;
					break;
				}
				$empresas = Empresa::where('grupo_id', Auth::user()->grupo_id)->where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$empresas = Empresa::where('grupo_id', Auth::user()->grupo_id)->orderByRaw($order)->paginate(30);
		return view('empresas.index', ["empresas" => $empresas, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$empresa = new Empresa();
		return view('empresas.form', ["empresa" => $empresa, "url" => "empresas.store", "method" => "post"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$empresa = new Empresa();
		$empresa->nome = $request->input("nome");
		$empresa->cpf = $request->input("cpf");
		$empresa->crm = $request->input("crm");
    $empresa->cep = $request->input("cep");
    $empresa->logradouro = $request->input("logradouro");
    $empresa->bairro = $request->input("bairro");
    $empresa->cidade = $request->input("cidade");
    $empresa->estado = $request->input("estado");
    $empresa->numero = $request->input("numero");
		$empresa->complemento = $request->input("complemento");
		$empresa->telefone = $request->input("telefone");
		$empresa->margem = str_replace(",", ".", str_replace(".", "", $request->margem));
		$empresa->grupo = Auth::user()->grupo_id;
		$empresa->save();

		if(!is_null($request->file('anexo'))){
			$empresa->anexo = $request->file('anexo')->getClientOriginalName();
			Storage::put("empresas/$empresa->id/".$request->file('anexo')->getClientOriginalName(), file_get_contents($request->file('anexo')->getRealPath()));
			$empresa->save();
		}

		return redirect()->route('empresas.index')->with('message', 'Empresa cadastrado com sucesso!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$empresa = Empresa::findOrFail($id);
		return view('empresas.form', ["empresa" => $empresa, "url" => "empresas.update", "method" => "put"]);
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
		$empresa = Empresa::findOrFail($id);
		$empresa->nome = $request->input("nome");
		$empresa->cpf = $request->input("cpf");
		$empresa->crm = $request->input("crm");
    $empresa->cep = $request->input("cep");
    $empresa->logradouro = $request->input("logradouro");
    $empresa->bairro = $request->input("bairro");
    $empresa->cidade = $request->input("cidade");
    $empresa->estado = $request->input("estado");
    $empresa->numero = $request->input("numero");
		$empresa->complemento = $request->input("complemento");
		$empresa->telefone = $request->input("telefone");
		$empresa->margem = str_replace(",", ".", str_replace(".", "", $request->margem));

		if(!is_null($request->file('anexo'))){
			Storage::delete("empresas/$empresa->id/$empresa->anexo");
			$empresa->anexo = $request->file('anexo')->getClientOriginalName();
			Storage::put("empresas/$empresa->id/".$request->file('anexo')->getClientOriginalName(), file_get_contents($request->file('anexo')->getRealPath()));
		}

		$empresa->save();
		return redirect()->route('empresas.index')->with('message', 'Empresa atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$empresa = Empresa::findOrFail($id);
		Storage::delete("empresas/$empresa->id/$empresa->anexo");
		$empresa->delete();
		return redirect()->route('empresas.index')->with('message', 'Empresa deletado com sucesso!');
	}

	/**
	 * Verifica a margem de um médico.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function margem($id)
	{
		$medico = Empresa::findOrFail($id);
		return $medico->margem_atual();
	}

}
