<?php

// Defina a URL da sua API
$url = "http://localhost:8000/produtos";

// Número de loops (com 5 requisições por loop)
$num_loops = 1000;

for ($i = 1; $i <= $num_loops; $i++) {
    echo "Iniciando loop $i\n";

    // Fazendo 5 requisições dentro de cada loop
    for ($j = 1; $j <= 5; $j++) {
        // Inicializa o curl
        $ch = curl_init();

        // Configura o curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Receber resposta
        curl_setopt($ch, CURLOPT_HEADER, false);  // Não mostrar o cabeçalho

        // Executa a requisição
        $response = curl_exec($ch);

        // Verifica se houve algum erro
        if (curl_errno($ch)) {
            echo "Erro ao fazer a requisição $i.$j: " . curl_error($ch) . "\n";
        } else {
            echo "Requisição $i.$j realizada com sucesso.\n";
        }

        // Fecha a sessão curl
        curl_close($ch);
    }
    echo "Loop $i concluído\n";
}
