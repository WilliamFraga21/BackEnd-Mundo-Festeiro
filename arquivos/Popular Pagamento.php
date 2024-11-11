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

// Função para gerar uma data aleatória entre hoje e 1 ano à frente
function gerarDataAleatoria() {
    // Obtém a data de hoje (timestamp)
    $dataHoje = time();
    
    // Gera um timestamp aleatório entre hoje e 1 ano à frente (31536000 segundos = 1 ano)
    $timestampAleatorio = rand($dataHoje, $dataHoje + 31536000); // 1 ano em segundos

    // Converte o timestamp para a data no formato 'Y-m-d H:i:s'
    return date('Y-m-d H:i:s', $timestampAleatorio);
}

// Função para processar o pagamento dos pedidos
function processarPagamento($pdo) {
    // Contar o total de pedidos pendentes
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM pedido WHERE Status = 'Pendente'");
    $stmt->execute();
    $totalPedidos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Calcular 86% do total de pedidos
    $pedidosParaFinalizar = ceil($totalPedidos * 0.86);

    // Selecionar 86% dos pedidos pendentes
    $stmt = $pdo->prepare("SELECT p.id AS pedido_id, p.users_id AS pedido_users_id
                           FROM pedido p
                           LEFT JOIN pagamentos pg ON p.id = pg.pedido_id
                           WHERE p.Status = 'Pendente' AND pg.id IS NULL
                           LIMIT ?");
    $stmt->bindValue(1, $pedidosParaFinalizar, PDO::PARAM_INT);
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Processar cada pedido
    foreach ($pedidos as $pedido) {
        // 1. Calcular o valor total do pedido com base nos itens do pedido
        $stmt = $pdo->prepare("SELECT SUM(ip.Quantidade * ip.Valor_Uni) AS valor_total
                               FROM itenspedido ip
                               WHERE ip.pedido_id = ? AND ip.pedido_users_id = ?");
        $stmt->bindValue(1, $pedido['pedido_id']);
        $stmt->bindValue(2, $pedido['pedido_users_id']);
        $stmt->execute();
        $valor_total = $stmt->fetch(PDO::FETCH_ASSOC)['valor_total'];

        // 2. Definir os dados do pagamento
        $metodo_pagamento = 'Cartão de Crédito'; // Exemplo de método de pagamento
        $status_pagamento = 'Confirmado'; // Status do pagamento
        $data_pagamento = gerarDataAleatoria(); // Data aleatória entre hoje e 1 ano
        $localidade_id = rand(1, 150); // Selecionar aleatoriamente um ID de localidade entre 1 e 150
        $cupom_id = null; // Cupom pode ser null

        // 3. Inserir o pagamento na tabela
        $stmt = $pdo->prepare("INSERT INTO pagamentos (Valor, Metodo_Pagamento, Status, Data_Pagamento, pedido_id, pedido_users_id, localidade_id, cupom_id) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $valor_total);
        $stmt->bindValue(2, $metodo_pagamento);
        $stmt->bindValue(3, $status_pagamento);
        $stmt->bindValue(4, $data_pagamento);
        $stmt->bindValue(5, $pedido['pedido_id']);
        $stmt->bindValue(6, $pedido['pedido_users_id']);
        $stmt->bindValue(7, $localidade_id);
        $stmt->bindValue(8, $cupom_id);
        $stmt->execute();

        // 4. Atualizar o status do pedido para 'Finalizado' ou outro status
        $stmt = $pdo->prepare("UPDATE pedido SET Status = 'Finalizado' WHERE id = ? AND users_id = ?");
        $stmt->bindValue(1, $pedido['pedido_id']);
        $stmt->bindValue(2, $pedido['pedido_users_id']);
        $stmt->execute();
    }

    echo "Pagamentos e pedidos processados com sucesso!";
}

// Chama a função para processar pagamentos
processarPagamento($pdo);
?>
