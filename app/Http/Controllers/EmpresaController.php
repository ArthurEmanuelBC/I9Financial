<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Empresa;
use Illuminate\Http\Request;

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
				$empresas = Empresa::orderByRaw($order)->paginate(30);
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
				$empresas = Empresa::where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$empresas = Empresa::orderByRaw($order)->paginate(30);
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
        $empresa->tipo = $request->input("tipo");
        $empresa->cnpj = $request->input("cnpj");
        $empresa->cep = $request->input("cep");
        $empresa->logradouro = $request->input("logradouro");
        $empresa->bairro = $request->input("bairro");
        $empresa->cidade = $request->input("cidade");
        $empresa->estado = $request->input("estado");
        $empresa->numero = $request->input("numero");
        $empresa->complemento = $request->input("complemento");
		$empresa->save();
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
        $empresa->tipo = $request->input("tipo");
        $empresa->cnpj = $request->input("cnpj");
        $empresa->cep = $request->input("cep");
        $empresa->logradouro = $request->input("logradouro");
        $empresa->bairro = $request->input("bairro");
        $empresa->cidade = $request->input("cidade");
        $empresa->estado = $request->input("estado");
        $empresa->numero = $request->input("numero");
        $empresa->complemento = $request->input("complemento");
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
		$empresa->delete();
		return redirect()->route('empresas.index')->with('message', 'Empresa deletado com sucesso!');
	}

}
