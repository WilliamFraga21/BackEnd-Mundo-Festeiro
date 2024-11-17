<?php

namespace MiniRest\Http\Controllers;

use Illuminate\Support\Facades\Http;
use MiniRest\Http\Auth\Auth;
use MiniRest\Http\Request\Request;
use MiniRest\Http\Response\Response;
use MiniRest\Models\Chamada;
use MiniRest\Models\FacialRecognition;
use MiniRest\Storage\DiskStorage;
use MiniRest\Storage\UUIDFileName;
use PDOException;




class FacialController extends Controller
{


    private Chamada $chamada;

    public function __construct()
    {
        $this->chamada = new Chamada();

    }

    public function reconhecer(Request $request)
    {
        // Valida a requisição, certificando-se de que a imagem está presente
        $validated = $request->rules(['dados_face' => 'required|string'])->validate();

        // Pega a imagem Base64 do corpo da requisição
        $imagemBase64 = $request->json('dados_face');

        // Remove o prefixo 'data:image/png;base64,' ou qualquer outro prefixo base64
        $imagemBase64 = preg_replace('/^data:image\/\w+;base64,/', '', trim($imagemBase64));

        // Verifica se o base64 é válido
        if (base64_encode(base64_decode($imagemBase64, true)) !== $imagemBase64) {
            Response::json(['error' => 'Base64 inválido'], 400);
            return;
        }

        // Gera o nome UUID para a imagem
        $fileName = UUIDFileName::uuidFileName('imagem_face.png');  // Gera o nome com UUID

        // Defina o caminho para armazenar a imagem
        $basePath = __DIR__ . '/../../../storage/facial_images/';
        $storage = new DiskStorage($basePath);

        // Armazena a imagem fisicamente
        try {
            // Converte o Base64 para binário
            $imageData = base64_decode($imagemBase64);

            // Armazena o arquivo no diretório de imagens
            $storage->put($fileName, $imageData);
            // Salva os dados no banco de dados
            $reconhecimento = new FacialRecognition();
            $reconhecimento->imagem_base64 = $fileName; // Salva o nome do arquivo, não o Base64
            $reconhecimento->posicoes = $request->json('posicoes');
            // Supondo que as posições são enviadas na requisição
            $reconhecimento->users_id = Auth::id($request);
            $reconhecimento->save();
        } catch (PDOException $exception) {
            Response::json(['error' => 'Erro ao salvar imagem: ' . $exception->getMessage()], 500);
            return;
        }

        // Chama o método para enviar a imagem para o servidor Python para validação
        $respostaPython = $this->enviarParaPython($imagemBase64);

        // Verifica a resposta da API Python
        if (isset($respostaPython['erro'])) {
            Response::json(['error' => $respostaPython['erro']], 500);
            return;
        }

        // Caso o Python retorne um erro
        if (isset($respostaPython['mensagem']) && strpos($respostaPython['mensagem'], 'Nenhum rosto detectado') !== false) {
            Response::json(['error' => 'Nenhum rosto detectado na imagem'], 400);
            return;
        }

        // Caso o reconhecimento facial seja bem-sucedido, envia a resposta ao cliente
        Response::json([
            'success' => [
                'message' => 'Imagem enviada para reconhecimento facial.',
                'data' => [
                    'imagem' => $fileName, // Retorna o nome do arquivo salvo
                    'posicoes' => $request->json('posicoes'), // Decodifica as posições
                    'reconhecimento' => $respostaPython
                ]
            ]
        ]);
    }



    /**
     * Função para enviar a imagem para a API Python e receber a resposta.
     *
     * @param string $imagemBase64
     * @return array
     */
    public function enviarParaPython(Request $request)
    {

        // Lê o corpo da requisição e converte de JSON para array associativo
        $dataFront = json_decode(file_get_contents('php://input'), true);
// Dados que serão enviados como JSON
        $data = array(
            'imagem' => $dataFront['imagem'],
            'users_id' => Auth::id($request)
        );

// Inicializando cURL
        $ch = curl_init('http://localhost:5000/salvar_rosto');  // URL do servidor Flask

// Definindo as opções da requisição cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Para capturar a resposta
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',  // Definindo o tipo de conteúdo como JSON
        ));
        curl_setopt($ch, CURLOPT_POST, true);  // Especificando o método POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  // Converte os dados para JSON

// Executando a requisição e obtendo a resposta
        $response = curl_exec($ch);

// Verificando se ocorreu algum erro
        if(curl_errno($ch)) {
            echo 'Erro cURL: ' . curl_error($ch);
        } else {
            // Exibindo a resposta do servidor Flask
            echo 'Resposta do servidor: ' . $response;
        }

// Fechando a conexão cURL
        curl_close($ch);

        // Retorna a resposta da API Python (decodificada)
        return json_decode($response, true);
    }





    public function byid(Request $request,$id){

        $data = $this->chamada->where('prestador_has_evento_evento_id',$id)->get();





        Response::json(['chamada' => $data]);

    }




    public function reconhecerRosto(Request $request)
    {
        $validation = $request->rules([
            'prestador_has_evento_evento_id' => 'required',
            'prestador_has_evento_id' => 'required',
            'prestador_has_evento_prestador_id' => 'required',

        ])->validate();

        if (!$validation) {
            $request->errors();
            return;
        }
        // Lê o corpo da requisição e converte de JSON para array associativo
        $dataFront = json_decode(file_get_contents('php://input'), true);
// Dados que serão enviados como JSON
        $data = array(
            'imagem' => $dataFront['imagem'],

        );

// Inicializando cURL
        $ch = curl_init('http://localhost:5000/reconhecer_rosto');  // URL do servidor Flask

// Definindo as opções da requisição cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Para capturar a resposta
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',  // Definindo o tipo de conteúdo como JSON
        ));
        curl_setopt($ch, CURLOPT_POST, true);  // Especificando o método POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  // Converte os dados para JSON

// Executando a requisição e obtendo a resposta
        $response = curl_exec($ch);

//// Verificando se ocorreu algum erro
//        if(curl_errno($ch)) {
//            echo 'Erro cURL: ' . curl_error($ch);
//        } else {
//            // Exibindo a resposta do servidor Flask
//            echo 'Resposta do servidor: ' . $response;
//        }

// Fechando a conexão cURL
        curl_close($ch);

        $data = json_decode($response, true);


        if ($data['mensagem'] == 'Rosto reconhecido'){

            $this->chamada->firstOrCreate([
            'prestador_has_evento_id' => $dataFront['prestador_has_evento_id'],
            'prestador_has_evento_prestador_id' => $dataFront['prestador_has_evento_prestador_id'],
            'prestador_has_evento_evento_id' => $dataFront['prestador_has_evento_evento_id'],
            ]);


            Response::json(['success' => ['message' => 'Chamada criada com sucesso']]);
        }


        // Retorna a resposta da API Python (decodificada)
    }


    /**
     * Função para comparar rostos.
     *
     * @param string $imagemBase64
     * @param string $imagemRegistradaBase64
     * @return array
     */





}
