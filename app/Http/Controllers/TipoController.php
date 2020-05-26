<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tipo;
use Illuminate\Http\Request;

use Auth;

class TipoController extends Controller {

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
				$tipos = Tipo::where('grupo_id', Auth::user()->grupo_id)->orderByRaw($order)->paginate(30);
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
				$tipos = Tipo::where('grupo_id', Auth::user()->grupo_id)->where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$tipos = Tipo::where('grupo_id', Auth::user()->grupo_id)->orderByRaw($order)->paginate(30);
		return view('tipos.index', ["tipos" => $tipos, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipo = new Tipo();
		return view('tipos.form', ["tipo" => $tipo, "url" => "tipos.store", "method" => "post"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$tipo = new Tipo();
		$tipo->nome = $request->input("nome");
		$tipo->tipo = $request->input("tipo");
		if($tipo->tipo == '1')
			$tipo->opcao = $request->input("opcao");
		$tipo->perfil = $request->input("perfil");
		$tipo->grupo_id = Auth::user()->grupo_id;
		$tipo->save();
		return redirect()->route('tipos.index')->with('message', 'Tipo cadastrado com sucesso!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipo = Tipo::findOrFail($id);
		return view('tipos.form', ["tipo" => $tipo, "url" => "tipos.update", "method" => "put"]);
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
		$tipo = Tipo::findOrFail($id);
		$tipo->nome = $request->input("nome");
		$tipo->tipo = $request->input("tipo");
		$tipo->opcao = $request->input("opcao");
		$tipo->perfil = $request->input("perfil");

		if($tipo->tipo == '0')
			$tipo->opcao = null;
		$tipo->save();
		return redirect()->route('tipos.index')->with('message', 'Tipo atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tipo = Tipo::findOrFail($id);
		$tipo->delete();
		return redirect()->route('tipos.index')->with('message', 'Tipo deletado com sucesso!');
	}

	/**
	 * Return the tipos from despesa by opcao.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function find_by_opcao(Request $request)
	{
		$tipos = Tipo::where('perfil', Auth::user()->permissao)->where('tipo', true)->where('opcao', $request->opcao)->get();
		return response()->json($tipos);
	}
}