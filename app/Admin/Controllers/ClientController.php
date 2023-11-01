<?php

namespace App\Admin\Controllers;

use \App\Models\Client;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class ClientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Cliente';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    public function listClient()
    {
        $contacts = Client::all();
        $columnMapping = (new Client())->columnMapping;

        return view('table', compact('contacts', 'columnMapping'));
    }


    public function testeClient()
    {
        $contacts = Client::all();
        return response()->json($contacts);
    }

    protected function grid()
    {
        $grid = new Grid(new Client());
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(view('tabs'));
        });

        $script = <<<'SCRIPT'
        <script>
            var tabs = document.getElementById('tabs');
            var appDiv = document.getElementById('app');
            appDiv.insertBefore(tabs, appDiv.children[2]);
        </script>
    SCRIPT;

        $grid->tools(function (Grid\Tools $tools) use ($script) {
            $tools->append($script);
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));



        return $grid;
    }
    /**
     * Make a show builder.
     *
     * @param mixed $id;
     */
    protected function detail($id)
    {
        $show = Client::findOrFail($id);
        return response()->json($show, 200);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Client());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->phonenumber('phone', __('Phone'));

        return $form;
    }

    public function delete($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }

    public function save(Request $request)
    {
        // Valide os dados recebidos do formulário, por exemplo:
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        // Crie um novo cliente com os dados validados
        $client = new Client();
        $client->name = $validatedData['name'];
        $client->email = $validatedData['email'];
        $client->phone = $validatedData['phone'];
        $client->save();

        return response()->json(['message' => 'Cliente criado com sucesso']);
    }

    public function updateClient(Request $request, $id)
    {
        // Find the client by ID
        $client = Client::find($id);

        // Check if client exists
        if (!$client) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        // Update the client details with validated data
        $client->name = $validatedData['name'];
        $client->email = $validatedData['email'];
        $client->phone = $validatedData['phone'];
        $client->save();

        return response()->json(['message' => 'Cliente atualizado com sucesso']);
    }

}