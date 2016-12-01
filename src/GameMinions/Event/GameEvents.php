<?php

namespace PublicVar\GameMinions\Event;

/**
 * Description of GameEvents
 *
 * @author 
 */
abstract class GameEvents
{
    const START_GAME = "game.start";
    const END_GAME = "game.end";
    const START_ROUND = "game.round.start";
    const END_ROUND = "game.round.end";
    const BEFORE_ATTACK = "game.before_attack";
    const AFTER_ATTACK = "game.after_attack";
    const HERO_LIFE_INCREASED = "game.hero.life_increased";
    const HERO_ARMOR_INCREASED = "game.hero.armor_increased";
}
