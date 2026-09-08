<?php
// Campos do briefing de CONTEÚDO + TRÁFEGO PAGO.
// É o conteúdo completo mais um bloco enxuto de mídia paga. Para operações em que a
// conversão é direta e o conteúdo carrega a estratégia. Quando houver e-commerce ou
// investimento alto, usar o tipo "Tráfego performance", que é bem mais profundo.
$base = require __DIR__ . '/conteudo.php';

$midia = [
  ["tipo"=>"grupo","titulo"=>"Mídia paga","nota"=>"","campos"=>[]],
  [
    "tipo" => "secao",
    "titulo" => "7. Anúncios",
    "nota"  => "Bloco curto de propósito. O que a campanha precisa saber já está, em boa parte, nas respostas acima.",
    "campos" => [
      ["k"=>"ads_acao","label"=>"Que ação você quer que a pessoa tome ao ver o anúncio?","hint"=>"é o que define o objetivo da campanha","tag"=>"textarea","ph"=>"Mandar mensagem no WhatsApp, agendar, ligar, comprar, preencher formulário","opt"=>false],
      ["k"=>"ads_regiao","label"=>"Que região devemos alcançar?","hint"=>"","tag"=>"textarea","ph"=>"Cidade, bairros, raio em quilômetros, ou todo o Brasil","opt"=>false],
      ["k"=>"ads_investir","label"=>"Quanto pretende investir por mês em anúncios?","hint"=>"verba paga direto à plataforma, separada da mensalidade","tag"=>"input","ph"=>"","opt"=>false],
      ["k"=>"ads_antes","label"=>"Já anunciou antes? Como foi?","hint"=>"","tag"=>"textarea","ph"=>"O que funcionou e o que decepcionou — os dois lados ajudam","opt"=>false],
      ["k"=>"ads_nao","label"=>"Há algo que não deve ser anunciado?","hint"=>"","tag"=>"textarea","ph"=>"Serviço que vocês não fazem mais, produto sem estoque, procedimento que não quer divulgar","opt"=>false],
      ["k"=>"ads_capacidade","label"=>"Quantos contatos novos vocês conseguem atender por dia, com qualidade?","hint"=>"é este número que define até onde a campanha pode crescer","tag"=>"input","ph"=>"Sendo realista","opt"=>false],
      ["k"=>"ads_quemresponde","label"=>"Quem responde os contatos, e em quanto tempo?","hint"=>"","tag"=>"textarea","ph"=>"Nome de quem atende, horário, e o que acontece com quem chama fora dele","opt"=>false],
    ],
  ],
];

return array_merge($base, $midia);
