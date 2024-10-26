<?php

namespace App\Http\Controllers;

use App\Models\Database;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $databases = Database::where('user_id', Auth::id())->get();
        return view('database.index',compact('databases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            '_token' => 'required|string',
            'nome_tabela' => 'required|string',
            'colunas' => 'required|array',
            'colunas.*.nome' => 'required|string',
            'colunas.*.tipo' => 'required|string|in:string,integer,text', // Adicione outros tipos conforme necessário
        ]);

        $database = new Database;
        $database->uuid = Uuid::uuid4()->toString();
        $database->user_id = Auth::user()->id;
        $database->name = $request->input('nome_tabela');
        $database->payload = json_encode($request->input('colunas'),true);

        $database->save();

        $nomeTabela = $database->uuid;
        $colunas = $request->input('colunas');

        // Criar a tabela dinamicamente
        Schema::create($nomeTabela, function (Blueprint $table) use ($colunas) {
            $table->id(); // Adiciona uma coluna id

            foreach ($colunas as $coluna) {
                $tipo = $coluna['tipo'];
                $nome = $coluna['nome'];

                // Adiciona a coluna com o tipo correspondente
                if ($tipo == 'string') {
                    $table->string($nome);
                } elseif ($tipo == 'integer') {
                    $table->integer($nome);
                } elseif ($tipo == 'text') {
                    $table->text($nome);
                }
            }

            $table->timestamps(); // Adiciona created_at e updated_at
        });

        return redirect()->back()->with('success', 'Database criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Database $database)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $dados = DB::table($request->database)->get();
        $columns = Schema::getColumnListing($request->database);
        $database = $request->database;

        return view('database.edit', compact('dados', 'columns', 'database'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Database $database)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $tabela = $request->database;

        // Verifica se a tabela existe
        if (!Schema::hasTable($tabela)) {
            return response()->json(['error' => 'Tabela não encontrada.'], 404);
        }

        DB::statement("DROP TABLE `{$tabela}`");

        Database::where('uuid',$tabela)->delete();

        return redirect()->back()->with('success', 'Database deletado com sucesso!');
    }

    public function query (Request $request)
    {
        $database = Database::where('uuid',$request->database)->first();

        if($database){
            $user = User::where('id',$database->user_id)->first();

            $pass = [
                'password' => $user->password,
                'pass'=>$request->pass
            ];

            if ($this->validarUser($pass)) {
                try{
                    $query = DB::table($database->uuid)
                        ->where($request->column, $request->value)
                        ->first();
                    if($query){
                        $query->error=false;
                        $query->message='Sucesso';
                        return response()->json($query);
                    }
                    $return_naoencontrado = $this->getNullStructure($database->uuid);
                    $return_naoencontrado['error']=true;
                    $return_naoencontrado['message']='Nenhum registro encontrado';
                    return response()->json($return_naoencontrado);

                }catch (\Exception $e){
                    return response()->json($this->getNullStructure($database->uuid));
                }

            }
        }
        return response()->json(['message'=>'Database não existe'],500);

    }

    private function getNullStructure($tableName)
    {
        // Obter a lista de colunas da tabela
        $columns = Schema::getColumnListing($tableName);
        $nullStructure = [];

        // Construir a estrutura com valores nulos
        foreach ($columns as $column) {
            $nullStructure[$column] = null;
        }

        // Retornar a estrutura como um array
        return $nullStructure;
    }

    private function validarUser (Array $pass)
    {
        return Hash::check($pass['pass'], $pass['password']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        // Armazena o arquivo
        $path = $request->file('arquivo')->store('uploads');
        $fullPath = str_replace('\\', '/', storage_path('app/private/' . $path));

        // Lê o cabeçalho do arquivo CSV
        $fileHandle = fopen($fullPath, 'r');
        if ($fileHandle === false) {
            return back()->withErrors(['arquivo' => 'Erro ao abrir o arquivo.']);
        }

        // Lê a primeira linha (cabeçalho)
        $csvHeader = fgetcsv($fileHandle,0,';');
        fclose($fileHandle);

        // Obtém o cabeçalho da tabela
        $tableColumns = Schema::getColumnListing($request->database);

        // Ignora a primeira e as duas últimas colunas
        $columnsToImport = array_slice($tableColumns, 1, count($tableColumns) - 3);


        // Verifica se o número de colunas corresponde
        if (count($csvHeader) < count($columnsToImport)) {
            return back()->withErrors(['arquivo' => 'O cabeçalho do CSV não corresponde ao cabeçalho da tabela.']);
        }

        // Se os cabeçalhos corresponderem, carregue os dados
        $columnsList = implode(',', array_merge($columnsToImport, ['created_at', 'updated_at']));

        DB::statement("LOAD DATA LOCAL INFILE '{$fullPath}'
               INTO TABLE `{$request->database}`
               FIELDS TERMINATED BY ';'
               ENCLOSED BY '\"'
               LINES TERMINATED BY '\n'
               IGNORE 1 ROWS
               ({$columnsList})
               SET created_at = NOW(),
                   updated_at = NOW()");

        return back()->with('success', 'Dados carregados com sucesso!');
    }

    public function exportar(Request $request)
    {
        $tabela = $request->database;

        // Verifica se a tabela existe
        if (!Schema::hasTable($tabela)) {
            return response()->json(['error' => 'Tabela não encontrada.'], 404);
        }

        // Cria uma resposta transmitida para o download
        $response = new StreamedResponse(function () use ($tabela) {
            $handle = fopen('php://output', 'w');

            // Escreve o cabeçalho do CSV
            fputcsv($handle, DB::getSchemaBuilder()->getColumnListing($tabela),';');

            // Extrai os dados da tabela
            $dados = DB::table($tabela)->get();

            foreach ($dados as $linha) {
                fputcsv($handle, (array) $linha,';');
            }

            fclose($handle);
        });

        // Define os headers para o download
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $tabela . '.csv"');

        return $response;
    }

    public function truncate(Request $request)
    {
        $tabela = $request->database;

        // Verifica se a tabela existe
        if (!Schema::hasTable($tabela)) {
            return response()->json(['error' => 'Tabela não encontrada.'], 404);
        }

        DB::statement("TRUNCATE TABLE `{$tabela}`");

        return redirect()->back()->with('success', 'Registros eliminado do database com sucesso!');
    }
}
