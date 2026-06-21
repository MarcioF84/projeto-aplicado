
CREATE TABLE tb_usuario (
	id_usuario BIGINT UNSIGNED NOT NULL,
    id_tipo_usuario INT UNSIGNED NOT NULL,
	nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
	senha VARCHAR(255) NOT NULL,
	telefone VARCHAR(20) DEFAULT NULL,
	sexo CHAR(1) NOT NULL COMMENT 'F - Feminino, M - Masculino',  	
	bio TEXT,
	data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
  	status_usuario CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	  	
	PRIMARY KEY (id_usuario),  		
  	UNIQUE KEY uk_email (email),
    INDEX idx_tipo_usuario (id_tipo_usuario),  	    
  	CONSTRAINT fk_usuario_tipo FOREIGN KEY (id_tipo_usuario) REFERENCES tb_tipo_usuario (id_tipo_usuario)  	
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_tipo_usuario (
	id_tipo_usuario INT UNSIGNED NOT NULL,
	descricao_tipo VARCHAR(255) NOT NULL,
  	status_tipo CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_tipo_usuario),  
  	UNIQUE KEY uk_tipo_descricao (descricao_tipo)    	
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_marca (
	id_marca INT UNSIGNED NOT NULL,
	descricao_marca VARCHAR(255) NOT NULL,
  	status_marca CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_marca),  
  	UNIQUE KEY uk_marca_descricao (descricao_marca)    	
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_modelo (
	id_modelo INT UNSIGNED NOT NULL,
	id_marca INT UNSIGNED NOT NULL,
	descricao_modelo VARCHAR(255) NOT NULL,
  	status_modelo CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_modelo),  
  	UNIQUE KEY uk_modelo_descricao (descricao_modelo),
	INDEX idx_marca_frota (id_marca), 
	CONSTRAINT fk_frota_marca FOREIGN KEY (id_marca) REFERENCES tb_marca (id_marca) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_frota (
	id_frota BIGINT UNSIGNED NOT NULL,
    id_modelo INT UNSIGNED NOT NULL,
	placa VARCHAR(10) NOT NULL,
    cor VARCHAR(50) NOT NULL,
	data_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  
  	status_frota CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_frota),  	
  	UNIQUE KEY uk_placa (placa),
    INDEX idx_modelo_frota (id_modelo),  	
    CONSTRAINT fk_frota_modelo FOREIGN KEY (id_modelo) REFERENCES tb_modelo (id_modelo) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_usuario_frota (
	id_usuario_frota BIGINT UNSIGNED NOT NULL,
	id_usuario BIGINT UNSIGNED NOT NULL,
	id_frota BIGINT UNSIGNED NOT NULL,
	PRIMARY KEY (id_usuario_frota, id_usuario, id_frota),
	CONSTRAINT fk_usuario_frota_usuario
		FOREIGN KEY (id_usuario)
		REFERENCES tb_usuario (id_usuario)
		ON DELETE CASCADE,
	CONSTRAINT fk_usuario_frota_frota
		FOREIGN KEY (id_frota)
		REFERENCES tb_frota (id_frota)
		ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_campus (
	id_campus BIGINT UNSIGNED NOT NULL,	
	id_endereco BIGINT UNSIGNED NOT NULL,	
    nome_campus VARCHAR(150) NOT NULL, 
  	status_campus CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_campus)
	INDEX idx_endereco (id_endereco),  	
	CONSTRAINT fk_endereco_campus FOREIGN KEY (id_endereco) REFERENCES tb_endereco (id_endereco) ON DELETE RESTRICT,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_endereco (
	id_endereco BIGINT UNSIGNED NOT NULL,	
    cep VARCHAR(8) NOT NULL, 
	rua VARCHAR(150) NOT NULL, 
    cidade VARCHAR(150) NOT NULL, 
    bairro VARCHAR(150) NOT NULL, 
    estado VARCHAR(2) NOT NULL, 
    latitude DECIMAL(10,8) NULL, 
    longitude DECIMAL(10,8) NULL, 
  	status_endereco CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_endereco)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_carona (
	id_carona BIGINT UNSIGNED NOT NULL,
	id_frota BIGINT UNSIGNED NOT NULL,				
    id_endereco_origem BIGINT UNSIGNED NOT NULL,
    id_endereco_destino BIGINT UNSIGNED NOT NULL,    
	data_partida DATE NOT NULL,
	hora_partida TIME NOT NULL,
	valor_carona DECIMAL(10,2),
	qtde_assento INT UNSIGNED NOT NULL,
  	status_carona CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',  	
	PRIMARY KEY (id_carona),  	
    INDEX idx_frota (id_frota),  	
    INDEX idx_endereco_origem (id_endereco_origem),  	
    INDEX idx_endereco_destino (id_endereco_destino),  	
    CONSTRAINT fk_carona_frota FOREIGN KEY (id_frota) REFERENCES tb_frota (id_frota) ON DELETE CASCADE,
  	CONSTRAINT fk_carona_endereco_origem FOREIGN KEY (id_endereco_origem) REFERENCES tb_endereco (id_endereco) ON DELETE RESTRICT,
  	CONSTRAINT fk_carona_endereco_destino FOREIGN KEY (id_endereco_destino) REFERENCES tb_endereco (id_endereco) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_reserva (
	id_reserva BIGINT UNSIGNED NOT NULL,
	id_usuario BIGINT UNSIGNED NOT NULL,				
	id_carona BIGINT UNSIGNED NOT NULL,		
	qtde_assentos INT UNSIGNED NOT NULL,
	data_reserva DATE NOT NULL,  				
  	status_reserva CHAR(1) DEFAULT 'A' COMMENT 'A - Ativo, D - Desativado',	  		
	PRIMARY KEY (id_reserva),  	
    INDEX idx_usuario (id_usuario),  	
    INDEX idx_carona (id_carona),
    CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_reserva_carona FOREIGN KEY (id_carona) REFERENCES tb_carona (id_carona) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tb_avaliacao (
	id_avaliacao BIGINT UNSIGNED NOT NULL,
	id_usuario BIGINT UNSIGNED NOT NULL,		
	id_carona BIGINT UNSIGNED NOT NULL,				
	pontuacao INT UNSIGNED NOT NULL,
	comentario VARCHAR(500),
	data_avaliacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,  	
	PRIMARY KEY (id_avaliacao),  	
  	UNIQUE KEY uk_usuario_carona (id_usuario, id_carona),
    INDEX idx_usuario (id_usuario),  	
    INDEX idx_carona (id_carona),
    CONSTRAINT fk_avaliacao_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_avaliacao_carona FOREIGN KEY (id_carona) REFERENCES tb_carona (id_carona) ON DELETE CASCADE,
    CHECK (pontuacao BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

