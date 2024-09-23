-- MySQL Script generated by MySQL Workbench
-- Sun Sep 22 21:49:15 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mundofesteirobd2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mundofesteirobd2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mundofesteirobd2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `mundofesteirobd2` ;

-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`localidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`localidade` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `endereco` VARCHAR(255) NOT NULL,
  `bairro` VARCHAR(255) NOT NULL,
  `cidade` VARCHAR(255) NOT NULL,
  `estado` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `idade` INT NOT NULL,
  `contactno` BIGINT NULL DEFAULT NULL,
  `password` VARCHAR(255) NULL DEFAULT NULL,
  `Status` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `localidade_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_localidade1_idx` (`localidade_id` ASC) ,
  CONSTRAINT `fk_users_localidade1`
    FOREIGN KEY (`localidade_id`)
    REFERENCES `mundofesteirobd2`.`localidade` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`pedido` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Status` VARCHAR(100) NOT NULL,
  `Valor_Total` FLOAT NOT NULL,
  `users_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `users_id`),
  INDEX `fk_pedido_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_pedido_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`cores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`cores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Cor` VARCHAR(100) NOT NULL,
  `Codigo_Cor` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`estoque`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`estoque` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Quantidade` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`categorias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Categoria` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`subcategorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`subcategorias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `SubCategoria` VARCHAR(255) NOT NULL,
  `categorias_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_subcategorias_categorias1_idx` (`categorias_id` ASC) ,
  CONSTRAINT `fk_subcategorias_categorias1`
    FOREIGN KEY (`categorias_id`)
    REFERENCES `mundofesteirobd2`.`categorias` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`produtos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Nome_Produto` VARCHAR(150) NOT NULL,
  `Descricao` VARCHAR(255) NOT NULL,
  `categorias_id` INT NOT NULL,
  `subcategorias_id` INT NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Status` INT NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  INDEX `fk_produtos_categorias1_idx` (`categorias_id` ASC) ,
  INDEX `fk_produtos_subcategorias1_idx` (`subcategorias_id` ASC) ,
  CONSTRAINT `fk_produtos_categorias1`
    FOREIGN KEY (`categorias_id`)
    REFERENCES `mundofesteirobd2`.`categorias` (`id`),
  CONSTRAINT `fk_produtos_subcategorias1`
    FOREIGN KEY (`subcategorias_id`)
    REFERENCES `mundofesteirobd2`.`subcategorias` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`tamanho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`tamanho` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Tamanho` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`promo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`promo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Porcentagem` INT NOT NULL,
  `Tempo` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`produtosvariasoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`produtosvariasoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Valor` FLOAT NOT NULL,
  `cores_id` INT NOT NULL,
  `tamanho_id` INT NOT NULL,
  `produtos_id` INT NOT NULL,
  `estoque_id` INT NOT NULL,
  `Status` INT NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `promo_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_produtosvariasoes_cores1_idx` (`cores_id` ASC) ,
  INDEX `fk_produtosvariasoes_tamanho1_idx` (`tamanho_id` ASC) ,
  INDEX `fk_produtosvariasoes_estoque1_idx` (`estoque_id` ASC) ,
  INDEX `fk_produtosvariasoes_promo1_idx` (`promo_id` ASC) ,
  CONSTRAINT `fk_produtosvariasoes_cores1`
    FOREIGN KEY (`cores_id`)
    REFERENCES `mundofesteirobd2`.`cores` (`id`),
  CONSTRAINT `fk_produtosvariasoes_estoque1`
    FOREIGN KEY (`estoque_id`)
    REFERENCES `mundofesteirobd2`.`estoque` (`id`),
  CONSTRAINT `fk_produtosvariasoes_produtos1`
    FOREIGN KEY (`produtos_id`)
    REFERENCES `mundofesteirobd2`.`produtos` (`id`),
  CONSTRAINT `fk_produtosvariasoes_tamanho1`
    FOREIGN KEY (`tamanho_id`)
    REFERENCES `mundofesteirobd2`.`tamanho` (`id`),
  CONSTRAINT `fk_produtosvariasoes_promo1`
    FOREIGN KEY (`promo_id`)
    REFERENCES `mundofesteirobd2`.`promo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`avaliacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`avaliacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Nota` INT NOT NULL,
  `Comentario` VARCHAR(255) NOT NULL,
  `Data_Avaliacao` DATETIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `produtosvariasoes_id` INT NOT NULL,
  `pedido_id` INT NOT NULL,
  `pedido_users_id` INT NOT NULL,
  PRIMARY KEY (`id`, `pedido_id`, `pedido_users_id`),
  INDEX `fk_avaliacao_produtosvariasoes1_idx` (`produtosvariasoes_id` ASC) ,
  INDEX `fk_avaliacao_pedido1_idx` (`pedido_id` ASC, `pedido_users_id` ASC) ,
  CONSTRAINT `fk_avaliacao_pedido1`
    FOREIGN KEY (`pedido_id` , `pedido_users_id`)
    REFERENCES `mundofesteirobd2`.`pedido` (`id` , `users_id`),
  CONSTRAINT `fk_avaliacao_produtosvariasoes1`
    FOREIGN KEY (`produtosvariasoes_id`)
    REFERENCES `mundofesteirobd2`.`produtosvariasoes` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`avatar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`avatar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `avatar` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_avatar_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_avatar_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`carrinho` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `users_id`),
  INDEX `fk_carrinho_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_carrinho_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`prestador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`prestador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `promotorEvento` INT NOT NULL DEFAULT '0',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `curriculo` LONGTEXT NOT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_prestador_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_prestador_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`contrar_prestador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`contrar_prestador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `aceitarProposta` INT NOT NULL DEFAULT '0',
  `profession` VARCHAR(255) NOT NULL,
  `prestador_id` INT NOT NULL,
  `users_id` INT NOT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
  `created_at` VARCHAR(45) NULL DEFAULT 'CURRENT_TIMESTAMP',
  PRIMARY KEY (`id`, `prestador_id`, `users_id`),
  INDEX `fk_contrar_prestador_prestador1_idx` (`prestador_id` ASC) ,
  INDEX `fk_contrar_prestador_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_contrar_prestador_prestador1`
    FOREIGN KEY (`prestador_id`)
    REFERENCES `mundofesteirobd2`.`prestador` (`id`),
  CONSTRAINT `fk_contrar_prestador_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`evento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `localidade_id` INT NOT NULL,
  `nomeEvento` VARCHAR(255) NOT NULL,
  `tipoEvento` VARCHAR(255) NOT NULL,
  `data` DATETIME NOT NULL,
  `quantidadePessoas` INT NOT NULL,
  `quantidadeFuncionarios` INT NOT NULL,
  `statusEvento` VARCHAR(255) NOT NULL,
  `descricaoEvento` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evento_users1_idx` (`users_id` ASC) ,
  INDEX `fk_evento_localidade1_idx` (`localidade_id` ASC) ,
  CONSTRAINT `fk_evento_localidade1`
    FOREIGN KEY (`localidade_id`)
    REFERENCES `mundofesteirobd2`.`localidade` (`id`),
  CONSTRAINT `fk_evento_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`profissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`profissao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `profissao` VARCHAR(255) NOT NULL,
  `iconURL` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`evento_has_profissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`evento_has_profissao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `evento_id` INT NOT NULL,
  `profissao_id` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `evento_id`, `profissao_id`),
  INDEX `fk_evento_has_profissao_profissao1_idx` (`profissao_id` ASC) ,
  INDEX `fk_evento_has_profissao_evento1_idx` (`evento_id` ASC) ,
  CONSTRAINT `fk_evento_has_profissao_evento1`
    FOREIGN KEY (`evento_id`)
    REFERENCES `mundofesteirobd2`.`evento` (`id`),
  CONSTRAINT `fk_evento_has_profissao_profissao1`
    FOREIGN KEY (`profissao_id`)
    REFERENCES `mundofesteirobd2`.`profissao` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`favoritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`favoritos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  `produtosvariasoes_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_favoritos_users1_idx` (`users_id` ASC) ,
  INDEX `fk_favoritos_produtosvariasoes1_idx` (`produtosvariasoes_id` ASC) ,
  CONSTRAINT `fk_favoritos_produtosvariasoes1`
    FOREIGN KEY (`produtosvariasoes_id`)
    REFERENCES `mundofesteirobd2`.`produtosvariasoes` (`id`),
  CONSTRAINT `fk_favoritos_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mundofesteirobd2`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`imgevento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`imgevento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `evento_id` INT NOT NULL,
  `img` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_imgevento_evento_idx` (`evento_id` ASC) ,
  CONSTRAINT `fk_imgevento_evento`
    FOREIGN KEY (`evento_id`)
    REFERENCES `mundofesteirobd2`.`evento` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`itenscarrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`itenscarrinho` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Valor_Uni` FLOAT NOT NULL,
  `Quantidade` INT NOT NULL,
  `carrinho_id` INT NOT NULL,
  `carrinho_users_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  `produtosvariasoes_id` INT NOT NULL,
  PRIMARY KEY (`id`, `carrinho_id`, `carrinho_users_id`),
  INDEX `fk_itenscarrinho_carrinho1_idx` (`carrinho_id` ASC, `carrinho_users_id` ASC) ,
  INDEX `fk_itenscarrinho_produtosvariasoes1_idx` (`produtosvariasoes_id` ASC) ,
  CONSTRAINT `fk_itenscarrinho_carrinho1`
    FOREIGN KEY (`carrinho_id` , `carrinho_users_id`)
    REFERENCES `mundofesteirobd2`.`carrinho` (`id` , `users_id`),
  CONSTRAINT `fk_itenscarrinho_produtosvariasoes1`
    FOREIGN KEY (`produtosvariasoes_id`)
    REFERENCES `mundofesteirobd2`.`produtosvariasoes` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`itenspedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`itenspedido` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Quantidade` INT NOT NULL,
  `Valor_Uni` FLOAT NOT NULL,
  `pedido_id` INT NOT NULL,
  `pedido_users_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `produtosvariasoes_id` INT NOT NULL,
  PRIMARY KEY (`id`, `pedido_id`, `pedido_users_id`),
  INDEX `fk_itenspedido_pedido1_idx` (`pedido_id` ASC, `pedido_users_id` ASC) ,
  INDEX `fk_itenspedido_produtosvariasoes1_idx` (`produtosvariasoes_id` ASC) ,
  CONSTRAINT `fk_itenspedido_pedido1`
    FOREIGN KEY (`pedido_id` , `pedido_users_id`)
    REFERENCES `mundofesteirobd2`.`pedido` (`id` , `users_id`),
  CONSTRAINT `fk_itenspedido_produtosvariasoes1`
    FOREIGN KEY (`produtosvariasoes_id`)
    REFERENCES `mundofesteirobd2`.`produtosvariasoes` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`cupom`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`cupom` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Codigo` VARCHAR(45) NOT NULL,
  `Tempo` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`pagamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`pagamentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Valor` FLOAT NOT NULL,
  `Metodo_Pagamento` VARCHAR(100) NOT NULL,
  `Status` VARCHAR(100) NOT NULL,
  `Data_Pagamento` DATETIME NOT NULL,
  `pedido_id` INT NOT NULL,
  `pedido_users_id` INT NOT NULL,
  `localidade_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cupom_id` INT NULL,
  PRIMARY KEY (`id`, `pedido_id`, `pedido_users_id`),
  INDEX `fk_pagamentos_pedido1_idx` (`pedido_id` ASC, `pedido_users_id` ASC) ,
  INDEX `fk_pagamentos_localidade1_idx` (`localidade_id` ASC) ,
  INDEX `fk_pagamentos_cupom1_idx` (`cupom_id` ASC) ,
  CONSTRAINT `fk_pagamentos_localidade1`
    FOREIGN KEY (`localidade_id`)
    REFERENCES `mundofesteirobd2`.`localidade` (`id`),
  CONSTRAINT `fk_pagamentos_pedido1`
    FOREIGN KEY (`pedido_id` , `pedido_users_id`)
    REFERENCES `mundofesteirobd2`.`pedido` (`id` , `users_id`),
  CONSTRAINT `fk_pagamentos_cupom1`
    FOREIGN KEY (`cupom_id`)
    REFERENCES `mundofesteirobd2`.`cupom` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`prestador_has_evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`prestador_has_evento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `prestador_id` INT NOT NULL,
  `evento_id` INT NOT NULL,
  `aceitarPrestador` INT NOT NULL DEFAULT '0',
  `profissao` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `prestador_id`, `evento_id`),
  INDEX `fk_prestador_has_evento_evento1_idx` (`evento_id` ASC) ,
  INDEX `fk_prestador_has_evento_prestador1_idx` (`prestador_id` ASC) ,
  CONSTRAINT `fk_prestador_has_evento_evento1`
    FOREIGN KEY (`evento_id`)
    REFERENCES `mundofesteirobd2`.`evento` (`id`),
  CONSTRAINT `fk_prestador_has_evento_prestador1`
    FOREIGN KEY (`prestador_id`)
    REFERENCES `mundofesteirobd2`.`prestador` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `mundofesteirobd2`.`prestador_has_profissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mundofesteirobd2`.`prestador_has_profissao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `prestador_id` INT NOT NULL,
  `profissao_id` INT NOT NULL,
  `tempoexperiencia` INT NOT NULL,
  `valorDiaServicoProfissao` FLOAT NOT NULL,
  `valorHoraServicoProfissao` FLOAT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `prestador_id`, `profissao_id`),
  INDEX `fk_prestador_has_profissao_profissao1_idx` (`profissao_id` ASC) ,
  INDEX `fk_prestador_has_profissao_prestador1_idx` (`prestador_id` ASC) ,
  CONSTRAINT `fk_prestador_has_profissao_prestador1`
    FOREIGN KEY (`prestador_id`)
    REFERENCES `mundofesteirobd2`.`prestador` (`id`),
  CONSTRAINT `fk_prestador_has_profissao_profissao1`
    FOREIGN KEY (`profissao_id`)
    REFERENCES `mundofesteirobd2`.`profissao` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
