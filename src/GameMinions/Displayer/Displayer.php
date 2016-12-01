<?php

namespace PublicVar\GameMinions\Displayer;

use PublicVar\GameMinions\Event\EndGameEvent;
use PublicVar\GameMinions\Event\EndRoundEvent;
use PublicVar\GameMinions\Event\GameEvents;
use PublicVar\GameMinions\Event\HeroArmorIncreasedEvent;
use PublicVar\GameMinions\Event\HeroLifeIncreasedEvent;
use PublicVar\GameMinions\Event\StartGameEvent;
use PublicVar\GameMinions\Event\StartRoundEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Manage the messages display. 
 *
 * @author 
 */
class Displayer
{

    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->initListener();
    }

    private function initListener()
    {
        if ($this->eventDispatcher) {
            $this->eventDispatcher->addListener(GameEvents::START_GAME, array($this, 'onStartGame'));
            $this->eventDispatcher->addListener(GameEvents::START_ROUND, array($this, 'onStartRound'));
            $this->eventDispatcher->addListener(GameEvents::END_ROUND, array($this, 'onEndRound'));
            $this->eventDispatcher->addListener(GameEvents::END_GAME, array($this, 'onEndGame'));
            $this->eventDispatcher->addListener(GameEvents::HERO_LIFE_INCREASED, array($this, 'onHeroLifeIncreased'));
            $this->eventDispatcher->addListener(GameEvents::HERO_ARMOR_INCREASED, array($this, 'onHeroArmorIncreased'));
        }
    }

    public function displayHeroLife(int $life)
    {
        echo "# Hero life : $life <br>\n";
    }

    public function displayHeroArmor(int $armor)
    {
        echo "# Hero armor : $armor <br>\n";
    }

    public function displayStartGame()
    {
        echo ">>> Game start <<<<br>\n";
    }

    public function displayEndGame()
    {
        echo "<br>>>> End of the game <<< <br>\n";
    }

    public function displayStartRound($number)
    {
        echo "<br>> Start round number: $number <br>\n";
    }

    public function displayEndRound($number)
    {
        echo "> End round number: $number <br>\n";
    }
    
    public function displayHeroLifeIncreased($life){
        echo "~ Hero life Increased !!!<br>\n";
        $this->displayHeroLife($life);
    }
    
    public function displayHeroArmorIncreased($armor){
        echo "~ Hero armor Increased !!!<br>\n";
        $this->displayHeroArmor($armor);
    }

    public function onStartGame(StartGameEvent $startGameEvent)
    {
        $hero = $startGameEvent->getHero();
        $this->displayStartGame();
        $this->displayHeroLife($hero->getLife());
        $this->displayHeroArmor($hero->getArmor());
    }

    public function onStartRound(StartRoundEvent $startRoundEvent)
    {
        $number = $startRoundEvent->getRoundNumber();
        $hero = $startRoundEvent->getHero();

        $this->displayStartRound($number);
        $this->displayHeroLife($hero->getLife());
        $this->displayHeroArmor($hero->getArmor());
    }

    public function onEndRound(EndRoundEvent $endRoundEvent)
    {
        $number = $endRoundEvent->getRoundNumber();
        $hero = $endRoundEvent->getHero();

        $this->displayEndRound($number);
        $this->displayHeroLife($hero->getLife());
        $this->displayHeroArmor($hero->getArmor());
    }

    public function onEndGame(EndGameEvent $endGameEvent)
    {
        $this->displayEndGame();
    }

    public function onHeroLifeIncreased(HeroLifeIncreasedEvent $heroLifeIncreased)
    {
        $hero = $heroLifeIncreased->getHero();
        $this->displayHeroLifeIncreased($hero->getLife());
    }
    
    public function onHeroArmorIncreased(HeroArmorIncreasedEvent $heroArmorIncreased)
    {
        $hero = $heroArmorIncreased->getHero();
        $this->displayHeroArmorIncreased($hero->getArmor());
    }

}
