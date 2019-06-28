<?php

$host = '127.0.0.1';
$port = 88;

echo "\n";
echo "================================\n";
echo "Serving from /public\n";
echo "Available at http://$host:$port\n";
echo "================================\n";
echo "\n";

exec("php -S $host:$port -t public");