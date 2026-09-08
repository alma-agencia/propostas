<?php
// ─── Formulário de briefing — renderizado a partir do mapa do tipo ───────────
declare(strict_types=1);
require __DIR__ . '/lib.php';

$token = $_GET['c'] ?? '';
$reg   = token_valido($token) ? ler($token) : null;

if ($reg === null) {
    http_response_code(404);
    ?><!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Briefing não encontrado</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;800&display=swap" rel="stylesheet">
    <style>body{font-family:'Poppins',sans-serif;background:#fbfbfb;color:#1a1a1a;display:flex;min-height:100vh;
    align-items:center;justify-content:center;padding:24px;margin:0}
    .c{max-width:460px;text-align:center}.c h1{font-size:1.5rem;font-weight:800;letter-spacing:-.03em;margin:0 0 12px}
    .c p{font-weight:300;line-height:1.8;color:#555;font-size:.92rem}
    .b{font-weight:800;letter-spacing:-.03em;margin-bottom:28px}.b i{font-style:italic;font-weight:300;color:#888}</style>
    </head><body><div class="c"><div class="b">Alma<i>.Convert</i></div>
    <h1>Este link não é válido</h1>
    <p>Pode ter sido digitado com algum caractere a menos, ou o briefing ainda não foi criado.
    Fale com a gente no grupo de trabalho que reenviamos o endereço certo.</p>
    </div></body></html><?php
    exit;
}

$tipo        = tipo_do($reg);
$mapa        = campos_do_tipo($tipo);
$nomeCliente = (string)($reg['nome'] ?? '');
$totalObrig  = count(chaves_obrigatorias($tipo));
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Briefing<?= $nomeCliente ? " — " . e($nomeCliente) : "" ?> — Alma.Convert</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#1a1a1a; --mid:#333333; --dim:#555555; --muted:#888888;
  --line:rgba(16,24,40,.09); --lav:#f5f5f5; --lav-d:#EA6C0A; --lav-l:#FFF4ED; --orange-d:#EA6C0A;
  --bg:#ffffff; --off:#fbfbfb; --ok:#12805c; --warn:#9a6700; --orange:#F97316;
  --f:'Poppins',-apple-system,BlinkMacSystemFont,sans-serif;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:var(--f);background:var(--off);color:var(--ink);-webkit-font-smoothing:antialiased;line-height:1.55}

.wrap{max-width:920px;margin:0 auto;padding:0 24px}

/* ── TOPO ── */
header.top{background:var(--bg);border-bottom:1px solid var(--line);padding:34px 0 26px}
.brand{font-size:1.7rem;font-weight:800;letter-spacing:-.03em}
.brand i{font-style:italic;font-weight:300;color:var(--muted)}
.brand small{display:block;font-size:.55rem;font-weight:600;letter-spacing:.3em;text-transform:uppercase;color:var(--muted);margin-top:7px}
.rule{height:1px;background:var(--ink);margin:20px 0 0}
.doc-title{margin-top:26px;font-size:clamp(1.5rem,3.4vw,2.1rem);font-weight:700;letter-spacing:-.02em}
.doc-cli{margin-top:10px;font-size:.72rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--orange)}
.doc-sub{margin-top:8px;font-size:.92rem;font-weight:300;color:var(--dim);max-width:640px}

