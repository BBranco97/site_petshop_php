<?php

function isMetodo($metodo){
    if (!strcasecmp($_SERVER['REQUEST_METHOD'], $metodo)) {
        return true;
    }
    return false;
}

function pValidation($metodo, $lista){
    $obtido = array_keys($metodo);
    $naoEncontrado = array_diff($lista, $obtido);
    if (empty($naoEncontrado)) {
        foreach ($lista as $p) {
            if (empty(trim($metodo[$p])) and trim($metodo[$p]) != "0") {
                return false;
            }
        }
        return true;
    }
    return false;
}