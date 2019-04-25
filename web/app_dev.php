<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
/* debug :
  echo "<b>_SERVER</b><br>\n";
  foreach($_SERVER as $k => $v) {
    echo $k . ' = ' . $v;
    echo "<br>\n";
  }
  echo "<b>_REQUEST</b><br>\n";
  foreach($_REQUEST as $k => $v) {
    echo $k . ' = ' . $v;
    echo "<br>\n";
  }
  echo "<b>apache headers:</b><br>\n";
  foreach(apache_request_headers() as $k => $v) {
    echo "$k : $v<br>\n";
  }
*/
/*
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
) {
*/
if (!in_array($ip, array('127.0.0.1', 'fe80::1', '::1', '***REMOVED***', '***REMOVED***', '***REMOVED***'))) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.'.$ip);
}

//$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
require __DIR__.'/../app/autoload.php';
Debug::enable();

//require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
