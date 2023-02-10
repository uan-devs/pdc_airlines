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
            ]));
        } catch (Request $e) {
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
                    'data' => [],
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            $membro = DB::table('membros')->where('id_cliente', '=', $cliente[0]->id, 'and', 'pin', '=', $request->pin)->select('*')->get();
            $membro = $membro->toArray();

            if (empty($membro)) {
                return response()->json(([
                    'data' => [],
                    'estado' => 'erro',
                    'desc' => 'Credenciais erradas'
                ]), 200, []);
            }

            DB::table('membros')->where('id', '=', $request->id)->update(['pin' => $request->novoPin]);

            return response()->json(([
                'data' => [],
                'estado' => 'ok',
                'desc' => 'Dados atualizados',
            ]));
        } catch (Request $e) {
            return response()->json([
                'data' => $e,
                'estado' => 'erro',
                'desc' => 'Erro interno'
            ], 500, []);
        }
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//
Route::post("/admin/voos/alterartarifa", [VooController::class, "alterarTarifa"]);
