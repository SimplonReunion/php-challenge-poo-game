<?php

namespace PublicVar\GameMinions\Event;

use PublicVar\GameMinions\Character\InterfaceCharacter;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of BaseGameEvent
 *
 * @author 
 */
class BaseGameEvent extends Event
{
    private $hero;
    private $enemies;
    
    public function __construct(InterfaceCharacter $hero = null, array $enemies = null)
    {
        $this->hero = $hero;
        $this->enemies = $enemies;
    }
    
    public function getHero()
    {
        return $this->hero;
    }

    public function getEnemies()
    {
        return $this->enemies;
    }

    public function setHero($hero)
    {
        $this->hero = $hero;
        return $this;
    }

    public function setEnemies($enemies)
    {
        $this->enemies = $enemies;
        return $this;
    }


}
