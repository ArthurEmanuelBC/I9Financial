<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller {

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
				$fornecedors = Fornecedor::orderByRaw($order)->paginate(30);
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
				if($request->filtro == 'nome')
					$fornecedors = Fornecedor::whereRaw("UPPER(nome) LIKE '%".strtoupper($request->valor)."%'")->orderByRaw($order)->paginate(30);
				else
					$fornecedors = Fornecedor::where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$fornecedors = Fornecedor::orderByRaw($order)->paginate(30);
		return view('fornecedors.index', ["fornecedors" => $fornecedors, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$fornecedor = new Fornecedor();
		return view('fornecedors.form', ["fornecedor" => $fornecedor, "url" => "fornecedors.store", "method" => "post"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$fornecedor = new Fornecedor();
		$fornecedor->nome = $request->input("nome");
        $fornecedor->cnpj = $request->input("cnpj");
		$fornecedor->save();
		return redirect()->route('fornecedors.index')->with('message', 'Fornecedor cadastrado com sucesso!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$fornecedor = Fornecedor::findOrFail($id);
		return view('fornecedors.form', ["fornecedor" => $fornecedor, "url" => "fornecedors.update", "method" => "put"]);
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
		$fornecedor = Fornecedor::findOrFail($id);
		$fornecedor->nome = $request->input("nome");
        $fornecedor->cnpj = $request->input("cnpj");
		$fornecedor->save();
		return redirect()->route('fornecedors.index')->with('message', 'Fornecedor atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$fornecedor = Fornecedor::findOrFail($id);
		$fornecedor->delete();
		return redirect()->route('fornecedors.index')->with('message', 'Fornecedor deletado com sucesso!');
	}

}
