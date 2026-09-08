<?php
// Sonda temporária — verifica PHP e permissão de escrita. Remover após o teste.
header('Content-Type: application/json; charset=utf-8');

$dir = __DIR__ . '/_teste_escrita';
$podeCriarPasta = is_dir($dir) ? true : @mkdir($dir, 0755, true);
$arquivo = $dir . '/ping.json';
$escreveu = $podeCriarPasta ? (@file_put_contents($arquivo, json_encode(['t' => time()])) !== false) : false;
$leu = $escreveu ? (@file_get_contents($arquivo) !== false) : false;
if ($escreveu) { @unlink($arquivo); }
if ($podeCriarPasta && is_dir($dir)) { @rmdir($dir); }

echo json_encode([
  'php'            => PHP_VERSION,
  'pode_criar_pasta' => (bool)$podeCriarPasta,
  'pode_escrever'  => (bool)$escreveu,
  'pode_ler'       => (bool)$leu,
  'json_ok'        => function_exists('json_encode'),
  'random_ok'      => function_exists('random_bytes'),
  'dir'            => basename(__DIR__),
], JSON_PRETTY_PRINT);
