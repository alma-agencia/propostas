<?php
// Bloco final comum a TODOS os tipos de briefing.
// É a pergunta que alinha expectativa — nenhum tipo deve existir sem ela.
return [
  [
    "tipo" => "secao",
    "titulo" => "Resultado esperado",
    "nota"  => "As duas perguntas mais importantes deste briefing. É por elas que vamos medir se o trabalho está no caminho certo.",
    "campos" => [
      ["k"=>"res_espera","label"=>"Qual resultado você espera?","hint"=>"","tag"=>"textarea","ph"=>"Com suas palavras, sem se preocupar com métrica","opt"=>false],
      ["k"=>"res_6m","label"=>"O que precisa acontecer em 6 meses para você dizer que o marketing deu resultado?","hint"=>"se puder, responda com número","tag"=>"textarea","ph"=>"Sendo realista. É esta resposta que vamos perseguir.","opt"=>false],
      ["k"=>"res_numero","label"=>"Qual número importa mais para você?","hint"=>"","tag"=>"input","ph"=>"Agendamentos, vendas, orçamentos, mensagens, seguidores…","opt"=>true],
      ["k"=>"res_hoje","label"=>"Onde vocês estão hoje nesse número?","hint"=>"","tag"=>"input","ph"=>"Serve de ponto de partida para comparar depois","opt"=>true],
    ],
  ],
];
