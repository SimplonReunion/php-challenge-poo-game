<?php

use PublicVar\GameMinions\Engine\Game;

require_once __DIR__ . '/vendor/autoload.php';

$game = new Game();

$mapLevel = isset($_GET['story']) ? $_GET['story'] : 1;

$game->mapLevel($mapLevel);



