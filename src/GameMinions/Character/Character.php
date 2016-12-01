<?php

namespace PublicVar\GameMinions\Character;

/**
 * Description of Character
 *
 * @author 
 */
class Character implements InterfaceCharacter
{

    protected $life;
    protected $power;

    static function create(int $life, int $power)
    {
        $className = get_called_class();
        //create an object according to a string
        $character = new $className();
        $character->setLife($life)
            ->setPower($power);
        return $character;
    }

    public function attack(InterfaceCharacter $character)
    {
        $character->suffer($this->power);
        
        return $this;
    }

    public function suffer(int $damage)
    {
        $this->life -= $damage;
    }

    public function getLife()
    {
        return $this->life;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function setLife($life)
    {
        $this->life = $life;
        return $this;
    }

    public function setPower($power)
    {
        $this->power = $power;
        return $this;
    }

}
