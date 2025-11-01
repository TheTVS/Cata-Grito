<?php
include('conexao.php'); // usa sua conexão já existente

$upload_dir = "uploads/";
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

// nome do arquivo com data e hora
$filename = $upload_dir . "foto_" . date("Ymd_His") . ".jpg";

// lê os bytes da imagem enviada
$data = file_get_contents("php://input");

if ($data) {
    // salva o arquivo no servidor
    if (file_put_contents($filename, $data)) {

        // dados para o banco
        $data_foto = date("Y-m-d");
        $grito = 0;
        $evento_id = 1; // temporário, fixo

        // comando SQL preparado
        $sql = "INSERT INTO foto (data, grito, caminho_foto, evento_id)
                VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sisi", $data_foto, $grito, $filename, $evento_id);

        if ($stmt->execute()) {
            echo "Foto salva e registrada com sucesso! Caminho: $filename";
        } else {
            http_response_code(500);
            echo "Erro ao registrar no banco: " . $stmt->error;
        }

        $stmt->close();
        $conexao->close();
    } else {
        http_response_code(500);
        echo "Erro ao salvar o arquivo no servidor.";
    }
} else {
    http_response_code(400);
    echo "Nenhum dado recebido.";
}
?>
