<?php
// ─── Tipos de briefing da agência ────────────────────────────────────────────
// Todo tipo recebe automaticamente o bloco final "Resultado esperado".
// Para criar um tipo novo: adicione a entrada aqui e o arquivo em campos/.
return [
  'conteudo' => [
    'nome'      => 'Conteúdo',
    'resumo'    => 'Estratégia, linha editorial, voz e identidade da marca. Sem mídia paga.',
    'arquivo'   => 'conteudo.php',
    'ativo'     => true,
  ],
  'conteudo-trafego' => [
    'nome'      => 'Conteúdo + Tráfego pago',
    'resumo'    => 'O briefing de conteúdo com um bloco enxuto de anúncios. Para operações em que a conversão é direta e o conteúdo carrega a estratégia.',
    'arquivo'   => 'conteudo-trafego.php',
    'ativo'     => true,
  ],
  'trafego' => [
    'nome'      => 'Tráfego performance',
    'resumo'    => 'O briefing completo de mídia paga. Use quando houver e-commerce, investimento alto ou operação comercial complexa.',
    'arquivo'   => 'trafego.php',
    'ativo'     => true,
  ],
  'crm-ia' => [
    'nome'      => 'CRM com IA',
    'resumo'    => 'Funil, etapas, regras de qualificação e base de conhecimento do agente.',
    'arquivo'   => null,
    'ativo'     => false,
    'aviso'     => 'Em construção — ainda não é possível criar briefings deste tipo.',
  ],
];
