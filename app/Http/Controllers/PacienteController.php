<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Paciente;
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
				$pacientes = Paciente::where($request->filtro, $valor)->orderByRaw($order)->paginate(30);
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
        $paciente->email = $request->input("email");
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
		$paciente = Paciente::findOrFail($id);
		$paciente->nome = $request->input("nome");
        $paciente->cpf = $request->input("cpf");
        $paciente->email = $request->input("email");
		$paciente->save();
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
		return redirect()->route('pacientes.index')->with('message', 'Paciente deletado com sucesso!');
	}

}
