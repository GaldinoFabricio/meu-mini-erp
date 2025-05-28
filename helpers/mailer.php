<?php
function enviarEmail($para, $assunto, $mensagem) {
    $headers = "From: sistema@mini-erp.com.br\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($para, $assunto, $mensagem, $headers);
}
