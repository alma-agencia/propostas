<?php
// ─── Painel do gestor — criar, acompanhar e ler briefings ────────────────────
declare(strict_types=1);
require dirname(__DIR__) . '/lib.php';

$protegida = !empty($_SERVER['PHP_AUTH_USER']) || !empty($_SERVER['REMOTE_USER']) || !empty($_SERVER['REDIRECT_REMOTE_USER']);

$aviso = '';
$acao  = $_POST['acao'] ?? ($_GET['acao'] ?? '');

// ── criar ──
if ($acao === 'criar' && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $nome = trim((string)($_POST['nome'] ?? ''));
    $tipoNovo = (string)($_POST['tipo'] ?? '');
    $defs = tipos();
    if ($nome === '') {
        $aviso = 'Informe o nome do cliente.';
    } elseif (!isset($defs[$tipoNovo]) || empty($defs[$tipoNovo]['ativo'])) {
        $aviso = 'Escolha um tipo de briefing disponível.';
    } else {
        $token = novo_token($nome);
        gravar($token, [
            'nome'          => mb_substr($nome, 0, 120),
            'tipo'          => $tipoNovo,
            'criado_em'     => date('c'),
            'atualizado_em' => date('c'),
            'respostas'     => ['emp_nome' => mb_substr($nome, 0, 120)],
        ]);
        header('Location: ?novo=' . urlencode($token));
        exit;
    }
}

// ── excluir ──
if ($acao === 'excluir' && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $t = (string)($_POST['token'] ?? '');
    if (token_valido($t) && is_file(caminho($t))) { @unlink(caminho($t)); }
    header('Location: ?');
    exit;
}

// ── ler um briefing ──
$vendo = null;
if (!empty($_GET['ver']) && token_valido((string)$_GET['ver'])) {
    $vendo = ler((string)$_GET['ver']);
    $vendoToken = (string)$_GET['ver'];
}

