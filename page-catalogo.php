<?php
/* Template Name: Catálogo */

$lang = get_query_var('te_lang') ?: 'pt';

$base_excl = 'https://tradeexpansion.com.br/exclusive/Fotos/';
$base_prem = 'https://tradeexpansion.com.br/exclusive/Fotos/premium/';

$materiais = [
  // ── EXCLUSIVE COLLECTION ──────────────────────────────
  [
    'id' => 'imperial-blue', 'grupo' => 'exclusive', 'exclusivo' => true,
    'nome'      => ['pt'=>'Imperial Blue',    'en'=>'Imperial Blue',    'es'=>'Imperial Blue'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito raro de coloração azul intensa com movimento elegante. Disponível exclusivamente através da Trade Expansion.',
      'en' => 'A rare quartzite with deep blue coloration and elegant natural movement. Available exclusively through Trade Expansion.',
      'es' => 'Cuarcita rara con coloración azul intensa y movimiento elegante. Disponible exclusivamente a través de Trade Expansion.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos, superfícies de destaque, móveis especiais', 'en'=>'Feature walls, statement surfaces, bespoke furniture', 'es'=>'Revestimientos, superficies de impacto, muebles especiales'],
    'acabamentos'=> ['pt'=>'Polido, Escovado', 'en'=>'Polished, Brushed', 'es'=>'Pulido, Cepillado'],
    'imagem'    => $base_excl . 'Chapa%20Azul%20Imperial.png',
    'galeria'   => [
      $base_excl . 'Chapa%20Azul%20Imperial.png',
      $base_excl . 'Imperial%20Blue%20-%20kitchen-island.png',
      $base_excl . 'Imperial%20Blue%20-%20table.png',
      $base_excl . 'Mesa%20-%20Imperial%20Blue.jpeg',
      $base_excl . 'Block%20-%20Imperial%20Blue.png',
    ],
  ],
  [
    'id' => 'seven-blue', 'grupo' => 'exclusive', 'exclusivo' => false,
    'nome'      => ['pt'=>'Seven Blue',       'en'=>'Seven Blue',       'es'=>'Seven Blue'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito de tons azulados sofisticados e movimento mineral único, ideal para projetos de arquitetura de alto impacto.',
      'en' => 'A quartzite with sophisticated blue tones and unique mineral movement, ideal for high-impact architectural projects.',
      'es' => 'Cuarcita con tonos azulados sofisticados y movimiento mineral único, ideal para proyectos de alto impacto.',
    ],
    'aplicacoes' => ['pt'=>'Salas de estar, banheiros, revestimentos internos', 'en'=>'Living rooms, bathrooms, interior cladding', 'es'=>'Salas, baños, revestimientos interiores'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_excl . 'Chapa%20Seven%20Blue.png',
    'galeria'   => [
      $base_excl . 'Chapa%20Seven%20Blue.png',
      $base_excl . 'Living%20Room%20-%20Seven%20Blue.png',
    ],
  ],
  [
    'id' => 'bonsai-crystal', 'grupo' => 'exclusive', 'exclusivo' => false,
    'nome'      => ['pt'=>'Bonsai Crystal',   'en'=>'Bonsai Crystal',   'es'=>'Bonsai Crystal'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito cristalino com movimentação orgânica e presença visual marcante. Um dos materiais mais procurados para projetos de luxo contemporâneo.',
      'en' => 'A crystalline quartzite with organic movement and striking visual presence. One of the most sought-after materials for contemporary luxury.',
      'es' => 'Cuarcita cristalina con movimiento orgánico y presencia visual destacada. Muy solicitada en proyectos de lujo contemporáneo.',
    ],
    'aplicacoes' => ['pt'=>'Bancadas, paredes de destaque, projetos residenciais premium', 'en'=>'Countertops, feature walls, premium residential', 'es'=>'Encimeras, paredes de destaque, residencial premium'],
    'acabamentos'=> ['pt'=>'Polido, Escovado', 'en'=>'Polished, Brushed', 'es'=>'Pulido, Cepillado'],
    'imagem'    => $base_prem . 'Bonsai%20Crystal.jpg',
    'galeria'   => [
      $base_prem . 'Bonsai%20Crystal.jpg',
      $base_excl . 'Bonsai%20Quartzite%20-%20Shopping%20mall.png',
      $base_excl . 'Bonsai%20Quartzite%20-%202Shopping%20mall.png',
    ],
  ],
  [
    'id' => 'bali-brown', 'grupo' => 'exclusive', 'exclusivo' => false,
    'nome'      => ['pt'=>'Bali Brown',       'en'=>'Bali Brown',       'es'=>'Bali Brown'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito de tons terrosos quentes com sofisticação natural. Traz identidade orgânica a interiores contemporâneos e cozinhas de alto padrão.',
      'en' => 'A warm earthy quartzite with natural sophistication. Brings organic identity to contemporary interiors and high-end kitchens.',
      'es' => 'Cuarcita de tonos terrosos cálidos con sofisticación natural. Identidad orgánica para interiores contemporáneos.',
    ],
    'aplicacoes' => ['pt'=>'Cozinhas, áreas externas, revestimentos', 'en'=>'Kitchens, outdoor areas, cladding', 'es'=>'Cocinas, áreas exteriores, revestimientos'],
    'acabamentos'=> ['pt'=>'Polido, Couro', 'en'=>'Polished, Leather', 'es'=>'Pulido, Cuero'],
    'imagem'    => $base_prem . 'Bali%20Brown.jpg',
    'galeria'   => [
      $base_prem . 'Bali%20Brown.jpg',
      $base_excl . 'Kitchen%20-%20Bali.png',
    ],
  ],
  [
    'id' => 'bali-crystal', 'grupo' => 'exclusive', 'exclusivo' => false,
    'nome'      => ['pt'=>'Bali Crystal',     'en'=>'Bali Crystal',     'es'=>'Bali Crystal'],
    'tipo'      => ['pt'=>'Cristal',          'en'=>'Crystal',          'es'=>'Cristal'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Expressão cristalina mais clara da família Bali, com luminosidade suave e movimento refinado. Presença elegante para projetos de luxo.',
      'en' => 'A lighter crystalline expression from the Bali family, with soft luminosity and refined movement. Elegant presence for luxury projects.',
      'es' => 'Expresión cristalina más clara de la familia Bali. Luminosidad suave y movimiento refinado para proyectos de lujo.',
    ],
    'aplicacoes' => ['pt'=>'Banheiros, spa, superfícies premium', 'en'=>'Bathrooms, spa, premium surfaces', 'es'=>'Baños, spa, superficies premium'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'Bali%20Crystal.JPG',
    'galeria'   => [
      $base_prem . 'Bali%20Crystal.JPG',
      $base_excl . 'Bali%20Crystal%20-%20Bathroom.png',
      $base_excl . 'Bali%20Crystal%20-%20Outdoor.png',
      $base_excl . 'Bali%20Crystal%20-%20Rooftop.png',
    ],
  ],
  [
    'id' => 'valenza-river', 'grupo' => 'exclusive', 'exclusivo' => false,
    'nome'      => ['pt'=>'Valenza River',    'en'=>'Valenza River',    'es'=>'Valenza River'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito com padrão de movimento fluido, evocando a natureza em sua forma mais elegante. Versátil para aplicações residenciais e comerciais.',
      'en' => 'A quartzite with flowing movement pattern, evoking nature in its most elegant form. Versatile for residential and commercial applications.',
      'es' => 'Cuarcita con patrón de movimiento fluido. Versátil para aplicaciones residenciales y comerciales de alto nivel.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos, bancadas, projetos de interiores', 'en'=>'Cladding, countertops, interior design', 'es'=>'Revestimientos, encimeras, interiores'],
    'acabamentos'=> ['pt'=>'Polido, Escovado', 'en'=>'Polished, Brushed', 'es'=>'Pulido, Cepillado'],
    'imagem'    => $base_prem . 'Valenza%20River.JPG',
    'galeria'   => [
      $base_prem . 'Valenza%20River.JPG',
      $base_excl . 'Valenza%20-%20Bar.png',
      $base_excl . 'Valenza%20-%201bar.png',
    ],
  ],

  // ── PREMIUM SELECTION ─────────────────────────────────
  [
    'id' => 'calacatta-lux', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Calacatta Lux',    'en'=>'Calacatta Lux',    'es'=>'Calacatta Lux'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito branco premium com veios dourados e bege. Elegância clássica que remete ao Calacatta italiano com qualidade brasileira.',
      'en' => 'Premium white quartzite with golden and beige veining. Classic elegance reminiscent of Italian Calacatta with Brazilian quality.',
      'es' => 'Cuarcita blanca premium con veteado dorado y beige. Elegancia clásica con calidad brasileña.',
    ],
    'aplicacoes' => ['pt'=>'Banheiros, cozinhas, bancadas premium', 'en'=>'Bathrooms, kitchens, premium countertops', 'es'=>'Baños, cocinas, encimeras premium'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'CALACATTA%20LUX.jpg',
    'galeria'   => [
      $base_prem . 'CALACATTA%20LUX.jpg',
      $base_prem . 'Calacatta%20Lux_CloseUp%20(2).jpg',
    ],
  ],
  [
    'id' => 'himalaya', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Himalaya',         'en'=>'Himalaya',         'es'=>'Himalaya'],
    'tipo'      => ['pt'=>'Granito',          'en'=>'Granite',          'es'=>'Granito'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito branco com veios cinza delicados e luminosidade natural. Referência para projetos que buscam leveza e sofisticação.',
      'en' => 'White quartzite with delicate grey veining and natural luminosity. The reference for projects seeking lightness and sophistication.',
      'es' => 'Cuarcita blanca con veteado gris delicado y luminosidad natural. Referencia para proyectos que buscan ligereza y sofisticación.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos, banheiros, projetos residenciais', 'en'=>'Cladding, bathrooms, residential projects', 'es'=>'Revestimientos, baños, proyectos residenciales'],
    'acabamentos'=> ['pt'=>'Polido, Honed', 'en'=>'Polished, Honed', 'es'=>'Pulido, Envejecido'],
    'imagem'    => $base_prem . 'Himalaya-chapa.jpg',
    'galeria'   => [
      $base_prem . 'Himalaya-chapa.jpg',
      $base_prem . 'Himalaya-close.jpg',
    ],
  ],
  [
    'id' => 'crystal-white', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Crystal White',    'en'=>'Crystal White',    'es'=>'Crystal White'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito de alta pureza com transparência cristalina e movimento sutil. Escolha premium para ambientes minimalistas e contemporâneos.',
      'en' => 'High-purity quartzite with crystalline transparency and subtle movement. Premium choice for minimalist and contemporary spaces.',
      'es' => 'Cuarcita de alta pureza con transparencia cristalina. Elección premium para espacios minimalistas y contemporáneos.',
    ],
    'aplicacoes' => ['pt'=>'Bancadas, banheiros, revestimentos internos', 'en'=>'Countertops, bathrooms, interior cladding', 'es'=>'Encimeras, baños, revestimientos interiores'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'Crystal-White.png',
    'galeria'   => [
      $base_prem . 'Crystal-White.png',
    ],
  ],
  [
    'id' => 'london-sky', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'London Sky',       'en'=>'London Sky',       'es'=>'London Sky'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito com tonalidade entre o branco e o cinza suave, com veios dramáticos que conferem profundidade e movimento únicos.',
      'en' => 'A quartzite ranging from white to soft grey, with dramatic veining that gives unique depth and movement.',
      'es' => 'Cuarcita entre blanco y gris suave, con veteado dramático que aporta profundidad y movimiento únicos.',
    ],
    'aplicacoes' => ['pt'=>'Paredes de destaque, bancadas, lobbies', 'en'=>'Feature walls, countertops, lobbies', 'es'=>'Paredes de destaque, encimeras, lobbies'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'LONDON%20SKY.JPG',
    'galeria'   => [
      $base_prem . 'LONDON%20SKY.JPG',
      $base_prem . 'London%20Sky_CloseUp%20(1).jpg',
    ],
  ],
  [
    'id' => 'fantasy-lux', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Fantasy Lux',      'en'=>'Fantasy Lux',      'es'=>'Fantasy Lux'],
    'tipo'      => ['pt'=>'Quartzito',        'en'=>'Quartzite',        'es'=>'Cuarcita'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito branco com movimento expressivo e veios contrastantes. Alta presença visual para projetos de design sofisticado.',
      'en' => 'White quartzite with expressive movement and contrasting veining. High visual impact for sophisticated design projects.',
      'es' => 'Cuarcita blanca con movimiento expresivo y veteado contrastante. Alto impacto visual para proyectos de diseño sofisticado.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos, bancadas, projetos de alto padrão', 'en'=>'Cladding, countertops, high-end projects', 'es'=>'Revestimientos, encimeras, proyectos de alto nivel'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'FANTASY%20LUX%2001.jpg',
    'galeria'   => [
      $base_prem . 'FANTASY%20LUX%2001.jpg',
      $base_prem . 'FANTASY%20LUX%2001(1)_CloseUp.jpg',
      $base_prem . 'FANTASY%20LUX%2002.JPG',
      $base_prem . 'FANTASY%20LUX%2002(1)_CloseUp.jpg',
    ],
  ],
  [
    'id' => 'bianco-romano', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Bianco Romano',    'en'=>'Bianco Romano',    'es'=>'Bianco Romano'],
    'tipo'      => ['pt'=>'Granito',          'en'=>'Granite',          'es'=>'Granito'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito branco com veios finos em cinza e dourado. Clássico e versátil, adequado para projetos residenciais e comerciais de alto padrão.',
      'en' => 'White quartzite with fine grey and golden veining. Classic and versatile, suitable for high-end residential and commercial projects.',
      'es' => 'Cuarcita blanca con veteado fino gris y dorado. Clásico y versátil para proyectos residenciales y comerciales de alto nivel.',
    ],
    'aplicacoes' => ['pt'=>'Pisos, revestimentos, bancadas', 'en'=>'Flooring, cladding, countertops', 'es'=>'Suelos, revestimientos, encimeras'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'BIANCO-ROMANO.jpg',
    'galeria'   => [
      $base_prem . 'BIANCO-ROMANO.jpg',
      $base_prem . 'BIANCO-ROMANO-CLOSE.jpg',
    ],
  ],
  [
    'id' => 'super-white', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Super White',      'en'=>'Super White',      'es'=>'Super White'],
    'tipo'      => ['pt'=>'Dolomítico',       'en'=>'Dolomitic',        'es'=>'Dolomítico'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Um dos quartzitos brancos mais reconhecidos do mercado internacional. Pureza, brilho e durabilidade para projetos de alto padrão.',
      'en' => 'One of the most recognized white quartzites in the international market. Purity, brilliance, and durability for high-end projects.',
      'es' => 'Una de las cuarcitas blancas más reconocidas internacionalmente. Pureza, brillo y durabilidad para proyectos de alto nivel.',
    ],
    'aplicacoes' => ['pt'=>'Banheiros, cozinhas, revestimentos internos', 'en'=>'Bathrooms, kitchens, interior cladding', 'es'=>'Baños, cocinas, revestimientos interiores'],
    'acabamentos'=> ['pt'=>'Polido, Honed', 'en'=>'Polished, Honed', 'es'=>'Pulido, Envejecido'],
    'imagem'    => $base_prem . 'Super-White.jpg',
    'galeria'   => [
      $base_prem . 'Super-White.jpg',
      $base_prem . 'Super-White-close.png',
    ],
  ],
  [
    'id' => 'oslo', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Oslo',             'en'=>'Oslo',             'es'=>'Oslo'],
    'tipo'      => ['pt'=>'Cristal',          'en'=>'Crystal',          'es'=>'Cristal'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito claro com movimento discreto e acabamento impecável. Elegância escandinava aplicada à riqueza mineral brasileira.',
      'en' => 'A light quartzite with subtle movement and impeccable finish. Scandinavian elegance applied to Brazilian mineral richness.',
      'es' => 'Cuarcita clara con movimiento discreto y acabado impecable. Elegancia escandinava aplicada a la riqueza mineral brasileña.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos, banheiros, ambientes corporativos', 'en'=>'Cladding, bathrooms, corporate spaces', 'es'=>'Revestimientos, baños, espacios corporativos'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'Oslo-chapa.jpg',
    'galeria'   => [
      $base_prem . 'Oslo-chapa.jpg',
      $base_prem . 'Oslo-close.png',
    ],
  ],
  [
    'id' => 'salvatore', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Salvatore',        'en'=>'Salvatore',        'es'=>'Salvatore'],
    'tipo'      => ['pt'=>'Dolomítico',       'en'=>'Dolomitic',        'es'=>'Dolomítico'],
    'origem'    => ['pt'=>'Brasil',           'en'=>'Brazil',           'es'=>'Brasil'],
    'descricao' => [
      'pt' => 'Quartzito com padrão visual sofisticado e movimento característico. Uma pedra com personalidade para projetos que exigem exclusividade.',
      'en' => 'A quartzite with sophisticated visual pattern and characteristic movement. A stone with personality for projects demanding exclusivity.',
      'es' => 'Cuarcita con patrón visual sofisticado y movimiento característico. Una piedra con personalidad para proyectos exclusivos.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos de destaque, bancadas, projetos especiais', 'en'=>'Feature cladding, countertops, special projects', 'es'=>'Revestimientos de destaque, encimeras, proyectos especiales'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'Salvatore.jpg',
    'galeria'   => [
      $base_prem . 'Salvatore.jpg',
      $base_prem . 'Salvatore-Close%20Up.jpg',
    ],
  ],
  [
    'id' => 'itaunas', 'grupo' => 'premium', 'exclusivo' => false,
    'nome'      => ['pt'=>'Itaúnas',          'en'=>'Itaúnas',          'es'=>'Itaúnas'],
    'tipo'      => ['pt'=>'Granito',          'en'=>'Granite',          'es'=>'Granito'],
    'origem'    => ['pt'=>'Espírito Santo, Brasil', 'en'=>'Espírito Santo, Brazil', 'es'=>'Espírito Santo, Brasil'],
    'descricao' => [
      'pt' => 'Quartzito brasileiro com tons claros e movimento natural suave. Origem no Espírito Santo, com qualidade certificada para exportação.',
      'en' => 'Brazilian quartzite with light tones and soft natural movement. Origin in Espírito Santo, with certified export quality.',
      'es' => 'Cuarcita brasileña con tonos claros y movimiento natural suave. Origen en Espírito Santo, con calidad certificada para exportación.',
    ],
    'aplicacoes' => ['pt'=>'Revestimentos, bancadas, projetos residenciais', 'en'=>'Cladding, countertops, residential projects', 'es'=>'Revestimientos, encimeras, proyectos residenciales'],
    'acabamentos'=> ['pt'=>'Polido', 'en'=>'Polished', 'es'=>'Pulido'],
    'imagem'    => $base_prem . 'Itaunas-chapa.jpg',
    'galeria'   => [
      $base_prem . 'Itaunas-chapa.jpg',
      $base_prem . 'Itaunas-close.jpg',
      $base_prem . 'Aeroporto-de-Dubai-Itaunas-1.jpg',
    ],
  ],
];

// Dicionário de traduções p/ o restante da página
$t = [
  'meta_title' => [
    'pt' => 'Catálogo de Rochas Ornamentais Brasileiras | Trade Expansion',
    'en' => 'Brazilian Ornamental Stone Catalog | Trade Expansion',
    'es' => 'Catálogo de Piedras Ornamentales Brasileñas | Trade Expansion'
  ],
  'meta_desc' => [
    'pt' => 'Explore o catálogo de rochas ornamentais brasileiras da Trade Expansion — quartzitos exóticos, mármores e granitos para importadores internacionais. Solicite disponibilidade.',
    'en' => 'Explore Trade Expansion\'s Brazilian ornamental stone catalog — exotic quartzites, marbles and granites for international importers. Request current availability.',
    'es' => 'Explore el catálogo de piedras ornamentales brasileñas de Trade Expansion — cuarcitas exóticas, mármoles y granitos para importadores internacionales.'
  ],
  'hero_kicker' => [
    'pt' => 'Rochas Ornamentais Brasileiras · Curadoria Boutique',
    'en' => 'Brazilian Ornamental Stones · Boutique Curation',
    'es' => 'Piedras Ornamentales Brasileñas · Curaduría Boutique'
  ],
  'hero_h1' => [
    'pt' => 'Catálogo de Materiais',
    'en' => 'Material Catalog',
    'es' => 'Catálogo de Materiales'
  ],
  'hero_sub' => [
    'pt' => 'Quartzitos, mármores e granitos brasileiros selecionados para importadores internacionais. Trabalhamos sob demanda — consulte disponibilidade atual.',
    'en' => 'Selected Brazilian quartzites, marbles, and granites for international importers. We work on demand — contact us for current availability.',
    'es' => 'Cuarcitas, mármoles y granitos brasileños seleccionados para importadores internacionales. Trabajamos bajo demanda — consulte disponibilidad actual.'
  ],
  'btn_availability' => [
    'pt' => 'Consultar disponibilidade',
    'en' => 'Check availability',
    'es' => 'Consultar disponibilidad'
  ],
  'btn_offers' => [
    'pt' => 'Ver ofertas ativas →',
    'en' => 'View active offers →',
    'es' => 'Ver ofertas activas →'
  ],
  'filter_all' => [
    'pt' => 'Todos', 'en' => 'All', 'es' => 'Todos'
  ],
  'filter_quartzite' => [
    'pt' => 'Quartzito', 'en' => 'Quartzite', 'es' => 'Cuarcita'
  ],
  'filter_granite' => [
    'pt' => 'Granito', 'en' => 'Granite', 'es' => 'Granito'
  ],
  'banner_search_title' => [
    'pt' => '"Não encontrou o que procura?"',
    'en' => '"Don\'t see what you\'re looking for?"',
    'es' => '"¿No encontró lo que busca?"'
  ],
  'banner_search_text' => [
    'pt' => 'Trabalhamos com qualquer rocha ornamental brasileira sob demanda. Se você procura um material específico, origem, acabamento ou faixa de preço — entre em contato e buscamos para você.',
    'en' => 'We source any Brazilian natural stone on demand. If you\'re looking for a specific material, origin, finish, or price point — reach out and we\'ll find it for you.',
    'es' => 'Trabajamos con cualquier piedra ornamental brasileña bajo demanda. Si busca un material específico, origen, acabado o rango de precio — contáctenos y lo encontramos.'
  ],
  'banner_offers_text' => [
    'pt' => '"Procurando estoque atual com preços e disponibilidade? Veja nossas ofertas ativas."',
    'en' => '"Looking for current stock with pricing and availability? View our active offers."',
    'es' => '"¿Busca stock actual con precios y disponibilidad? Vea nuestras ofertas activas."'
  ]
];

// Meta tags SEO
add_action('wp_head', function() use ($lang, $t) {
  echo '<title>' . esc_attr($t['meta_title'][$lang]) . '</title>' . "\n";
  echo '<meta name="description" content="' . esc_attr($t['meta_desc'][$lang]) . '">' . "\n";
}, 1);

get_header();
?>

<style>
/* 
  SISTEMA TE- 
*/
:root {
  --green: #102724;
  --gold: #D6A354;
  --cream: #F1F1D9;
  --secondary: #5D2713;
  --body-font: 'Vollkorn', serif;
}

body, html {
  margin: 0;
  padding: 0;
  font-family: var(--body-font);
  background-color: var(--green);
  color: var(--cream);
  overflow-x: hidden;
}

/* Tipografia e botões */
.te-h1 { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 700; line-height: 1.1; margin-bottom: 1.5rem; }
.te-h2 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; line-height: 1.2; margin-bottom: 1rem; }
.te-kicker { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: var(--gold); margin-bottom: 1rem; display: block; }

.te-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 1rem 2rem;
  border-radius: 999px;
  font-size: 0.9rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  text-decoration: none;
  transition: all 0.3s ease;
  cursor: pointer;
}
.te-btn--gold { background: var(--gold); color: var(--secondary); }
.te-btn--gold:hover { background: #e8b665; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(214,163,84,0.3); }
.te-btn--outline { border: 1px solid var(--gold); color: var(--gold); }
.te-btn--outline:hover { background: var(--gold); color: var(--secondary); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(214,163,84,0.2); }

/* Layout e Seções */
.te-wrap { max-width: 1280px; margin: 0 auto; padding: 0 2rem; width: 100%; box-sizing: border-box; }
.te-band { padding: 6rem 0; }
.te-band--green { background-color: var(--green); color: var(--cream); }
.te-band--cream { background-color: var(--cream); color: var(--green); }

/* Hero Específico */
.te-hero {
  position: relative;
  min-height: 70vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  background: radial-gradient(circle at center, rgba(214,163,84,0.15) 0%, rgba(16,39,36,1) 70%);
  border-bottom: 1px solid rgba(214,163,84,0.2);
}
.te-hero__content { position: relative; z-index: 10; max-width: 800px; margin: 0 auto; }
.te-hero__sub { font-size: 1.25rem; line-height: 1.6; color: rgba(241,241,217,0.8); margin-bottom: 2.5rem; }
.te-hero__actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

/* Grid de Catálogo */
.te-filters { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.8rem; margin-bottom: 3rem; }
.te-filter-pill {
  padding: 0.6rem 1.2rem;
  border-radius: 9999px;
  border: 1px solid rgba(214,163,84,0.25);
  background: transparent;
  color: rgba(241,241,217,0.7);
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  cursor: pointer;
  transition: all 0.2s ease;
}
.te-filter-pill:hover,
.te-filter-pill.active {
  background: var(--gold);
  color: var(--secondary);
  border-color: var(--gold);
}

.te-mat-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.2rem;
  margin-top: 2.4rem;
}
@media (max-width: 1024px) { .te-mat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .te-mat-grid { grid-template-columns: 1fr; } }

.te-mat-card {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  height: 380px;
  border: 1px solid rgba(214,163,84,0.15);
  transition: transform 0.3s ease, border-color 0.3s ease;
}
.te-mat-card:hover {
  transform: translateY(-6px);
  border-color: rgba(214,163,84,0.4);
}
.te-mat-card__img-wrap {
  width: 100%;
  height: 100%;
  position: absolute;
  inset: 0;
  cursor: zoom-in;
  overflow: hidden;
}
.te-mat-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}
.te-mat-card:hover .te-mat-card__img {
  transform: scale(1.05);
}
.te-mat-card__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(16,39,36,0.95) 0%, rgba(16,39,36,0.2) 60%, transparent 100%);
  transition: background 0.3s ease;
  pointer-events: none;
}
.te-mat-card:hover .te-mat-card__overlay {
  background: linear-gradient(to top, rgba(16,39,36,0.98) 0%, rgba(16,39,36,0.7) 100%);
}
.te-mat-card__content {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 1.5rem;
  color: var(--cream);
  pointer-events: none; /* Let clicks pass through to img-wrap except for btn */
}
.te-mat-card__title { font-size: 1.6rem; font-weight: 700; margin: 0.5rem 0; }
.te-mat-card__meta { font-size: 0.8rem; color: rgba(241,241,217,0.7); display: flex; justify-content: space-between; align-items: center; pointer-events: auto; }
.te-mat-card__desc {
  font-size: 0.9rem;
  line-height: 1.6;
  opacity: 0;
  max-height: 0;
  overflow: hidden;
  transition: opacity 0.3s ease, max-height 0.3s ease;
  margin-bottom: 0;
}
.te-mat-card:hover .te-mat-card__desc {
  opacity: 0.9;
  max-height: 120px;
  margin-bottom: 1rem;
}
.te-mat-card__btn {
  display: inline-block;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  color: var(--gold);
  text-decoration: none;
  opacity: 0;
  transform: translateY(10px);
  transition: all 0.3s ease;
}
.te-mat-card:hover .te-mat-card__btn {
  opacity: 1;
  transform: translateY(0);
}
.te-mat-card__placeholder {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(214,163,84,0.15) 0%, rgba(16,39,36,0.8) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: rgba(214,163,84,0.5);
  text-align: center;
  padding: 1rem;
}
.te-mat-badge {
  display: inline-flex;
  align-items: center;
  padding: 0.3rem 0.8rem;
  border-radius: 9999px;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 0.6rem;
  margin-right: 0.4rem;
}
.te-mat-badge--exclusive { background: var(--gold); color: var(--secondary); }
.te-mat-badge--type { background: rgba(241,241,217,0.12); color: rgba(241,241,217,0.8); border: 1px solid rgba(241,241,217,0.2); }

/* Banners */
.te-banner-text { text-align: center; max-width: 800px; margin: 0 auto; }
.te-banner-compact { padding: 4rem 0; text-align: center; border-top: 1px solid rgba(214,163,84,0.2); }
</style>

<!-- HERO -->
<section class="te-hero">
  <div class="te-wrap">
    <div class="te-hero__content fade-in-up">
      <span class="te-kicker"><?php echo $t['hero_kicker'][$lang]; ?></span>
      <h1 class="te-h1"><?php echo $t['hero_h1'][$lang]; ?></h1>
      <p class="te-hero__sub"><?php echo $t['hero_sub'][$lang]; ?></p>
      <div class="te-hero__actions">
        <a href="https://wa.me/5527992284517" target="_blank" class="te-btn te-btn--gold"><?php echo $t['btn_availability'][$lang]; ?></a>
        <a href="https://offers.tradeexpansion.com.br" class="te-btn te-btn--outline"><?php echo $t['btn_offers'][$lang]; ?></a>
      </div>
    </div>
  </div>
</section>

<!-- CATÁLOGO / GRID -->
<section class="te-band te-band--green">
  <div class="te-wrap">
    
    <div class="te-filters fade-in-up">
      <button class="te-filter-pill active" data-filter="all"><?php echo $t['filter_all'][$lang]; ?></button>
      <button class="te-filter-pill" data-filter="exclusive">Exclusive Collection</button>
      <button class="te-filter-pill" data-filter="premium">Premium Selection</button>
      <button class="te-filter-pill" data-filter="quartzite"><?php echo $t['filter_quartzite'][$lang]; ?></button>
      <button class="te-filter-pill" data-filter="granite"><?php echo $t['filter_granite'][$lang]; ?></button>
      <button class="te-filter-pill" data-filter="dolomitic">Dolomítico</button>
      <button class="te-filter-pill" data-filter="crystal">Cristal</button>
    </div>

    <div class="te-mat-grid">
      <?php foreach ($materiais as $mat) : 
        $tipo_filter = strtolower($mat['tipo']['en']); // usa inglês (quartzite/granite/dolomitic/crystal) para padronizar o filtro no JS
        $wa_msg = urlencode("Hi, I'm interested in " . $mat['nome']['en'] . " — please send current availability information.");
        $wa_link = "https://wa.me/5527992284517?text=" . $wa_msg;
        
        $galeria_json = json_encode(array_values($mat['galeria']));
        $nome_json    = json_encode($mat['nome'][$lang]);
      ?>
      <div class="te-mat-card-wrap fade-in-up" data-grupo="<?php echo esc_attr($mat['grupo']); ?>" data-tipo="<?php echo esc_attr($tipo_filter); ?>">
        <div class="te-mat-card">
          <div class="te-mat-card__img-wrap" onclick='openLightbox(<?php echo $galeria_json; ?>, 0, <?php echo htmlspecialchars($nome_json, ENT_QUOTES, 'UTF-8'); ?>)'>
            <?php if (!empty($mat['imagem'])) : ?>
              <img src="<?php echo esc_url($mat['imagem']); ?>" alt="<?php echo esc_attr($mat['nome'][$lang]); ?>" class="te-mat-card__img" loading="lazy">
            <?php else : ?>
              <div class="te-mat-card__placeholder"><?php echo esc_html($mat['nome'][$lang]); ?></div>
            <?php endif; ?>
            
            <div class="te-mat-card__overlay"></div>
          </div>
          
          <div class="te-mat-card__content">
            <?php if ($mat['exclusivo']) : ?>
              <span class="te-mat-badge te-mat-badge--exclusive">Exclusive</span>
            <?php endif; ?>
            <span class="te-mat-badge te-mat-badge--type"><?php echo esc_html($mat['tipo'][$lang]); ?></span>
            
            <h3 class="te-mat-card__title"><?php echo esc_html($mat['nome'][$lang]); ?></h3>
            
            <div class="te-mat-card__desc">
              <?php echo esc_html($mat['descricao'][$lang]); ?>
            </div>
            
            <div class="te-mat-card__meta">
              <span>📍 <?php echo esc_html($mat['origem'][$lang]); ?></span>
              <a href="<?php echo esc_url($wa_link); ?>" target="_blank" class="te-mat-card__btn" onclick="event.stopPropagation();">
                <?php echo $t['btn_availability'][$lang]; ?> →
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- BANNER: BUSCA SOB DEMANDA -->
<section class="te-band te-band--cream">
  <div class="te-wrap">
    <div class="te-banner-text fade-in-up">
      <h2 class="te-h2"><?php echo $t['banner_search_title'][$lang]; ?></h2>
      <p style="font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;"><?php echo $t['banner_search_text'][$lang]; ?></p>
      <a href="https://wa.me/5527992284517" target="_blank" class="te-btn te-btn--gold" style="background:var(--green); color:var(--cream);">
        <?php echo $t['btn_availability'][$lang]; ?>
      </a>
    </div>
  </div>
</section>

<!-- BANNER: OFERTAS ATIVAS -->
<section class="te-band--green te-banner-compact">
  <div class="te-wrap fade-in-up">
    <p style="font-size: 1.2rem; margin-bottom: 1.5rem; font-weight: 600;">
      <?php echo $t['banner_offers_text'][$lang]; ?>
    </p>
    <a href="https://offers.tradeexpansion.com.br" class="te-btn te-btn--gold"><?php echo $t['btn_offers'][$lang]; ?></a>
  </div>
</section>

<!-- LIGHTBOX -->
<div id="te-lightbox" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:99999; align-items:center; justify-content:center; flex-direction:column;">
  <button id="te-lb-close" style="position:absolute; top:1.5rem; right:2rem; background:none; border:none; color:#F1F1D9; font-size:2rem; cursor:pointer; z-index:2;">✕</button>
  <button id="te-lb-prev" style="position:absolute; left:1.5rem; background:rgba(214,163,84,0.2); border:1px solid rgba(214,163,84,0.4); border-radius:50%; width:48px; height:48px; color:#D6A354; font-size:1.4rem; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:2;">‹</button>
  <button id="te-lb-next" style="position:absolute; right:1.5rem; background:rgba(214,163,84,0.2); border:1px solid rgba(214,163,84,0.4); border-radius:50%; width:48px; height:48px; color:#D6A354; font-size:1.4rem; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:2;">›</button>
  <img id="te-lb-img" src="" alt="" style="max-width:90vw; max-height:85vh; object-fit:contain; border-radius:8px;">
  <div id="te-lb-counter" style="color:rgba(241,241,217,0.6); font-size:0.85rem; margin-top:1rem; letter-spacing:0.1em;"></div>
  <div id="te-lb-name" style="color:#D6A354; font-size:1rem; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; margin-top:0.4rem;"></div>
</div>

<script>
// JS para Filtros
document.addEventListener('DOMContentLoaded', function() {
  const pills = document.querySelectorAll('.te-filter-pill');
  const cards = document.querySelectorAll('.te-mat-card-wrap');
  
  pills.forEach(pill => {
    pill.addEventListener('click', function() {
      // Remove class active de todos e adiciona no clicado
      pills.forEach(p => p.classList.remove('active'));
      this.classList.add('active');
      
      const filter = this.dataset.filter;
      
      cards.forEach(card => {
        if (filter === 'all' || card.dataset.grupo === filter || card.dataset.tipo === filter) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // Fade-in animation
  const fadeEls = document.querySelectorAll('.fade-in-up');
  
  if (typeof IntersectionObserver !== 'undefined') {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.style.opacity = 1;
          e.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.15 });

    fadeEls.forEach(el => {
      el.style.opacity = 0;
      el.style.transform = 'translateY(24px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });
  } else {
    // Fallback if IntersectionObserver is not supported
    fadeEls.forEach(el => {
      el.style.opacity = 1;
      el.style.transform = 'translateY(0)';
    });
  }
});

// Lightbox com carrossel
const lightbox = document.getElementById('te-lightbox');
const lbImg    = document.getElementById('te-lb-img');
const lbClose  = document.getElementById('te-lb-close');
const lbPrev   = document.getElementById('te-lb-prev');
const lbNext   = document.getElementById('te-lb-next');
const lbCounter = document.getElementById('te-lb-counter');
const lbName   = document.getElementById('te-lb-name');

let lbGaleria = [];
let lbIndex   = 0;

function openLightbox(galeria, index, nome) {
  lbGaleria = galeria;
  lbIndex   = index;
  lbImg.src = galeria[index];
  lbName.textContent = nome;
  lbCounter.textContent = (index + 1) + ' / ' + galeria.length;
  lbPrev.style.display = galeria.length > 1 ? 'flex' : 'none';
  lbNext.style.display = galeria.length > 1 ? 'flex' : 'none';
  lightbox.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  lightbox.style.display = 'none';
  document.body.style.overflow = '';
}

function lbNavigate(dir) {
  lbIndex = (lbIndex + dir + lbGaleria.length) % lbGaleria.length;
  lbImg.src = lbGaleria[lbIndex];
  lbCounter.textContent = (lbIndex + 1) + ' / ' + lbGaleria.length;
}

if(lbClose) lbClose.addEventListener('click', closeLightbox);
if(lbPrev) lbPrev.addEventListener('click', () => lbNavigate(-1));
if(lbNext) lbNext.addEventListener('click', () => lbNavigate(1));
if(lightbox) lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
document.addEventListener('keydown', e => {
  if (lightbox && lightbox.style.display === 'flex') {
    if (e.key === 'ArrowLeft')  lbNavigate(-1);
    if (e.key === 'ArrowRight') lbNavigate(1);
    if (e.key === 'Escape')     closeLightbox();
  }
});
</script>

<?php get_footer(); ?>
