<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;

class ContatoController extends Controller
{
    //GET
    public function index(Request $request)
    {
        // Captura o nome digitado na pesquisa
        $busca = $request->input('busca');

        // Busca os contatos pelo nome, se houver pesquisa
        $contatos = Contato::query()
            ->when($busca, function ($query, $busca) {
                $query->where('nome', 'LIKE', '%' . $busca . '%');
                
            })

            ->orderBy('nome', 'asc')
            ->get();

        // Envia os contatos e a pesquisa para a view
        return view('contatos', [
            'contatos' => $contatos,
            'busca' => $busca
        ]);
        // //Model pega os dados do banco e traz
        // $contatos = Contato::all();
        // //Retorna os dados em formato JSON
        // // return response()->json($contatos);

        // //Envia valores para a view
        // return view('contatos',['contatos' => $contatos]);

    }

    //POST
    public function form(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'endereco' => 'required|string|max:255',
         ], [
            // mensgem personalizadas de validação
            'nome.required' => 'O nome é Obrigatório',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres',
            'email.required' => 'O e-mail é Obrigatório',
            'email.email' => 'Digite um email Válido',
            'telefone.required' => 'O telefone é obrigatório',
            'endereco.required' => 'O endereço é obrigatório'

         ]);
        $contato = new Contato();
        $contato->nome = $request->input('nome');
        $contato->telefone = $request->input('telefone');
        $contato->email = $request->input('email');
        $contato->endereco = $request->input('endereco');
        $contato->save();// salva no banco de dados
        return redirect('/')->with('sucesso', 'Contato atualizado com sucesso!'); // redireciona para a página inicial
    }

     //DELETE: remove o registro no banco de dados
    public function delete($id)
    {
        //Busca o contato pelo id
        $contato = Contato::find($id);

        if($contato){
            //Executa o comando de exclusão no banco
            $contato->delete();
        }

        return redirect('/')->with('sucesso', 'Contato excluído com sucesso!'); //retorna a home
    }

    public function edit($id)
    {
        //Busca o contato pelo id
        $contato = Contato::find($id);

        //Abre a view de edição com o registro buscado
        return view('edit', ['contato' => $contato]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'endereco' => 'required|string|max:255',
        ]);
        //Busca o contato pelo id
        $contato = Contato::find($id);
        $contato->nome = $request->input('nome');
        $contato->telefone = $request->input('telefone');
        $contato->email = $request->input('email');
        $contato->endereco = $request->input('endereco');
        $contato->save();

        return redirect('/')->with('sucesso', 'Contato salvo com sucesso!');
    }



}