/* ── BARRA FIXA ── */
.bar{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.94);backdrop-filter:blur(14px);border-bottom:1px solid var(--line)}
.bar-in{max-width:920px;margin:0 auto;padding:11px 24px;display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.prog{flex:1;min-width:150px;height:5px;background:var(--lav);border-radius:99px;overflow:hidden}
.prog i{display:block;height:100%;width:0;background:var(--orange);transition:width .35s}
.prog-t{font-size:.7rem;font-weight:600;color:var(--dim);white-space:nowrap}
.saved.erro{color:var(--warn)}
.saved{font-size:.68rem;font-weight:500;color:var(--ok);white-space:nowrap;opacity:0;transition:opacity .3s}
.saved.on{opacity:1}

/* ── AVISOS ── */
.note{margin:22px 0;padding:16px 18px;border-radius:8px;font-size:.84rem;font-weight:300;line-height:1.7}
.note b{font-weight:600}
.note.info{background:var(--lav-l);border-left:3px solid var(--orange);color:var(--mid)}
.note.read{background:#fff8e6;border-left:3px solid var(--warn);color:#6b4e00}

/* ── SEÇÕES ── */
.group{margin:44px 0 10px;font-size:1.35rem;font-weight:700;letter-spacing:-.02em}
section.blk{background:var(--bg);border:1px solid var(--line);border-radius:10px;margin:16px 0 26px;overflow:hidden}
.blk-h{padding:16px 20px;border-bottom:1px solid var(--line);background:var(--bg)}
.blk-h h3{font-size:1rem;font-weight:700;letter-spacing:-.01em}
.opt{display:inline-block;margin-left:8px;padding:3px 9px;border-radius:99px;background:var(--lav);color:var(--orange-d);font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;vertical-align:middle}
.blk-h p{font-size:.78rem;font-weight:300;color:var(--muted);margin-top:3px}

.row{display:grid;grid-template-columns:270px 1fr;border-top:1px solid var(--line)}
.row:first-of-type{border-top:0}
.row .lab{background:var(--lav);padding:16px 18px;font-size:.85rem;font-weight:500;color:var(--ink);display:flex;align-items:center}
.row .lab span{display:block}
.row .lab em{display:block;font-style:normal;font-weight:400;font-size:.74rem;color:#b5651a;margin-top:4px;line-height:1.5}
.row .fld{padding:10px 14px;display:flex;align-items:center}
textarea,input[type=text]{width:100%;border:0;outline:0;font-family:var(--f);font-size:.9rem;font-weight:400;color:var(--ink);background:transparent;resize:vertical;line-height:1.65;padding:6px 4px;border-radius:6px}
textarea::placeholder,input::placeholder{color:#bbbbbb;font-weight:300}
textarea:focus,input:focus{background:var(--lav-l);box-shadow:0 0 0 2px rgba(249,115,22,.22)}
textarea{min-height:46px;overflow:hidden}

/* ── DORES ── */
.dores{padding:6px 0}
.dores .dh{display:grid;grid-template-columns:270px 1fr;font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim)}
.dores .dh div{padding:10px 18px}
.dr{display:grid;grid-template-columns:270px 1fr;border-top:1px solid var(--line)}
.dr .c{padding:10px 14px}
.dr .c:first-child{background:var(--lav)}

/* ── AÇÕES ── */
.actions{background:var(--bg);border:1px solid var(--line);border-radius:10px;padding:28px 24px;margin:32px 0 60px}
.actions h3{font-size:1.05rem;font-weight:700;margin-bottom:8px}
.actions p{font-size:.85rem;font-weight:300;color:var(--dim);line-height:1.7;margin-bottom:20px}
.btns{display:flex;gap:10px;flex-wrap:wrap}
button{font-family:var(--f);font-size:.78rem;font-weight:600;letter-spacing:.02em;padding:13px 22px;border-radius:7px;border:1px solid var(--line);background:var(--bg);color:var(--ink);cursor:pointer;transition:.18s}
button:hover{border-color:var(--orange);color:var(--orange-d)}
button.primary{background:var(--ink);color:#fff;border-color:var(--ink)}
button.primary:hover{background:var(--orange);border-color:var(--orange);color:var(--ink)}
.out{margin-top:20px;display:none}
.out.on{display:block}
.out textarea{width:100%;border:1px solid var(--line);border-radius:7px;padding:12px;font-size:.76rem;min-height:96px;background:var(--off);font-family:ui-monospace,SFMono-Regular,Menlo,monospace;color:var(--mid)}
.msg{margin-top:12px;font-size:.8rem;font-weight:500}
.msg.ok{color:var(--ok)} .msg.warn{color:var(--warn)}

footer{border-top:1px solid var(--line);padding:26px 24px 50px;text-align:center}
footer p{font-size:.7rem;font-weight:300;color:var(--muted);letter-spacing:.03em}

/* ── LEITURA ── */
body.readonly textarea,body.readonly input{background:transparent!important;box-shadow:none!important;color:var(--ink)}
body.readonly .row .fld{align-items:flex-start}
body.readonly .vazio{color:#bbbbbb;font-style:italic;font-size:.85rem;padding:6px 4px}

@media(max-width:760px){
  .row,.dr,.dores .dh{grid-template-columns:1fr}
  .row .lab{padding:12px 16px}
  .dores .dh div:last-child{display:none}
  .dr .c:first-child{border-bottom:1px solid var(--line)}
}
@media print{
  .bar,.actions,.note.info,footer,.doc-sub{display:none!important}
  body{background:#fff}
  section.blk{break-inside:avoid;border-radius:0}
  .row{break-inside:avoid}
  textarea{overflow:visible!important}
}
</style>
<script>window.__BRIEFING__={token:<?= json_encode($token) ?>,obrig:<?= (int)$totalObrig ?>};</script>
</head>
<body>

<div class="bar">
  <div class="bar-in">
    <div class="prog"><i id="pi"></i></div>
    <div class="prog-t" id="pt">0% preenchido</div>
    <div class="saved" id="sv">salvo automaticamente</div>
  </div>
</div>

<header class="top">
  <div class="wrap">
    <div class="brand">Alma<i>.Convert</i><small>Agência Digital</small></div>
    <div class="rule"></div>
    <h1 class="doc-title">Briefing de <?= e(strtolower(nome_do_tipo($tipo))) ?></h1>
    <?php if ($nomeCliente): ?><p class="doc-cli"><?= e($nomeCliente) ?></p><?php endif; ?>
    <p class="doc-sub">Quanto mais específica a resposta, melhor o trabalho. Não precisa preencher tudo de uma vez — o formulário guarda sozinho o que você já escreveu.</p>
  </div>
</header>

<main class="wrap" id="form">

  <div class="note info" id="hint">
    <b>Suas respostas são salvas sozinhas.</b> Pode fechar a página e voltar quando quiser, de qualquer aparelho, usando este mesmo link. Não existe botão de enviar — assim que terminar, é só avisar no grupo.
  </div>

<?php foreach ($mapa as $bloco):
    $campos = $bloco['campos'] ?? [];
    if (($bloco['tipo'] ?? '') === 'grupo' && !$campos): ?>
      <h2 class="group"><?= e($bloco['titulo']) ?></h2>
      <?php continue;
    endif;
    if (!$campos) continue;
    $temOpc = false;
    foreach ($campos as $c) { if (!empty($c['opt'])) { $temOpc = true; break; } }
?>
  <?php if (($bloco['tipo'] ?? '') === 'grupo'): ?><h2 class="group"><?= e($bloco['titulo']) ?></h2><?php endif; ?>
  <section class="blk">
    <?php if (($bloco['tipo'] ?? '') === 'secao'): ?>
      <div class="blk-h">
        <h3><?= e($bloco['titulo']) ?><?= $temOpc ? ' <span class="opt">opcional</span>' : '' ?></h3>
        <?php if (!empty($bloco['nota'])): ?><p><?= e($bloco['nota']) ?></p><?php endif; ?>
      </div>
    <?php endif; ?>
    <?php foreach ($campos as $c):
      $attr = 'data-k="' . e($c['k']) . '"' . (!empty($c['opt']) ? ' data-opt="1"' : '');
      $ph   = e($c['ph'] ?? ''); ?>
      <div class="row">
        <div class="lab"><span><?= e($c['label']) ?></span><?= !empty($c['hint']) ? '<em>' . e($c['hint']) . '</em>' : '' ?></div>
        <div class="fld">
          <?php if (($c['tag'] ?? 'textarea') === 'input'): ?>
            <input type="text" <?= $attr ?> placeholder="<?= $ph ?>">
          <?php else: ?>
            <textarea <?= $attr ?> placeholder="<?= $ph ?>"></textarea>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
<?php endforeach; ?>

  <div class="actions" id="acts">
    <h3>Tudo salvo</h3>
    <p>Não é preciso enviar nada. O que você escreveu já está guardado com a gente. Se quiser uma cópia para você, gere o PDF.</p>
    <div class="btns"><button id="bPdf">Salvar em PDF</button></div>
    <div class="msg" id="msg"></div>
  </div>
</main>

<footer><p>Alma.Convert · Agência Digital — documento confidencial</p></footer>

<script>
(function(){
  var TOKEN=window.__BRIEFING__.token, LKEY='alma_briefing_'+TOKEN;
  var els=[].slice.call(document.querySelectorAll('[data-k]'));
  var bar=document.getElementById('pi'), ptxt=document.getElementById('pt'), sv=document.getElementById('sv');
  var msg=document.getElementById('msg');
  var pendente=false, salvando=false, ultimoOk=null;

  function autosize(t){ if(t.tagName==='TEXTAREA'){ t.style.height='auto'; t.style.height=(t.scrollHeight+2)+'px'; } }
  function collect(){ var o={}; els.forEach(function(e){ if(e.value.trim()) o[e.dataset.k]=e.value; }); return o; }
  function apply(o){ els.forEach(function(e){ if(o && o[e.dataset.k]!=null){ e.value=o[e.dataset.k]; autosize(e); } }); }

  function progress(){
    var obg=els.filter(function(e){ return !e.dataset.opt; });
    var n=obg.filter(function(e){return e.value.trim();}).length;
    var p=obg.length?Math.round(n/obg.length*100):0;
    bar.style.width=p+'%';
    ptxt.textContent = p>=100 ? 'tudo respondido' : p+'% preenchido';
  }

  function status(txt, cls){
    sv.textContent=txt;
    sv.className='saved on'+(cls?' '+cls:'');
    if(cls!=='erro'){ clearTimeout(status._t); status._t=setTimeout(function(){ sv.classList.remove('on'); },1800); }
  }

  // cópia local: se a internet cair, nada se perde
  function backup(){ try{ localStorage.setItem(LKEY, JSON.stringify(collect())); }catch(e){} }
  function backupLer(){ try{ var r=localStorage.getItem(LKEY); return r?JSON.parse(r):null; }catch(e){ return null; } }

  async function enviar(){
    if(salvando){ pendente=true; return; }
    salvando=true;
    var dados=collect();
    try{
      var r=await fetch('api.php?a=save&c='+encodeURIComponent(TOKEN),{
        method:'POST', headers:{'Content-Type':'application/json'},
        body:JSON.stringify({respostas:dados})
      });
      var j=await r.json();
      if(j && j.ok){ ultimoOk=new Date(); status('salvo'); }
      else { status('não consegui salvar — sua cópia local está guardada','erro'); }
    }catch(e){
      status('sem conexão — salvo neste aparelho, tentarei de novo','erro');
    }
    salvando=false;
    if(pendente){ pendente=false; agendar(0); }
  }

  var tmr;
  function agendar(ms){ clearTimeout(tmr); tmr=setTimeout(enviar, ms===undefined?1200:ms); }

  async function iniciar(){
    var doServidor=null;
    try{
      var r=await fetch('api.php?a=load&c='+encodeURIComponent(TOKEN),{cache:'no-store'});
      var j=await r.json();
      if(j && j.ok) doServidor=j.respostas;
    }catch(e){}

    var local=backupLer();
    // o servidor manda; o backup local só entra se o servidor vier vazio
    var base = (doServidor && Object.keys(doServidor).length) ? doServidor : (local||{});
    apply(base);
    progress();
    els.forEach(function(e){
      autosize(e);
      e.addEventListener('input',function(){ autosize(e); progress(); backup(); agendar(); });
      e.addEventListener('blur', function(){ agendar(200); });
    });
    // se o local tinha algo que o servidor não tinha, sobe agora
    if(local && doServidor && Object.keys(local).length && JSON.stringify(local)!==JSON.stringify(doServidor)){
      agendar(400);
    }
  }
  iniciar();

  // não deixa sair com alteração ainda não enviada
  window.addEventListener('beforeunload',function(ev){
    if(tmr && !ultimoOk){ return; }
    if(salvando || pendente){ ev.preventDefault(); ev.returnValue=''; }
  });

  document.getElementById('bPdf').addEventListener('click',function(){
    els.forEach(function(e){ autosize(e); }); window.print();
  });
})();
</script>
</body>
</html>
