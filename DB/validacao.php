<?php

function vazio($var, $texto, $caminho, $ms, $data)  {
    if(empty($var)){
        $t = "O campo ".$texto." está vazio";
        header("Location: $caminho?$ms=$t&$data");
        exit;
    }
    return 0;
}