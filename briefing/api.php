<?php
// ─── API do briefing: carregar e salvar respostas ────────────────────────────
declare(strict_types=1);
require __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

function responder(array $d, int $status = 200): never {
    http_response_code($status);
    echo json_encode($d, JSON_UNESCAPED_UNICODE);
    exit;
}

$acao  = $_GET['a'] ?? '';
$token = $_GET['c'] ?? '';

if (!token_valido($token)) {
    responder(['erro' => 'token_invalido'], 400);
}

$registro = ler($token);
if ($registro === null) {
    // Briefing precisa ter sido criado pelo painel. Não criamos on-the-fly,
    // senão qualquer token inventado viraria um arquivo novo no servidor.
    responder(['erro' => 'nao_encontrado'], 404);
}

if ($acao === 'load') {
    responder([
        'ok'        => true,
        'nome'      => $registro['nome'] ?? '',
        'respostas' => $registro['respostas'] ?? new stdClass(),
        'atualizado'=> $registro['atualizado_em'] ?? null,
    ]);
}

if ($acao === 'save') {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        responder(['erro' => 'metodo'], 405);
    }
    $bruto = file_get_contents('php://input');
    if ($bruto === false || strlen($bruto) > MAX_BYTES) {
        responder(['erro' => 'payload'], 413);
    }
    $entrada = json_decode($bruto, true);
    if (!is_array($entrada) || !is_array($entrada['respostas'] ?? null)) {
        responder(['erro' => 'formato'], 422);
    }

    // Só aceitamos strings. Nada de estrutura aninhada vinda do cliente.
    $limpo = [];
    foreach ($entrada['respostas'] as $k => $v) {
        if (!is_string($k) || !preg_match('/^[a-z0-9_]{1,40}$/', $k)) continue;
        if (!is_string($v)) continue;
        $limpo[$k] = mb_substr($v, 0, 8000);
    }

    $registro['respostas']     = $limpo;
    $registro['atualizado_em'] = date('c');
    if (!empty($limpo['emp_nome'])) {
        $registro['nome'] = mb_substr($limpo['emp_nome'], 0, 120);
    }

    if (!gravar($token, $registro)) {
        responder(['erro' => 'falha_ao_gravar'], 500);
    }
    responder(['ok' => true, 'atualizado' => $registro['atualizado_em'], 'campos' => count($limpo)]);
}

responder(['erro' => 'acao_desconhecida'], 400);
