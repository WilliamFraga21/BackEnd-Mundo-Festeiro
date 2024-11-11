INSERT INTO `mundofesteirobd2`.`produtos` (`Nome_Produto`, `Descricao`, `categorias_id`, `subcategorias_id`, `Status`)
VALUES
-- Produtos de Balões (categoria_id: 1)
('Balão Azul Metálico', 'Balão metálico azul de alta qualidade, ideal para decoração.', 1, 2, 1),
('Balão Vermelho Metalizado', 'Balão de látex vermelho metalizado para festas.', 1, 2, 1),
('Balão com Nome Personalizado', 'Balão personalizado com o nome do aniversariante.', 1, 3, 1),
('Balão de Personagem Infantil', 'Balão com impressão de personagem infantil.', 1, 4, 1),
('Kit de Balões Coloridos', 'Kit de balões de várias cores para decorar ambientes.', 1, 1, 1),

-- Produtos de Decoração de Mesa (categoria_id: 2)
('Toalha de Mesa Azul', 'Toalha de mesa azul decorativa para eventos.', 2, 5, 1),
('Guardanapos Personalizados', 'Guardanapos com estampas para festas temáticas.', 2, 6, 1),
('Arranjo de Mesa Floral', 'Arranjo de mesa com flores artificiais para decoração.', 2, 8, 1),
('Centro de Mesa com Balões', 'Centro de mesa decorativo com balões e temas variados.', 2, 7, 1),
('Porta Guardanapo de Laço', 'Porta guardanapo com laço de cetim decorativo.', 2, 6, 1),

-- Produtos de Doces e Confeitaria (categoria_id: 3)
('Cupcake Temático', 'Cupcake decorado com temas de festa.', 3, 10, 1),
('Macaron Personalizado', 'Macaron com desenho personalizado para aniversários.', 3, 11, 1),
('Bolo Fake para Decoração', 'Bolo cenográfico decorativo para mesas.', 3, 12, 1),
('Bolo de Andares Temático', 'Bolo de andares com decoração temática para festas.', 3, 12, 1),
('Brigadeiro Gourmet', 'Brigadeiro gourmet enrolado com granulados especiais.', 3, 9, 1),

-- Produtos de Itens para Lembrancinhas (categoria_id: 4)
('Caixa para Lembrancinha Personalizada', 'Caixa decorativa para lembrancinhas de festa.', 4, 15, 1),
('Mini Sabonete Aromático', 'Sabonete aromático como lembrancinha de casamento.', 4, 14, 1),
('Mini Kit de Pintura Infantil', 'Kit de pintura para crianças como lembrancinha.', 4, 16, 1),
('Caixa Surpresa com Doces', 'Caixa surpresa com doces variados para aniversários.', 4, 15, 1),
('Chaveiro de Acrílico Personalizado', 'Chaveiro com nome do convidado como lembrancinha.', 4, 13, 1),

-- Produtos de Artigos para Festa (categoria_id: 5)
('Chapéu de Aniversário', 'Chapéu decorativo para aniversários.', 5, 19, 1),
('Máscara de Personagens', 'Máscara de personagem para festas infantis.', 5, 18, 1),
('Tiara de Aniversário', 'Tiara decorativa para aniversariante.', 5, 20, 1),
('Bigode e Óculos Falsos', 'Bigode e óculos para photobooth e diversão.', 5, 17, 1),
('Kit de Adereços para Fotos', 'Conjunto de adereços para fotos em festas.', 5, 17, 1),

-- Produtos de Balões de Letra (categoria_id: 21)
('Balão Letra Dourada', 'Balão em formato de letra dourada para formar nomes.', 21, 21, 1),
('Balão Letra Prateada', 'Balão em formato de letra prateada para decorações.', 21, 22, 1),
('Kit de Balões Letras Coloridos', 'Kit de balões de letras em cores diversas.', 21, 23, 1),
('Balão Letra Personalizada', 'Balão de letra com personalização de nome.', 21, 24, 1),

