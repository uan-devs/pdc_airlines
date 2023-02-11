<?php

use App\Http\Controllers\VooController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// PDC-Member routes

Route::get('/', function () {
    return response('Olá Mundo', 200, []);
});

Route::prefix('member')->group(function () {
    Route::get('/', function () {
        $membro = DB::table('membros')->select('*')->get('*');

        return response($membro, 200, []);
    });

    Route::post('/register', function (Request $request) {
        if (!$request->has([
            "genero", "morada", "idioma", "pin",
            "titulo", "nome", "sobrenome", "email",
            "telefone", "data"
        ])) {
            $data = ['estado' => 'erro', 'desc' => 'Submeta todos os campos'];
            return response()->json($data, 406, []);
        }

        try {
            $cliente = DB::table('clientes')->insertGetId([
                'titulo' => $request->titulo,
                'nome' => $request->nome,
                'sobrenome' => $request->sobrenome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'data' => $request->data,
                'estado' => 1,
            ]);

            $membro = DB::table('membros')->insertGetId([
                'genero' => $request->genero,
                'morada' => $request->morada,
                'idioma' => $request->idioma,
                'pin' => $request->pin,
                'milhas' => 0,
                'id_cliente' => $cliente,
                'estado' => 0
            ]);

            return response()->json([
                'data' => json_encode([
                    'nome' => $request->nome,
                    'sobrenome' => $request->sobrenome,
                    'email' => $request->email,
                    'telefone' => $request->telefone,
                    'titulo' => $request->titulo,
                    'morada' => $request->morada,
                    'genero' => $request->genero,
                    'data' => $request->data,
                    'idioma' => $request->idioma,
                ], JSON_UNESCAPED_UNICODE),
                'estado' => 'ok',
                'desc' => 'Membro registado com sucesso',
            ], 201, []);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e,
                'estado' => 'erro',
                'desc' => 'Erro interno'
            ], 500, []);
        }
    });

    Route::post('/login', function (Request $request) {
        if (!$request->has(["pin", "email",])) {
            $data = ['estado' => 'erro', 'desc' => 'Submeta todos os campos'];
            return response()->json($data, 406, []);
        }

        try {
            $cliente = DB::table('clientes')->where('email', '=', $request->email)->select('*')->distinct()->get();
            $cliente = $cliente->toArray();

            if (empty($cliente)) {
                return response()->json(([
                    'data' => [],
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            $membro = DB::table('membros')
                ->select('*')
                ->where('id_cliente', '=', $cliente[0]->id)
                ->where('pin', '=', $request->pin)
                ->get();
            $membro = $membro->toArray();

            if (empty($membro)) {
                return response()->json(([
                    'data' => [],
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            return response()->json(([
                'data' => json_encode([
                    'nome' => $cliente[0]->nome,
                    'sobrenome' => $cliente[0]->sobrenome,
                    'email' => $cliente[0]->email,
                    'telefone' => $cliente[0]->telefone,
                    'titulo' => $cliente[0]->titulo,
                    'morada' => $membro[0]->morada,
                    'genero' => $membro[0]->genero,
                    'data' => $cliente[0]->data,
                    'idioma' => $membro[0]->idioma,
                    'milhas' => $membro[0]->milhas,
                    'estado' => $membro[0]->estado,
                    'pin' => $membro[0]->pin,
                    'id' => $membro[0]->id,
                ], JSON_UNESCAPED_UNICODE),
                'estado' => 'ok',
                'desc' => 'Membro autenticado',
            ]), 200, []);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e,
                'estado' => 'erro',
                'desc' => 'Erro interno'
            ], 500, []);
        }
    });

    Route::post('/edit/pin', function (Request $request) {
        if (!$request->has(["pin", "email", "novoPin", "id"])) {
            $data = ['estado' => 'erro', 'desc' => 'Submeta todos os campos'];
            return response()->json($data, 406, []);
        }

        try {
            $cliente = DB::table('clientes')->where('email', '=', $request->email)->select('*')->distinct()->get();
            $cliente = $cliente->toArray();

            if (empty($cliente)) {
                return response()->json(([
                    'data' => '',
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            $membro = DB::table('membros')
                ->where('id_cliente', '=', $cliente[0]->id)
                ->where('pin', '=', $request->pin)
                ->select('*')
                ->get();
            $membro = $membro->toArray();

            if (empty($membro)) {
                return response()->json(([
                    'data' => '',
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            DB::table('membros')->where('id', '=', $request->id)->update(['pin' => $request->novoPin]);

            return response()->json(([
                'data' => '',
                'estado' => 'ok',
                'desc' => 'Dados atualizados',
            ]), 200, []);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e,
                'estado' => 'erro',
                'desc' => 'Erro interno'
            ], 500, []);
        }
    });

    Route::post('/edit/data', function (Request $request) {
        if (!$request->has(["pin", "email", "nome", "id"])) {
            $data = ['estado' => 'erro', 'desc' => 'Submeta todos os campos'];
            return response()->json($data, 406, []);
        }

        try {
            $membro = DB::table('membros')
                ->where('id', '=', $request->id)
                ->where('pin', '=', $request->pin)
                ->select('*')
                ->get();
            $membro = $membro->toArray();

            if (empty($membro)) {
                return response()->json(([
                    'data' => '',
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            $cliente = DB::table('clientes')
                ->where('id', '=', $membro[0]->id_cliente)
                ->select('*')
                ->get();
            $cliente = $cliente->toArray();

            if (empty($cliente)) {
                return response()->json(([
                    'data' => '',
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            DB::table('clientes')
                ->where('id', '=', $cliente[0]->id)
                ->update(['nome' => $request->nome]);

            DB::table('clientes')
                ->where('id', '=', $cliente[0]->id)
                ->update(['email' => $request->email]);

            return response()->json(([
                'data' => '',
                'estado' => 'ok',
                'desc' => 'Dados atualizados',
            ]), 200, []);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e,
                'estado' => 'erro',
                'desc' => 'Erro interno'
            ], 500, []);
        }
    });
});

Route::get('/countries', function () {
    try {
        $paises = DB::table('cidades')->select()->get();

        return response()->json(([
            'data' => $paises,
            'estado' => 'ok',
            'desc' => 'sucesso'
        ]), 200, []);
    } catch (Exception $e) {
        return response()->json([
            'data' => $e,
            'estado' => 'erro',
            'desc' => 'Erro interno'
        ], 500, []);
    }
});

Route::post('/flightSearch', function (Request $request) {
    try {
        if(!$request->has(["tipo", "origem", "destino", 'data'])) {
            $data = ['estado' => 'erro', 'desc' => 'Submeta todos os campos'];
            return response()->json($data, 406, []);
        }

        $tipo = $request->tipo;
        $origem = $request->origem;
        $destino = $request->destino;
        $data_partida = $request->data;
        $voos = [];

        $voos = DB::table("voos")
            ->join("aeroportos AS ORIGEM", "ORIGEM.id", "=", "voos.id_aeroporto_origem")
            ->join("cidades as CIDADE_ORIGEM", "CIDADE_ORIGEM.id", "=", "ORIGEM.id_cidade")
            ->join("aeroportos AS DESTINO", "DESTINO.id", "=", "voos.id_aeroporto_destino")
            ->join("cidades as CIDADE_DESTINO", "CIDADE_DESTINO.id", "=", "DESTINO.id_cidade")
            ->where("ORIGEM.id", "=", $origem)
            ->where("DESTINO.id", "=", $destino)
            ->where("voos.data_partida", "=", $data_partida)
            ->where("voos.estado", "=", "1")
            ->select(
                "voos.id as id_voo",
                "voos.data_partida",
                "voos.hora as hora",
                "voos.duracao_estimada",
                "ORIGEM.id as id_origem",
                "ORIGEM.nome as aeroporto_origem",
                "CIDADE_ORIGEM.nome as cidade_origem",
                "DESTINO.id as id_destino",
                "DESTINO.nome as aeroporto_destino",
                "CIDADE_DESTINO.nome as cidade_destino"
            )
            ->selectRaw("DATE_ADD(concat(voos.data_partida,' ', voos.hora),INTERVAL voos.duracao_estimada HOUR) as chegada", [])
            ->get();

        $voo_array = $voos->toArray();
        array_walk($voo_array, function ($item) {
            return  $item->classes = $tarifas = DB::table("voo_tarifas")
                ->join("tarifas", "tarifas.id", "=", "voo_tarifas.id_tarifa")
                ->join("classes", "classes.id", "=", "tarifas.id_classe")
                ->where("voo_tarifas.id_voo", "=", $item->id_voo)
                ->select("classes.nome", "classes.id", "voo_tarifas.id_voo")
                ->distinct()
                ->get();
        });

        array_walk($voo_array, function ($item) {
            return  $item->tarifas = DB::table("voo_tarifas")
                ->join("tarifas", "tarifas.id", "=", "voo_tarifas.id_tarifa")
                ->join("classes", "classes.id", "=", "tarifas.id_classe")
                ->join("voo_lugares", "voo_lugares.id_voo_tarifa", "=", "voo_tarifas.id", "right")
                ->where("voo_tarifas.id_voo", "=", $item->id_voo)
                ->select(
                    "tarifas.id as tarifa_id",
                    "tarifas.nome as tarifa",
                    "voo_tarifas.preco",
                    "voo_tarifas.id as id_voo_tarifa",
                    "classes.nome as classe_nome",
                    "classes.id as classe_id"
                )
                ->selectRaw("count(voo_lugares.id) as lugares,voo_lugares.estado")
                ->groupBy(
                    "tarifas.id",
                    "tarifas.nome",
                    "voo_tarifas.preco",
                    "voo_tarifas.id",
                    "classes.nome",
                    "classes.id",
                    "voo_lugares.estado"
                )
                ->having("voo_lugares.estado", "=", "0")
                ->distinct()
                ->get();
        });

        return response()->json(([
            'data' => $voo_array,
            'estado' => 'ok',
            'desc' => 'Sucesso',
        ]), 200, []);
    } catch (Exception $e) {
        return response()->json([
            'data' => $e,
            'estado' => 'erro',
            'desc' => 'Erro interno'
        ], 500, []);
    }
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//
Route::post("/admin/voos/alterartarifa", [VooController::class, "alterarTarifa"]);
