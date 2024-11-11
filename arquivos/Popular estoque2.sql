-- Popular a tabela estoque com quantidades aleatórias entre 10 e 100
INSERT INTO `mundofesteirobd2`.`estoque` (`Quantidade`)
VALUES
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10),
  (FLOOR(RAND() * (100 - 10 + 1)) + 10);
  -- Continue esse padrão até chegar a 350 itens
