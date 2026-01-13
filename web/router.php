<?php

// Router simple pour le serveur PHP intégré
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si c'est un fichier statique qui existe, le servir directement
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    // Déterminer le type MIME
    $extension = pathinfo($uri, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject'
    ];
    
    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }
    
    return false; // Servir le fichier directement
}

// Sinon, router vers Symfony
$_SERVER['SCRIPT_NAME'] = '/app_dev.php';
require __DIR__ . '/app_dev.php';
