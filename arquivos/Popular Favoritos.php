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

// Função para popular a tabela favoritos
function popularFavoritos($pdo) {
    // Selecionar todos os usuários
    $stmt = $pdo->prepare("SELECT id FROM users");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Para cada usuário, adicionar entre 5 a 30 produtos favoritos
    foreach ($usuarios as $usuario) {
        // Definir o número de favoritos entre 5 e 30
        $numFavoritos = rand(5, 30);

        // Selecionar IDs de produtosvariasoes aleatórios (assumindo que produtosvariasoes já estão cadastrados)
        $stmtProdutos = $pdo->prepare("SELECT id FROM produtosvariasoes");
        $stmtProdutos->execute();
        $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

        // Para cada produto, inserir na tabela de favoritos
        for ($i = 0; $i < $numFavoritos; $i++) {
            $produtoAleatorio = $produtos[array_rand($produtos)]; // Selecionar um produto aleatório
            $produtoId = $produtoAleatorio['id'];

            // Inserir o favorito na tabela
            $stmtInsert = $pdo->prepare("INSERT INTO favoritos (users_id, produtosvariasoes_id) 
                                         VALUES (?, ?)");
            $stmtInsert->bindValue(1, $usuario['id']);
            $stmtInsert->bindValue(2, $produtoId);
            $stmtInsert->execute();
        }
    }

    echo "Favoritos populares com sucesso!";
}

// Chama a função para popular a tabela favoritos
popularFavoritos($pdo);
?>
