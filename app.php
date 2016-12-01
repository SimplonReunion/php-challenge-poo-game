<?php

use PublicVar\GameMinions\Displayer\Displayer;
use PublicVar\GameMinions\Engine\Game;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once __DIR__ . '/vendor/autoload.php';


$dispatcher = new EventDispatcher();
$displayer = new Displayer($dispatcher);
$game = new Game($dispatcher);

$mapLevel = isset($_GET['story']) ? $_GET['story'] : 1;

$game->mapLevel($mapLevel);



