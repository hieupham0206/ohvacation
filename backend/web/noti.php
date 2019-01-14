<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Transfer-Encoding: identity');
header('Access-Control-Allow-Origin: *');

$lastEventId = (float)(isset($_SERVER['HTTP_LAST_EVENT_ID']) ? $_SERVER['HTTP_LAST_EVENT_ID'] : 0);
if ($lastEventId == 0) {
    $lastEventId = (float)(isset($_GET['lastEventId']) ? $_GET['lastEventId'] : 0);
}

echo ':' . str_repeat(' ', 2048) . "\n"; // 2 kB padding for IE
echo "retry: 2000\n";

$counter = mt_rand(1, 10);
$t       = time();
while ((time() - $t) < 15) {
    // Every second, sent a "ping" event.
    echo 'id: ' . $t . "\n";
    echo 'data: ' . $t . ";\n\n";
    ob_flush();
    flush();
    sleep(1);
}

// event-stream
//$i = $lastEventId;
//$c = $i + 100;
//while (++$i < $c) {
//    echo 'id: ' . $i . "\n";
//    echo 'data: ' . $i . ";\n\n";
//    ob_flush();
//    flush();
//    sleep(1);
//}