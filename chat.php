<?php
require_once __DIR__ . '/vendor/autoload.php';
include("./RequestInterceptor.php");
include("./_connect.php");
include("./_inc/Class.Login.php");
include("./_inc/Class.messages.php");
use Ratchet\Server\IoServer;
$app = IoServer::factory(
    new \Ratchet\Http\HttpServer(
            new \Ratchet\WebSocket\WsServer(
                new Chat()
            )
    ),
        8080
);
$app->run();