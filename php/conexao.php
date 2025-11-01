<?php
$servidor = "localhost";
$usuario = "root";
$senha = "usbw";
$banco = "cata_grito";

// Criar conexão
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Opcional: definir charset para evitar problemas com acentuação
$conexao->set_charset("utf8");

?>