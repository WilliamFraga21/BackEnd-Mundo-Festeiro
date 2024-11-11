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

// Função para mover os itens do carrinho para o pedido
function criarPedido($pdo) {
    // Selecionar todos os itens do carrinho
    $stmt = $pdo->prepare("SELECT * FROM itenscarrinho WHERE deleted_at IS NULL");
    $stmt->execute();
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Agrupar itens por carrinho_users_id (usuário)
    $itensAgrupadosPorUsuario = [];
    foreach ($itens as $item) {
        $itensAgrupadosPorUsuario[$item['carrinho_users_id']][] = $item;
    }
    
    // Processar cada usuário
    foreach ($itensAgrupadosPorUsuario as $user_id => $itensDoCarrinho) {
        // Calcular o valor total do pedido
        $valor_total = 0;
        foreach ($itensDoCarrinho as $item) {
            $valor_total += $item['Valor_Uni'] * $item['Quantidade'];
        }

        // Inserir um novo pedido
        $status = 'Pendente'; // Definindo o status do pedido como Pendente
        $stmt = $pdo->prepare("INSERT INTO pedido (Status, Valor_Total, users_id) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $status); // Passando o status como valor
        $stmt->bindValue(2, $valor_total); // Passando o valor total como valor
        $stmt->bindValue(3, $user_id); // Passando o user_id como valor
        $stmt->execute();

        // Obter o ID do pedido inserido
        $pedido_id = $pdo->lastInsertId();

        // Inserir os itens no pedido
        foreach ($itensDoCarrinho as $item) {
            $stmt = $pdo->prepare("INSERT INTO itenspedido (Quantidade, Valor_Uni, pedido_id, pedido_users_id, produtosvariasoes_id) 
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $item['Quantidade']); // Passando a quantidade como valor
            $stmt->bindValue(2, $item['Valor_Uni']); // Passando o valor unitário como valor
            $stmt->bindValue(3, $pedido_id); // Passando o id do pedido
            $stmt->bindValue(4, $user_id); // Passando o user_id
            $stmt->bindValue(5, $item['produtosvariasoes_id']); // Passando o id da variação do produto
            $stmt->execute();
        }

        // Opcional: Atualizar o status dos itens do carrinho para "processado"
        $stmt = $pdo->prepare("UPDATE itenscarrinho SET deleted_at = NOW() WHERE carrinho_users_id = ?");
        $stmt->bindValue(1, $user_id);
        $stmt->execute();
    }
}

// Chama a função para processar os pedidos
criarPedido($pdo);

echo "Pedidos e itens de pedido criados com sucesso!";
?>
