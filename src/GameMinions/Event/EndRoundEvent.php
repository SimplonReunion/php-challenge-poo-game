<?php

namespace PublicVar\GameMinions\Event;

use PublicVar\GameMinions\Character\InterfaceCharacter;

/**
 * Description of EndRoundEvent
 *
 * @author 
 */
class EndRoundEvent extends BaseGameEvent
{

    private $roundNumber;

    public function __construct(InterfaceCharacter $hero = null, array $enemies = null, $roundNumber = 1)
    {
        parent::__construct($hero, $enemies);
        $this->roundNumber = $roundNumber;
    }

    public function getRoundNumber()
    {
        return $this->roundNumber;
    }

    public function setRoundNumber($roundNumber)
    {
        $this->roundNumber = $roundNumber;
        return $this;
    }

}
