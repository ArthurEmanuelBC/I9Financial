<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserPermission;
use App\Grupo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;

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
        $where = '1 = 1';

        if(Auth::user()->permissao != 'Master')
			$where .= ' and grupo_id = '.Auth::user()->grupo_id;

        if(isset($request->filtro))
            if(blank($request->valor))
                $request->valor = NULL;
            else
                if(strpos($request->filtro,"nome"))
                    $where .= " and $request->filtro LIKE '%$request->valor%'";
                else
                    $where .= " and $request->filtro = '$request->valor'";

        $users = User::whereRaw($where)->orderByRaw($order)->paginate(30);
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

        if(blank($request->grupo)){
            $grupo = Auth::user()->grupo();
        } else {
            if(isset($request->grupo_nome))
                $grupo_nome = $request->grupo_nome;
            else
                $grupo_nome = "Grupo de $request->name";

            $grupo = Grupo::create(['nome' => $grupo_nome]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->permissao = $request->permissao;
        $user->password = bcrypt('I9livrocaixa');
        $user->grupo_id = $grupo->id;
        $user->save();
        // if(!blank($request->grupo)){
        //     $this->enviarEmailCadastro($user);
        //     return redirect()->with('message', 'Obrigado pelo cadastro. Você receberá um email indicando os próximos passos!');
        // } else {
            return redirect()->route('users.index')->with('message', 'Usuário cadastrado com sucesso!');
        // }
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

    private function enviarEmailCadastro(User $user)
    {
        Mail::send('emails.payment_link', ['user' => $user], function ($message) use ($user) {
            $message->from('arthuzinho.brandao@gmail.com', 'Livro Caixa Inteligente');
            $message->to($user->email)->subject('Cadastro concluído!');
        });
    }
}
