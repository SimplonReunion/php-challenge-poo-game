<?php

namespace PublicVar\GameMinions\Character;

/**
 * Description of Hero
 *
 * @author 
 */
class Hero extends Character
{

    private $armor;

    public function __construct()
    {
        $this->armor = 0;
    }

    /**
     * 
     * @param int $armor
     * @return Hero
     */
    public function increaseArmor(int $armor)
    {
        $this->armor += $armor;

        return $this;
    }

    /**
     * 
     * @param type $life
     * @return Hero
     */
    public function increaseLife($life)
    {
        $this->life += $life;

        return $this;
    }

    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * The hero has an armor. So before When he's taking damage, the damage is reduced
     * the armor when there are some
     * 
     * @param int $damage
     * @return Hero
     */
    public function suffer(int $damage)
    {
       

        if ($damage >= $this->armor) {
            $this->life = $this->life + $this->armor;
            $this->life -= $damage;
            $this->armor = 0;
        }

        if ($damage < $this->armor) {
            $this->armor -= $damage;
        }
        
        if ($this->life < 0) {
            $this->life = 0;
        }
        
        return $this;
    }

}