-- Produtos de Balões Metalizados (categoria_id: 22)
('Balão Metalizado de Estrela', 'Balão metalizado em formato de estrela.', 22, 25, 1),
('Balão Metalizado de Coração', 'Balão de coração metalizado para casamentos.', 22, 26, 1),
('Balão de Animal Metalizado', 'Balão metalizado em formato de animal.', 22, 27, 1),
('Balão de Personagem Metalizado', 'Balão com personagens populares.', 22, 28, 1),

-- Produtos de Balões Personalizados (categoria_id: 23)
('Balão com Idade Personalizada', 'Balão personalizado com a idade do aniversariante.', 23, 29, 1),
('Balão com Nome e Foto', 'Balão personalizado com foto do aniversariante.', 23, 30, 1),
('Balão com Frases Personalizadas', 'Balão com frases inspiradoras para festas.', 23, 31, 1),

-- Produtos de Suportes para Bolos e Doces (categoria_id: 24)
('Suporte para Bolo de Acrílico', 'Suporte de acrílico transparente para bolo.', 24, 32, 1),
('Suporte para Cupcake', 'Suporte especial para cupcakes.', 24, 33, 1),
('Suporte para Docinhos Decorado', 'Suporte para doces decorado com temas.', 24, 34, 1),

-- Produtos de Topo de Bolo (categoria_id: 25)
('Topo de Bolo com Nome', 'Topo de bolo personalizado com nome.', 25, 36, 1),
('Topo de Bolo para Casamento', 'Topo de bolo especial para casamentos.', 25, 37, 1),
('Topo de Bolo com Personagem', 'Topo de bolo com tema infantil.', 25, 35, 1),

-- Produtos de Cupcake Wrappers (categoria_id: 26)
('Wrapper para Cupcake Colorido', 'Wrapper colorido para cupcakes de festa.', 26, 39, 1),
('Wrapper com Glitter', 'Wrapper decorado com glitter para cupcakes.', 26, 41, 1),
('Wrapper Temático de Festa', 'Wrapper de cupcake com temas festivos.', 26, 38, 1),

-- Produtos de Etiquetas e Adesivos (categoria_id: 27)
('Etiqueta Personalizada com Nome', 'Etiqueta personalizada para lembrancinhas.', 27, 43, 1),
('Adesivo com Personagem', 'Adesivo com personagens para decoração.', 27, 44, 1),
('Etiqueta para Doces', 'Etiqueta para identificar doces em festas.', 27, 42, 1),

-- Produtos de Bandejas Decorativas (categoria_id: 28)
('Bandeja de Acrílico com Detalhes', 'Bandeja de acrílico com detalhes para decoração.', 28, 46, 1),
('Bandeja Espelhada', 'Bandeja espelhada para decoração de mesa.', 28, 48, 1),
('Bandeja de Madeira Decorativa', 'Bandeja de madeira para servir doces.', 28, 47, 1),

-- Produtos de Forminhas para Doces (categoria_id: 29)
('Forminha de Papel Decorada', 'Forminha decorada para docinhos.', 29, 50, 1),
('Forminha com Glitter', 'Forminha brilhante para decoração de doces.', 29, 51, 1),
('Forminha Temática', 'Forminha com tema para festas.', 29, 49, 1),

-- Produtos de Painéis Decorativos (categoria_id: 30)
('Painel de Balões Coloridos', 'Painel decorativo feito com balões coloridos.', 30, 54, 1),
('Painel de Flores de Papel', 'Painel decorativo com flores de papel.', 30, 52, 1),
('Painel Temático Personalizado', 'Painel decorativo com tema personalizado.', 30, 53, 1),

-- Produtos de Faixas de Feliz Aniversário (categoria_id: 31)
('Faixa Personalizada com Nome', 'Faixa de feliz aniversário personalizada.', 31, 56, 1),
('Faixa Colorida de Tecido', 'Faixa colorida para aniversários.', 31, 57, 1),
('Faixa Decorativa de Papel', 'Faixa de papel para festas.', 31, 55, 1),

-- Produtos de Chaveiros e Ímãs (categoria_id: 32)
('Chaveiro de Lembrancinha', 'Chaveiro personalizado para lembranças de festa.', 32, 58, 1),
('Ímã de Geladeira com Tema', 'Ímã temático para lembrancinhas.', 32, 59, 1),
('Chaveiro de Aniversário', 'Chaveiro personalizado para aniversários.', 32, 60, 1);
