<?php
// Campos do briefing de CONTEÚDO.
// Estrutura: blocos na ordem de exibição. 'grupo' é só um título; 'secao' é um cartão com campos.
return [
  [
    "tipo" => "secao", "titulo" => "Confirmações de dados", "nota" => "", "campos" => [
      ["k"=>"emp_nome","label"=>"Nome da empresa ou profissional","hint"=>"","tag"=>"input","ph"=>"Como consta oficialmente","opt"=>false],
      ["k"=>"como_chamar","label"=>"Como quer ser chamado nas publicações","hint"=>"é assim que vamos escrever em toda legenda","tag"=>"input","ph"=>"Dr. Rafael, Rafael Leal, a clínica…","opt"=>false],
      ["k"=>"segmento","label"=>"Segmento ou especialidade","hint"=>"","tag"=>"input","ph"=>"","opt"=>false],
      ["k"=>"registro","label"=>"Registro profissional","hint"=>"se a sua profissão exige que apareça na peça","tag"=>"input","ph"=>"CRM, CRO, CRP, RQE — deixe em branco se não se aplica","opt"=>false],
      ["k"=>"local","label"=>"Cidade e onde atende","hint"=>"","tag"=>"textarea","ph"=>"Endereços, bairros, e se atende on-line","opt"=>false],
      ["k"=>"site","label"=>"Site","hint"=>"","tag"=>"input","ph"=>"https:// — ou deixe em branco se não tem","opt"=>false],
      ["k"=>"perfis","label"=>"Perfis que vamos cuidar","hint"=>"","tag"=>"textarea","ph"=>"@ de cada rede social","opt"=>false],
      ["k"=>"aprovador","label"=>"Quem aprova o conteúdo","hint"=>"nome, por onde falamos e em quanto tempo costuma responder","tag"=>"textarea","ph"=>"É a informação que mais atrasa entrega quando falta","opt"=>false],
    ],
  ],
  ["tipo"=>"grupo","titulo"=>"A marca","nota"=>"","campos"=>[]],
  [
    "tipo" => "secao", "titulo" => "1. Posicionamento", "nota" => "", "campos" => [
      ["k"=>"pos_frase","label"=>"O que vocês fazem, numa frase que um leigo entenda","hint"=>"","tag"=>"textarea","ph"=>"Sem jargão da área","opt"=>false],
      ["k"=>"pos_paraquem","label"=>"Para quem vocês fazem isso","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"pos_lembranca","label"=>"Se a pessoa lembrasse de uma só coisa sobre vocês, qual deveria ser?","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"pos_tom3","label"=>"Três palavras que descrevem o tom da marca","hint"=>"","tag"=>"input","ph"=>"ex.: acolhedor, técnico, direto","opt"=>false],
      ["k"=>"pos_naoe","label"=>"Três palavras que a marca não é","hint"=>"evita meia dúzia de retrabalhos lá na frente","tag"=>"input","ph"=>"ex.: informal, apelativa, sensacionalista","opt"=>false],
    ],
  ],
  [
    "tipo" => "secao", "titulo" => "2. Público", "nota" => "", "campos" => [
      ["k"=>"pub_quer","label"=>"Quem você quer atrair","hint"=>"pode ser diferente de quem você já atende hoje","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"pub_duvida","label"=>"Qual dúvida ou problema essa pessoa traz quando procura vocês?","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"pub_acreditar","label"=>"O que ela precisa acreditar antes de decidir fechar?","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"pub_obj","label"=>"Objeções mais comuns","hint"=>"","tag"=>"textarea","ph"=>"O que faz a pessoa hesitar, adiar ou desistir","opt"=>false],
      ["k"=>"pub_nao","label"=>"Quem não é seu público","hint"=>"","tag"=>"textarea","ph"=>"Quem você prefere não atrair — evita conteúdo que traz o cliente errado","opt"=>false],
    ],
  ],
  ["tipo"=>"grupo","titulo"=>"O conteúdo","nota"=>"","campos"=>[]],
  [
    "tipo" => "secao", "titulo" => "3. Linha editorial", "nota" => "", "campos" => [
      ["k"=>"ed_temas","label"=>"Temas que você domina e gosta de falar","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"ed_evitar","label"=>"Temas que prefere não abordar","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"ed_perguntas","label"=>"As perguntas que mais te fazem no dia a dia","hint"=>"pode listar quantas lembrar — é daqui que sai boa parte do calendário","tag"=>"textarea","ph"=>"Aquilo que todo cliente ou paciente pergunta, sempre","opt"=>false],
      ["k"=>"ed_historias","label"=>"Histórias, casos ou bastidores que podem virar conteúdo","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"ed_prioridade","label"=>"Serviços que precisam de destaque, e em que ordem","hint"=>"","tag"=>"textarea","ph"=>"O que você mais quer vender, do primeiro ao último","opt"=>false],
    ],
  ],
  [
    "tipo" => "secao", "titulo" => "4. Voz e linguagem", "nota" => "", "campos" => [
      ["k"=>"voz_trato","label"=>"Trata o público por você ou senhor? Mais próximo ou mais formal?","hint"=>"","tag"=>"input","ph"=>"","opt"=>false],
      ["k"=>"voz_recursos","label"=>"Usa emoji? Humor? Gíria?","hint"=>"","tag"=>"input","ph"=>"","opt"=>false],
      ["k"=>"voz_sempre","label"=>"Palavras e termos que devemos sempre usar","hint"=>"","tag"=>"textarea","ph"=>"Como você nomeia o que faz, o jeito certo de escrever o serviço","opt"=>false],
      ["k"=>"voz_nunca","label"=>"Palavras e termos proibidos","hint"=>"","tag"=>"textarea","ph"=>"Promessas, comparações, termos que você não assina","opt"=>false],
      ["k"=>"voz_bons","label"=>"Publicações suas que representam bem a marca","hint"=>"cole os links","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"voz_ruins","label"=>"Publicações que não representam — e o que houve de errado","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
    ],
  ],
  [
    "tipo" => "secao", "titulo" => "5. Referências e concorrência", "nota" => "", "campos" => [
      ["k"=>"ref_admira","label"=>"Perfis do seu setor que você admira, e o que admira neles","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"ref_naoparecer","label"=>"Perfis com quem você não quer se parecer","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"ref_posts","label"=>"Publicações específicas de referência","hint"=>"cole os links","tag"=>"textarea","ph"=>"Podem ser de qualquer setor","opt"=>false],
      ["k"=>"ref_naofunciona","label"=>"O que os outros fazem no seu setor que você acha que não funciona?","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
    ],
  ],
  [
    "tipo" => "secao", "titulo" => "6. Restrições", "nota" => "", "campos" => [
      ["k"=>"res_nunca","label"=>"O que nunca pode aparecer nas publicações","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"res_pessoas","label"=>"Pessoas que não podem ser identificadas","hint"=>"","tag"=>"textarea","ph"=>"Clientes, pacientes, equipe, terceiros","opt"=>false],
      ["k"=>"res_sensiveis","label"=>"Assuntos sensíveis a evitar","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"res_aprovacao","label"=>"Precisa de aprovação de terceiros?","hint"=>"","tag"=>"textarea","ph"=>"Sócio, jurídico, franqueadora","opt"=>false],
    ],
  ],
];
