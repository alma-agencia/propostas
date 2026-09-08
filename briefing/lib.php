<?php
// ─── Funções compartilhadas do briefing ──────────────────────────────────────
declare(strict_types=1);

const DIR_DADOS = __DIR__ . '/dados';
const MAX_BYTES = 400000;   // teto de segurança do payload

/** Token só pode ter letras minúsculas, números e hífen. Evita path traversal. */
function token_valido(?string $t): bool {
    return is_string($t) && preg_match('/^[a-z0-9][a-z0-9\-]{5,79}$/', $t) === 1;
}

function caminho(string $token): string {
    return DIR_DADOS . '/' . $token . '.json';
}

function ler(string $token): ?array {
    $p = caminho($token);
    if (!is_file($p)) return null;
    $raw = @file_get_contents($p);
    if ($raw === false) return null;
    $d = json_decode($raw, true);
    return is_array($d) ? $d : null;
}

function gravar(string $token, array $registro): bool {
    if (!is_dir(DIR_DADOS)) { @mkdir(DIR_DADOS, 0755, true); }
    $p   = caminho($token);
    $tmp = $p . '.tmp';
    // grava em arquivo temporário e move: evita arquivo corrompido se cair no meio
    if (@file_put_contents($tmp, json_encode($registro, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX) === false) {
        return false;
    }
    return @rename($tmp, $p);
}

function slugificar(string $s): string {
    $s = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s) ?: $s;
    $s = strtolower($s);
    $s = preg_replace('/[^a-z0-9]+/', '-', $s) ?? '';
    $s = trim($s, '-');
    return $s === '' ? 'cliente' : substr($s, 0, 48);
}

function novo_token(string $nome): string {
    return slugificar($nome) . '-' . bin2hex(random_bytes(4));
}

function listar(): array {
    if (!is_dir(DIR_DADOS)) return [];
    $out = [];
    foreach (glob(DIR_DADOS . '/*.json') ?: [] as $f) {
        $d = json_decode((string)@file_get_contents($f), true);
        if (!is_array($d)) continue;
        $out[] = [
            'token'       => basename($f, '.json'),
            'nome'        => $d['nome'] ?? '(sem nome)',
            'criado_em'   => $d['criado_em'] ?? null,
            'atualizado'  => $d['atualizado_em'] ?? null,
            'respondidos' => is_array($d['respostas'] ?? null) ? count(array_filter($d['respostas'], fn($v) => trim((string)$v) !== '')) : 0,
        ];
    }
    usort($out, fn($a, $b) => strcmp((string)$b['atualizado'], (string)$a['atualizado']));
    return $out;
}

function base_url(): string {
    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host  = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $dir   = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    return $proto . '://' . $host . $dir;
}

function e(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
