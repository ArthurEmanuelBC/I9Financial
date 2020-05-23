<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserPermission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserController extends Controller
{
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
                $users = User::where('grupo_id', Auth::user()->grupo_id)->paginate(30);
            }
            else{
                if(strpos($request->filtro,"nome"))
                    $users = User::where('grupo_id', Auth::user()->grupo_id)->where($request->filtro, 'LIKE', "%$request->valor%")->orderByRaw($order)->paginate(30);
                else
                    $users = User::where('grupo_id', Auth::user()->grupo_id)->where($request->filtro, $request->valor)->orderByRaw($order)->paginate(30);
            }
        }
        else
            $users = User::where('grupo_id', Auth::user()->grupo_id)->paginate(30);
        return view('users.index', ["users" => $users, "filtro" => $request->filtro, "valor" => $request->valor, "signal" => $signal, "param" => $param, "caret" => $caret]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = new User();
        return view('users.form', ["user" => $user, "url" => "users.store", "method" => "post", "permit" => true, "config" => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validar($request, 'store');
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->permissao = $request->permissao;
        $user->password = bcrypt($request->password);
        $user->grupo = Auth::user()->grupo_id;
        $user->save();
        return redirect()->route('users.index')->with('message', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        (is_null($request->config)) ? $config = false : $config = true;
        return view('users.form', ["user" => $user, "url" => "users.update", "method" => "put", "config" => $config]);
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
        $this->validar($request, 'update');
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->permissao = $request->permissao;
        if($request->alterar_credenciais == "true"){
            if(Hash::check($request->password_antigo,$user->password) && $request->password == $request->password_confirmation && !User::where("email",$request->email)->where("id","!=",$user->id)->count()){
                $user->password = bcrypt($request->password);
            }
        }
        $user->save();
        return redirect()->route('users.index')->with('message', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('message', 'Usuário deletado com sucesso!');
    }

    /**
     * Get the OrdemHistorico from the specified resource.
     *
     * @return Response
     */
    public function verificar_senha(Request $request)
    {
        if(Hash::check($request->password,Auth::user()->password))
            return "true";
        else
            return "false";
    }

    /**
     * Get the OrdemHistorico from the specified resource.
     *
     * @return Response
     */
    public function verificar_login(Request $request)
    {
        if($request->method == "post"){
            if(User::where("login",$request->login)->count() || blank($request->login))
                return "false";
            else
                return "true";
        } else {
            if(User::where("login",$request->login)->where("id","!=",Auth::user()->id)->count() || blank($request->login))
                return "false";
            else
                return "true";
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validar(Request $request, $tipo)
    {
        if($tipo == "update")
            return $this->validate($request, [
                'name' => 'required|max:255',
                // 'email' => 'required|email|max:255',
            ]);
        else
            return $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|max:255|unique:users',
            ]);
    }
}
