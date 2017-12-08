<?php
//session_start();
// Remove da URL a pasta da aplicacao,
// deixando apenas os parametros.
$aux = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
$parameters = str_replace($aux, '', $_SERVER['REQUEST_URI']);

// Recupera as partes da URL.
// Se você acessar http://meusite.com.br/criacao-sites
// $urlParts será:
//      array('criacao-sites')
//
// Se você acessar http://meusite.com.br/criacao-sites/blogs
// $urlParts será:
//      array('criacao-sites', 'blogs')
$urlParts = explode('/', $parameters);

// Com base nas partes redirecione como desejar.
if ($urlParts[0]=='criacao-sites')
    require_once 'criacao-sites.php';
else if ($urlParts[0]=='contato')
    require_once 'contato.php';
else
    require_once 'erro-404.php';
?>