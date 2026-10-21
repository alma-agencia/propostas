<?php
// Campos do briefing de CONTEÚDO MENSAL.
// Briefing curto, repetido todo mês pela social media para montar o planejamento.
// Sem o bloco "Resultado esperado" (tipo marcado com sem_resultado em tipos.php).
// tag "nota" = avaliação de 1 a 5.
return [
  [
    "tipo" => "secao", "titulo" => "Planejamento do mês", "nota" => "Respostas curtas e diretas. Se nada mudou desde o mês passado, escreva \"sem mudanças\".", "campos" => [
      ["k"=>"mes_ref","label"=>"Mês do planejamento","hint"=>"","tag"=>"input","ph"=>"ex.: novembro/2026","opt"=>false],
      ["k"=>"m_objetivo","label"=>"Qual o objetivo do mês e a meta?","hint"=>"","tag"=>"input","ph"=>"ex.: 30 agendamentos, 20 orçamentos, 150 mensagens","opt"=>false],
      ["k"=>"m_foco","label"=>"Qual serviço ou produto deve ter mais destaque este mês?","hint"=>"","tag"=>"textarea","ph"=>"Se houver mais de um, na ordem de prioridade","opt"=>false],
      ["k"=>"m_datas","label"=>"Datas comerciais, eventos ou campanhas do mês","hint"=>"com o dia de cada uma","tag"=>"textarea","ph"=>"ex.: dia 12 — ação de Dia das Crianças; dia 25 — Black Friday","opt"=>false],
      ["k"=>"m_novidades","label"=>"Promoções, lançamentos ou novidades","hint"=>"com condição e prazo","tag"=>"textarea","ph"=>"ou \"nenhuma\"","opt"=>false],
      ["k"=>"m_duvidas","label"=>"Dúvidas e perguntas que os clientes fizeram no último mês","hint"=>"viram pauta de conteúdo","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"m_material","label"=>"Fotos, vídeos ou depoimentos disponíveis para o mês","hint"=>"e até que dia você consegue enviar","tag"=>"textarea","ph"=>"Se houver gravação ou captação prevista, informe a data","opt"=>false],
      ["k"=>"m_mudancas","label"=>"Mudou algo no negócio desde o mês passado?","hint"=>"equipe, horário, preço, endereço, serviço","tag"=>"textarea","ph"=>"","opt"=>false],
      ["k"=>"m_evitar","label"=>"Algum tema ou conteúdo que não deve ser abordado este mês?","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>true],
      ["k"=>"m_repetir","label"=>"Algum conteúdo do mês passado que quer repetir ou ajustar?","hint"=>"","tag"=>"textarea","ph"=>"","opt"=>true],
    ],
  ],
  [
    "tipo" => "secao", "titulo" => "Avaliação do mês anterior", "nota" => "Dê uma nota de 1 a 5, sendo 1 = ruim e 5 = excelente.", "campos" => [
      ["k"=>"sat_trabalho","label"=>"Qualidade dos conteúdos","hint"=>"textos, artes e vídeos publicados","tag"=>"nota","ph"=>"","opt"=>false],
      ["k"=>"sat_prazo","label"=>"Cumprimento de prazos","hint"=>"entregas e publicações no dia combinado","tag"=>"nota","ph"=>"","opt"=>false],
      ["k"=>"sat_atendimento","label"=>"Atendimento da equipe","hint"=>"agilidade, clareza e comunicação","tag"=>"nota","ph"=>"","opt"=>false],
      ["k"=>"sat_processo","label"=>"Facilidade do processo","hint"=>"briefing, aprovações e ajustes","tag"=>"nota","ph"=>"","opt"=>false],
      ["k"=>"sat_resultado","label"=>"Resultado do mês","hint"=>"o que o marketing trouxe para o negócio","tag"=>"nota","ph"=>"","opt"=>false],
      ["k"=>"sat_recomenda","label"=>"Chance de recomendar a Alma a um amigo ou colega","hint"=>"1 = nenhuma, 5 = com certeza","tag"=>"nota","ph"=>"","opt"=>false],
      ["k"=>"sat_obs","label"=>"O que podemos melhorar no próximo mês?","hint"=>"","tag"=>"textarea","ph"=>"Opcional","opt"=>true],
    ],
  ],
];
