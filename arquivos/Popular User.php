<?php
// Configuração do banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=mundofesteirobd2', 'root', 'admin');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// Dados de localidade com ruas e bairros conhecidos de São Paulo
$localidades = [
    ['endereco' => 'Avenida Paulista', 'bairro' => 'Bela Vista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Consolação', 'bairro' => 'Consolação', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Augusta', 'bairro' => 'Cerqueira César', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua João Cachoeira', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida 9 de Julho', 'bairro' => 'Jardins', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Faria Lima', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Rebouças', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Brigadeiro Faria Lima', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Cardoso Pimentel', 'bairro' => 'Vila Olímpia', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Joaquim Eugênio de Lima', 'bairro' => 'Jardim Paulista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida 23 de Maio', 'bairro' => 'Vila Mariana', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida dos Bandeirantes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua do Bosque', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Angélica', 'bairro' => 'Higienópolis', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua São Vicente', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Jabaquara', 'bairro' => 'Jabaquara', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Visc. de Pirajá', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Dr. Arnaldo', 'bairro' => 'Cerqueira César', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Pedro Álvares Cabral', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Marginal Pinheiros', 'bairro' => 'Jardim Paulista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida do Estado', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua José do Patrocínio', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua General Jardim', 'bairro' => 'República', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Eng. Luís Carlos Berrini', 'bairro' => 'Brooklin', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Santa Catarina', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Domingos de Moraes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Brigadeiro Luís Antônio', 'bairro' => 'Bela Vista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Monte Alegre', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Presidente Juscelino Kubitschek', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida São João', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua 25 de Março', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Independência', 'bairro' => 'Liberdade', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida dos Bandeirantes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Ibirapuera', 'bairro' => 'Moema', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua do Bosque', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Nova Faria Lima', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua José do Patrocínio', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida dos Bandeirantes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Fidalga', 'bairro' => 'Vila Madalena', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Paz', 'bairro' => 'Liberdade', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Teodoro Sampaio', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Vital Brasil', 'bairro' => 'Butantã', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Pedroso de Morais', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Morumbi', 'bairro' => 'Morumbi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida São João', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida do Estado', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida dos Bandeirantes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Antônio Agu', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua do Manifesto', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Maria Figueiredo', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Padre Antônio Tomás', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Rio Grande', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Independência', 'bairro' => 'Liberdade', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Alfândega', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Consolação', 'bairro' => 'Consolação', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Brasil', 'bairro' => 'Jardim Paulista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Augusta', 'bairro' => 'Cerqueira César', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua das Figueiras', 'bairro' => 'Jardim Paulistano', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Consolação', 'bairro' => 'Consolação', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua 25 de Março', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Vergueiro', 'bairro' => 'Vila Mariana', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Brasil', 'bairro' => 'Jardins', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua do Bosque', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Pacaembu', 'bairro' => 'Pacaembu', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Berrini', 'bairro' => 'Brooklin', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Paulista', 'bairro' => 'Bela Vista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Brigadeiro Faria Lima', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida dos Bandeirantes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida São João', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Monte Alegre', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Eng. Luís Carlos Berrini', 'bairro' => 'Brooklin', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Angélica', 'bairro' => 'Higienópolis', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida dos Bandeirantes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua do Bosque', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Domingos de Morais', 'bairro' => 'Vila Mariana', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Trilhos', 'bairro' => 'Vila Prudente', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Dr. Virgílio de Carvalho Pinto', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Jabaquara', 'bairro' => 'Jabaquara', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua das Perdizes', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Joaquim Távora', 'bairro' => 'Vila Mariana', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Rio Branco', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Cardoso Pimentel', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Santa Cruz', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Carijós', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Lins de Vasconcelos', 'bairro' => 'Lins de Vasconcelos', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Nova Granada', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Bandeirantes', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Dona Maria Soares', 'bairro' => 'Santo Amaro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Joaquim Pinto', 'bairro' => 'Bela Vista', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Francisco Matarazzo', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Benedito Gonçalves', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Voluntários da Pátria', 'bairro' => 'Santana', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Morumbi', 'bairro' => 'Morumbi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Ministro Nelson Hungria', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Maria Lúcia', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Colômbia', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Nova Granada', 'bairro' => 'Jardim das Bandeiras', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Otaviano de Lima', 'bairro' => 'Itaim Bibi', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua do Nascimento', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Felipe dos Santos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Antonio Macedo', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Mooca', 'bairro' => 'Mooca', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua São Benedito', 'bairro' => 'Liberdade', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Paz', 'bairro' => 'Liberdade', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Carlos de Campos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Henrique Schaumann', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua São João', 'bairro' => 'Centro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Santa Cruz', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua da Consolação', 'bairro' => 'Consolação', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Faria Lima', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua Henrique Schaumann', 'bairro' => 'Pinheiros', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Doutor Cardoso Pimentel', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Avenida Interlagos', 'bairro' => 'Interlagos', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ['endereco' => 'Rua dos Três Irmãos', 'bairro' => 'Vila Progredior', 'cidade' => 'São Paulo', 'estado' => 'SP']
    // Adicione mais locais conforme necessário...
];

// Função para inserir localidades no banco de dados
function inserirLocalidade($endereco, $bairro, $cidade, $estado) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO localidade (endereco, bairro, cidade, estado) 
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$endereco, $bairro, $cidade, $estado]);
    return $pdo->lastInsertId(); // Retorna o ID da localidade inserida
}

// Função para inserir usuários com localidade associada
function inserirUsuarios($localidade_id) {
    global $pdo;
    for ($i = 1; $i <= 10; $i++) { // 350 usuários distribuídos em 10 localidades
        $name = "Usuário {$i}_{$localidade_id}";
        $email = "usuario{$i}_{$localidade_id}@example.com";
        $idade = rand(18, 60); // Idade aleatória
        $contactno = rand(9000000000, 9999999999); // Número aleatório
        $password = 'senha123';
        $status = rand(0, 1) ? 'Ativo' : 'Inativo'; // Status aleatório
        
        // Inserindo o usuário no banco de dados, associando à localidade
        $stmt = $pdo->prepare("INSERT INTO users (name, email, idade, contactno, password, Status, localidade_id)
                               VALUES (:name, :email, :idade, :contactno, :password, :status, :localidade_id)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':idade' => $idade,
            ':contactno' => $contactno,
            ':password' => $password,
            ':status' => $status,
            ':localidade_id' => $localidade_id
        ]);
    }
}

// Inserir localidades e usuários
foreach ($localidades as $localidade) {
    $localidade_id = inserirLocalidade($localidade['endereco'], $localidade['bairro'], $localidade['cidade'], $localidade['estado']);
    inserirUsuarios($localidade_id); // Insere 35 usuários por localidade
}

echo "Localidades e usuários inseridos com sucesso!";

