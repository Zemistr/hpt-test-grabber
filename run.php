<?php

declare(strict_types=1);

use HPT\CzcHttpGrabber;
use HPT\Dispatcher;
use HPT\HttpClient;
use HPT\JsonOutputFormatter;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;

require_once __DIR__ . '/vendor/autoload.php';

$storage = new FileStorage(__DIR__ . '/var/cache');
$cache = new Cache($storage);

$httpClient = new HttpClient();
$httpClient->setCache($cache);

$grabber = new CzcHttpGrabber($httpClient);
$output = new JsonOutputFormatter();

$dispatcher = new Dispatcher($grabber, $output);
echo $dispatcher->run();
