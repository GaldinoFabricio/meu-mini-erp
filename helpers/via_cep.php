<?php
function buscarEnderecoPorCep($cep) {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    $url = "https://viacep.com.br/ws/$cep/json/";

    $resposta = file_get_contents($url);
    return json_decode($resposta, true);
}