$urlBase = preg_replace('#/admin$#', '', base_url());
$novo    = (!empty($_GET['novo']) && token_valido((string)$_GET['novo'])) ? (string)$_GET['novo'] : null;
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $vendo ? 'Briefing — ' . e($vendo['nome'] ?? '') : 'Briefings' ?> · Alma.Convert</title>
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
<link rel="icon" type="image/png" sizes="512x512" href="/favicon.png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--ink:#1a1a1a;--mid:#333;--dim:#555;--muted:#888;--line:rgba(16,24,40,.09);
--off:#fbfbfb;--soft:#f5f5f5;--orange:#F97316;--orange-d:#EA6C0A;--orange-l:#FFF4ED;
--ok:#12805c;--warn:#9a6700;--f:'Poppins',-apple-system,sans-serif}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:var(--f);background:var(--off);color:var(--ink);line-height:1.55;-webkit-font-smoothing:antialiased}
.wrap{max-width:940px;margin:0 auto;padding:0 24px}
header{background:#fff;border-bottom:1px solid var(--line);padding:28px 0 24px}
.brand{font-size:1.45rem;font-weight:800;letter-spacing:-.03em}
.brand i{font-style:italic;font-weight:300;color:var(--muted)}
.brand small{display:block;font-size:.52rem;font-weight:600;letter-spacing:.3em;text-transform:uppercase;color:var(--muted);margin-top:6px}
h1{font-size:1.5rem;font-weight:700;letter-spacing:-.02em;margin-top:22px}
.sub{font-size:.85rem;font-weight:300;color:var(--dim);margin-top:6px}
.alerta{margin:20px 0;padding:15px 18px;border-radius:8px;font-size:.83rem;font-weight:300;line-height:1.7}
.alerta.perigo{background:#fff0ef;border-left:3px solid #c0392b;color:#7d2019}
.alerta.info{background:var(--orange-l);border-left:3px solid var(--orange);color:var(--mid)}
.alerta b{font-weight:600}
.card{background:#fff;border:1px solid var(--line);border-radius:10px;margin:22px 0;overflow:hidden}
.card-h{padding:15px 20px;border-bottom:1px solid var(--line);font-size:.95rem;font-weight:700}
.card-b{padding:20px}
form.novo{display:flex;gap:10px;flex-wrap:wrap}
input[type=text]{flex:1;min-width:220px;font-family:var(--f);font-size:.88rem;padding:12px 14px;border:1px solid var(--line);border-radius:7px;outline:0}
input[type=text]:focus,select:focus{border-color:var(--orange);box-shadow:0 0 0 2px rgba(249,115,22,.16)}
select{font-family:var(--f);font-size:.85rem;padding:12px 14px;border:1px solid var(--line);border-radius:7px;outline:0;background:#fff;color:var(--ink);min-width:220px}
.dica{margin-top:12px;font-size:.78rem;font-weight:300;color:var(--dim);line-height:1.6}
.tipo{display:inline-block;padding:3px 10px;border-radius:99px;background:var(--soft);color:var(--dim);font-size:.66rem;font-weight:600}
.tipo-topo{margin-top:6px;font-size:.66rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--orange)}
button{font-family:var(--f);font-size:.76rem;font-weight:600;padding:12px 20px;border-radius:7px;border:1px solid var(--ink);background:var(--ink);color:#fff;cursor:pointer;transition:.18s}
button:hover{background:var(--orange);border-color:var(--orange);color:var(--ink)}
button.ghost{background:#fff;color:var(--ink);border-color:var(--line)}
button.ghost:hover{border-color:var(--orange);color:var(--orange-d);background:#fff}
table{width:100%;border-collapse:collapse}
th{text-align:left;font-size:.62rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);padding:12px 20px;border-bottom:1px solid var(--line)}
td{padding:14px 20px;border-bottom:1px solid var(--line);font-size:.86rem;font-weight:300;vertical-align:middle}
tr:last-child td{border-bottom:0}
td.nome{font-weight:600}
.pill{display:inline-block;padding:3px 10px;border-radius:99px;font-size:.62rem;font-weight:700;letter-spacing:.06em}
.pill.v{background:#e8f5f0;color:var(--ok)}
.pill.m{background:var(--orange-l);color:var(--orange-d)}
.pill.z{background:var(--soft);color:var(--muted)}
.acoes{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap}
.link-box{margin-top:14px;padding:14px;background:var(--soft);border-radius:7px;font-family:ui-monospace,Menlo,monospace;font-size:.74rem;word-break:break-all;color:var(--mid)}
.vazio{padding:40px 20px;text-align:center;color:var(--muted);font-weight:300;font-size:.88rem}
/* leitura */
.grupo{margin:34px 0 6px;font-size:1.15rem;font-weight:700;letter-spacing:-.02em}
.sec{background:#fff;border:1px solid var(--line);border-radius:10px;margin:14px 0 22px;overflow:hidden}
.sec-h{padding:13px 18px;border-bottom:1px solid var(--line);font-size:.9rem;font-weight:700}
.par{display:grid;grid-template-columns:280px 1fr;border-top:1px solid var(--line)}
.par:first-of-type{border-top:0}
.par .l{background:var(--soft);padding:14px 18px;font-size:.8rem;font-weight:500}
.par .l em{display:block;font-style:normal;font-weight:400;font-size:.7rem;color:#b5651a;margin-top:3px}
.par .v{padding:14px 18px;font-size:.87rem;font-weight:300;white-space:pre-wrap;line-height:1.75}
.par .v.na{color:#bbb;font-style:italic}
footer{padding:30px 24px 60px;text-align:center;font-size:.68rem;font-weight:300;color:var(--muted)}
@media(max-width:720px){ .par{grid-template-columns:1fr} .acoes{justify-content:flex-start} td,th{padding:10px 12px} }
@media print{ header .brand small,.alerta,.acoes,footer,.no-print{display:none!important} body{background:#fff} .sec{break-inside:avoid} }
</style>
</head>
<body>

<header>
  <div class="wrap">
    <div class="brand">Alma<i>.Convert</i><small>Agência Digital</small></div>
    <?php if ($vendo): ?>
      <h1><?= e($vendo['nome'] ?? 'Briefing') ?></h1>
      <p class="tipo-topo"><?= e(nome_do_tipo(tipo_do($vendo))) ?></p>
      <p class="sub">
        <?php
          $r = $vendo['respostas'] ?? [];
          $n = count(array_filter($r, fn($v) => trim((string)$v) !== ''));
          echo $n . ' de ' . total_campos(tipo_do($vendo)) . ' campos respondidos';
          if (!empty($vendo['atualizado_em'])) {
              echo ' · última atualização em ' . e(date('d/m/Y \à\s H:i', strtotime((string)$vendo['atualizado_em'])));
          }
        ?>
      </p>
    <?php else: ?>
      <h1>Briefings de tráfego pago</h1>
      <p class="sub">Crie um link por cliente. As respostas chegam sozinhas, sem o cliente precisar enviar nada.</p>
    <?php endif; ?>
  </div>
</header>

<main class="wrap">

<?php if (!$protegida): ?>
  <div class="alerta perigo">
    <b>Esta pasta ainda está aberta.</b> Qualquer pessoa que descobrir o endereço vê os briefings, inclusive faturamento.
    Proteja agora no hPanel da Hostinger: <b>Arquivos → Proteção de diretórios</b>, aponte para <b>/public_html/proposta/briefing/admin</b> e defina usuário e senha.
    Este aviso some assim que a proteção estiver ativa.
  </div>
<?php endif; ?>

<?php if ($aviso): ?><div class="alerta info"><?= e($aviso) ?></div><?php endif; ?>

<?php if ($vendo): ?>

  <div class="acoes no-print" style="justify-content:flex-start;margin:20px 0">
    <a href="?"><button class="ghost" type="button">← Todos os briefings</button></a>
    <button class="ghost" type="button" onclick="window.print()">Salvar em PDF</button>
  </div>

  <?php
  $mapa = campos_do_tipo(tipo_do($vendo));
  $resp = $vendo['respostas'] ?? [];
  foreach ($mapa as $bloco):
      if ($bloco['tipo'] === 'grupo' && empty($bloco['campos'])):
          ?><h2 class="grupo"><?= e($bloco['titulo']) ?></h2><?php
          continue;
      endif;
      $temAlgo = false;
      foreach ($bloco['campos'] as $c) { if (trim((string)($resp[$c['k']] ?? '')) !== '') { $temAlgo = true; break; } }
  ?>
    <?php if ($bloco['tipo'] === 'grupo'): ?><h2 class="grupo"><?= e($bloco['titulo']) ?></h2><?php endif; ?>
    <div class="sec">
      <?php if ($bloco['tipo'] === 'secao'): ?>
        <div class="sec-h"><?= e($bloco['titulo']) ?><?= $temAlgo ? '' : ' — sem resposta' ?></div>
      <?php endif; ?>
      <?php foreach ($bloco['campos'] as $c):
        $v = trim((string)($resp[$c['k']] ?? '')); ?>
        <div class="par">
          <div class="l"><?= e($c['label']) ?><?= $c['hint'] ? '<em>' . e($c['hint']) . '</em>' : '' ?></div>
          <div class="v <?= $v === '' ? 'na' : '' ?>"><?= $v === '' ? '— não respondido' : e($v) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>

<?php else: ?>

  <?php if ($novo): ?>
    <div class="alerta info">
      <b>Briefing criado.</b> Envie este link para o cliente — é só dele, e as respostas ficam salvas nele.
      <div class="link-box"><?= e($urlBase) ?>/index.php?c=<?= e($novo) ?></div>
    </div>
  <?php endif; ?>

  <div class="card">
    <div class="card-h">Novo briefing</div>
    <div class="card-b">
      <form class="novo" method="post">
        <input type="hidden" name="acao" value="criar">
        <input type="text" name="nome" placeholder="Nome do cliente — ex.: Climatizadores Bom Ar" required>
        <select name="tipo" id="selTipo" required>
          <?php foreach (tipos() as $id => $t): ?>
            <option value="<?= e($id) ?>" data-resumo="<?= e($t['resumo']) ?>" <?= empty($t['ativo']) ? 'disabled' : '' ?>>
              <?= e($t['nome']) ?><?= empty($t['ativo']) ? ' — em breve' : '' ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button type="submit">Criar link</button>
      </form>
      <p class="dica" id="dicaTipo"></p>
    </div>
  </div>

  <div class="card">
    <div class="card-h">Briefings</div>
    <?php $lista = listar(); ?>
    <?php if (!$lista): ?>
      <div class="vazio">Nenhum briefing ainda. Crie o primeiro acima.</div>
    <?php else: ?>
      <table>
        <thead><tr><th>Cliente</th><th>Tipo</th><th>Preenchimento</th><th>Última atualização</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($lista as $b):
          $n = (int)$b['respondidos'];
          $tot = max(1, (int)$b['total']); $cls = $n === 0 ? 'z' : ($n >= $tot * 0.8 ? 'v' : 'm'); ?>
          <tr>
            <td class="nome"><?= e($b['nome']) ?></td>
            <td><span class="tipo"><?= e($b['tipo_nome']) ?></span></td>
            <td><span class="pill <?= $cls ?>"><?= $n ?> de <?= (int)$b['total'] ?></span></td>
            <td><?= $b['atualizado'] ? e(date('d/m/Y H:i', strtotime((string)$b['atualizado']))) : '—' ?></td>
            <td>
              <div class="acoes">
                <a href="?ver=<?= e($b['token']) ?>"><button class="ghost" type="button">Ler</button></a>
                <button class="ghost" type="button" onclick="copiar('<?= e($urlBase) ?>/index.php?c=<?= e($b['token']) ?>',this)">Copiar link</button>
                <form method="post" onsubmit="return confirm('Excluir o briefing de <?= e($b['nome']) ?>? Não dá para desfazer.')" style="display:inline">
                  <input type="hidden" name="acao" value="excluir">
                  <input type="hidden" name="token" value="<?= e($b['token']) ?>">
                  <button class="ghost" type="submit">Excluir</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

<?php endif; ?>
</main>

<footer>Alma.Convert · Agência Digital — painel interno</footer>

<script>
(function(){
  var sel=document.getElementById('selTipo'), dica=document.getElementById('dicaTipo');
  if(!sel||!dica) return;
  function mostra(){ var o=sel.options[sel.selectedIndex]; dica.textContent=o?o.dataset.resumo||'':''; }
  sel.addEventListener('change',mostra); mostra();
})();
function copiar(url, btn){
  navigator.clipboard.writeText(url).then(function(){
    var t=btn.textContent; btn.textContent='Copiado'; setTimeout(function(){ btn.textContent=t; },1500);
  }).catch(function(){ prompt('Copie o link:', url); });
}
</script>
</body>
</html>
