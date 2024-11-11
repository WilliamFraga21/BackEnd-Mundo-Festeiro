<?php
// Conexão com o banco de dados
$host = 'localhost'; // seu host
$dbname = 'mundofesteirobd2'; // nome do banco de dados
$username = 'root'; // usuário do banco de dados
$password = 'admin'; // senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}

// Função para popular a tabela 'carrinho' e 'itenscarrinho'
function popularCarrinho($pdo) {
    for ($user_id = 1; $user_id <= 1000; $user_id++) {
        // Inserir um novo carrinho para o usuário
        $stmt = $pdo->prepare("INSERT INTO carrinho (users_id) VALUES (:users_id)");
        $stmt->bindParam(':users_id', $user_id);
        $stmt->execute();
        
        // Obter o último ID do carrinho inserido
        $carrinho_id = $pdo->lastInsertId();

        // Gerar um número aleatório de produtos para adicionar (entre 2 e 14)
        $numero_produtos = rand(2, 14);

        // Para cada item do carrinho, inserir uma variação de produto
        for ($i = 0; $i < $numero_produtos; $i++) {
            $produto_id = rand(1, 450); // Produto aleatório de 1 a 450
            $valor_uni = rand(10, 100); // Valor unitário aleatório entre 10 e 100
            $quantidade = rand(1, 5); // Quantidade aleatória entre 1 e 5

            // Inserir produto na tabela 'itenscarrinho'
            $stmt = $pdo->prepare("INSERT INTO itenscarrinho (Valor_Uni, Quantidade, carrinho_id, carrinho_users_id, produtosvariasoes_id) 
                                   VALUES (:valor_uni, :quantidade, :carrinho_id, :carrinho_users_id, :produtosvariasoes_id)");
            $stmt->bindParam(':valor_uni', $valor_uni);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->bindParam(':carrinho_id', $carrinho_id);
            $stmt->bindParam(':carrinho_users_id', $user_id);
            $stmt->bindParam(':produtosvariasoes_id', $produto_id);
            $stmt->execute();
        }
    }
}

// Chama a função para popular os dados
popularCarrinho($pdo);
echo "Carrinhos e itens populados com sucesso!";
?>
