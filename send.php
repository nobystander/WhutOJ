<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost',5672,'guest','guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$data = implode(' ', array_slice($argv, 1));
 $data = 123;


$msg = new AMQPMessage($data,
                        array('delivery_mode' => 2) # make message persistent
                      );
for($i = 0;$i < 100;$i++)
    $channel->basic_publish($msg, '', 'hello');

echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

?>