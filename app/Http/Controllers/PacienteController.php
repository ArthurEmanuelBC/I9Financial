<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Paciente;
use App\Pagador;
use Illuminate\Http\Request;

class PacienteController extends Controller {

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
				$pacientes = Paciente::orderByRaw($order)->paginate(30);
			}
			else{
				if($request->filtro == 'nome')
					$pacientes = Paciente::whereRaw("UPPER(nome) LIKE '%".strtoupper($request->valor)."%'")->orderByRaw($order)->paginate(30);
				else
					$pacientes = Paciente::where($request->filtro, $request->valor)->orderByRaw($order)->paginate(30);
			}
		}
		else
			$pacientes = Paciente::orderByRaw($order)->paginate(30);
		return view('pacientes.index', ["pacientes" => $pacientes, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$paciente = new Paciente();
		return view('pacientes.form', ["paciente" => $paciente, "url" => "pacientes.store", "method" => "post"]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$paciente = new Paciente();
		$paciente->nome = $request->input("nome");
		$paciente->cpf = $request->input("cpf");
		if($request->pagador) {
			$pagador = Pagador::create(['nome' => $request->pagador_nome, 'cpf' => $request->pagador_cpf]);
			$paciente->pagador_id = $pagador->id;
		}
		$paciente->save();
		return redirect()->route('pacientes.index')->with('message', 'Paciente cadastrado com sucesso!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$paciente = Paciente::findOrFail($id);
		return view('pacientes.form', ["paciente" => $paciente, "url" => "pacientes.update", "method" => "put"]);
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
		$pagador = null;
		$paciente = Paciente::findOrFail($id);

		if($paciente->pagador_id)
			$pagador = Pagador::find($paciente->pagador_id);

		$paciente->nome = $request->input("nome");
		$paciente->cpf = $request->input("cpf");
		$paciente->pagador_id = null;
		$paciente->save();

		if($pagador)
			$pagador->delete();

		if($request->pagador) {
			$pagador = Pagador::create(['nome' => $request->pagador_nome, 'cpf' => $request->pagador_cpf]);
			$paciente->update(['pagador_id' => $pagador->id]);
		}

		return redirect()->route('pacientes.index')->with('message', 'Paciente atualizado com sucesso!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$paciente = Paciente::findOrFail($id);
		$paciente->delete();

		if($paciente->pagador_id)
			Pagador::find($paciente->pagador_id)->delete();

		return redirect()->route('pacientes.index')->with('message', 'Paciente deletado com sucesso!');
	}

}
