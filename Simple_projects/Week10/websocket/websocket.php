<?php

require_once("src/vendor/autoload.php");

use Devristo\Phpws\Framing\WebSocketFrame;
use Devristo\Phpws\Framing\WebSocketOpcode;
use Devristo\Phpws\Messaging\WebSocketMessageInterface;
use Devristo\Phpws\Protocol\WebSocketTransportInterface;
use Devristo\Phpws\Server\IWebSocketServerObserver;
use Devristo\Phpws\Server\UriHandler\WebSocketUriHandler;
use Devristo\Phpws\Server\WebSocketServer;

class ChatHandler extends WebSocketUriHandler {
    /**
     * Notify everyone when a user has joined the chat
     *
     * @param WebSocketTransportInterface $user
     */
    public function onConnect(WebSocketTransportInterface $user){
    }
    /**
     * Broadcast messages sent by a user to everyone in the room
     *
     * @param WebSocketTransportInterface $user
     * @param WebSocketMessageInterface $msg
     */
    public function onMessage(WebSocketTransportInterface $user, WebSocketMessageInterface $msg) {
        // $message = json_decode($msg->getData());
        var_dump($msg->getData());
        $this->logger->notice("Broadcasting " . strlen($msg->getData()) . " bytes");
        foreach($this->getConnections() as $client){
            
            $client->sendString($msg->getData());
        }
        
    }
}
class ChatHandlerForUnroutedUrls extends WebSocketUriHandler {
    /**
     * This class deals with users who are not routed
     */
    public function onConnect(WebSocketTransportInterface $user){		
    }
    public function onMessage(WebSocketTransportInterface $user, WebSocketMessageInterface $msg) {
        $this->logger->notice("User {$user->getId()} is not in a room but tried to say: {$msg->getData()}");
    }
}

$loop = \React\EventLoop\Factory::create();

// Create a logger which writes everything to the STDOUT
$logger = new \Zend\Log\Logger();
$writer = new Zend\Log\Writer\Stream("php://output");
$logger->addWriter($writer);

$server = new WebSocketServer("tcp://0.0.0.0:12345", $loop, $logger);

$router = new \Devristo\Phpws\Server\UriHandler\ClientRouter($server, $logger);

$router->addRoute('/\/chat/', new ChatHandler($logger));
$router->addRoute('/#^(.*)$#i/', new ChatHandlerForUnroutedUrls($logger));

$server->bind();

$loop->run();