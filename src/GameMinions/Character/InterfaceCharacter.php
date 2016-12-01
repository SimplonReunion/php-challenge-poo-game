<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PublicVar\GameMinions\Character;

/**
 *
 * @author nicolas
 */
interface InterfaceCharacter
{
    /**
     * 
     * @param InterfaceCharacter $character
     */
    public function attack(InterfaceCharacter $character);
    /**
     * When a character is attacked he suffers damages.
     * @param int $damage
     */
    public function suffer(int $damage);
}
