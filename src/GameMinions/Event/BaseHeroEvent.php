<?php

namespace PublicVar\GameMinions\Event;

use PublicVar\GameMinions\Character\Hero;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of BaseHeroEvent
 *
 * @author 
 */
class BaseHeroEvent extends Event
{
    private $hero;
    
    public function __construct(Hero $hero)
    {
        $this->hero = $hero;
    }
    
    public function getHero()
    {
        return $this->hero;
    }

    public function setHero($hero)
    {
        $this->hero = $hero;
        return $this;
    }


}
