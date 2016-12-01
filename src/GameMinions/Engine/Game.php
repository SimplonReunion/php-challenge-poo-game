<?php

namespace PublicVar\GameMinions\Engine;

use PublicVar\GameMinions\Character\Chef;
use PublicVar\GameMinions\Character\Hero;
use PublicVar\GameMinions\Character\Lieutenant;
use PublicVar\GameMinions\Character\Minions;
use PublicVar\GameMinions\Event\BaseGameEvent;
use PublicVar\GameMinions\Event\EndGameEvent;
use PublicVar\GameMinions\Event\EndRoundEvent;
use PublicVar\GameMinions\Event\GameEvents;
use PublicVar\GameMinions\Event\HeroArmorIncreasedEvent;
use PublicVar\GameMinions\Event\HeroLifeIncreasedEvent;
use PublicVar\GameMinions\Event\StartGameEvent;
use PublicVar\GameMinions\Event\StartRoundEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Description of Game
 *
 * @author 
 */
class Game
{

    private $hero;
    private $enemies;
    private $numberOfRound;
    private $eventDispatcher;

    const WAIT_TIME = 2;

    public function __construct(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->numberOfRound = 1;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Start a game
     */
    public function start()
    {
        $this->dispatchStartGame();
        for ($i = 0; $i < $this->numberOfRound; $i++) {
            
            $this->dispatchStartRound($i+1);
            
            if ($this->isHeroAlive()) {
                $this->randomHeroBonusLife();
                $this->randomHeroBonusArmor();
                

                $this->roundGame();

                $this->dispatchEndRound($i+1);
            }
            else {
                break;
            }
        }

        $this->stop();
    }
    
    /**
     * Generate bonus life for the hero. with 1 on 5 to gain life
     */
    private function randomHeroBonusLife()
    {
         if (mt_rand(1, 5) === 1) {
            $this->hero->increaseLife(50);
        }
    }
    
    /**
     * Generate bonus armor for the hero. with 1 on 5 to gain armor
     */
    private function randomHeroBonusArmor()
    {
         if (mt_rand(1, 3) === 1) {
            $this->hero->increaseArmor(20);
        }
    }

    /**
     * 
     * @return bool true if hero alive and false otherwise
     */
    private function isHeroAlive()
    {
        return $this->hero->getLife() > 0;
    }

    /**
     * Stop a game
     */
    public function stop()
    {
        $this->dispatchEndGame();
    }

    /**
     * It's there where the game logic happen, for every round of the game
     */
    public function roundGame()
    {
        //The hero attack the enemies
        foreach ($this->enemies as $enemy) {
            $this->hero->attack($enemy);
        }

        //The enemies attack the hero
        foreach ($this->enemies as $enemy) {
            $enemy->attack($this->hero);
        }
    }

    /**
     * Define the round's number for a game
     * 
     * @param int $numberOfRound
     */
    public function setRound(int $numberOfRound)
    {
        $this->numberOfRound = $numberOfRound;

        return $this;
    }
    
    /**
     * 
     * @return Game
     */
    public function generateHero()
    {
        $this->hero = Hero::create(200, 15);

        return $this;
    }

    /**
     * 
     * @return Game
     */
    public function generateMinion()
    {
        $this->enemies[] = Minions::create(20, 10);

        return $this;
    }

    /**
     * 
     * @return Game
     */
    public function generateLieutenant()
    {
        $this->enemies[] = Lieutenant::create(40, 30);

        return $this;
    }

    /**
     * 
     * @return Game
     */
    public function generateChef()
    {
        $this->enemies[] = Chef::create(60, 100);

        return $this;
    }

    /**
     * Select the map level
     * @param int $mapLevel 
     */
    public function mapLevel($mapLevel)
    {
        $this->generateHero();

        echo "Map level: $mapLevel";
        echo "<br />\n";
        switch ($mapLevel) {
            case 1:
                /**
                 * héros récupère un bonus de vie (afficher la vie avant le 
                 * bonus puis après)
                 */
                $this->dispatchStartGame();
                $this->hero->increaseLife(50);
                $this->dispatchHeroLifeIncreased();
                break;
            case 2:
                /**
                 * Le héros récupère un bonus d'armure (afficher la quantité 
                 * d'armure avant puis après)
                 */
                $this->dispatchStartGame();
                $this->hero->increaseArmor(20);
                $this->dispatchHeroArmorIncreased();
                break;
            case 3:
                /**
                 * Le héros se fait un attaquer par un minion(afficher la vie 
                 * avant l'attaque puis après)
                 */
                $this->dispatchStartGame();
                $this->dispatchStartRound(1);
                
                $this->generateMinion();
                $this->enemies[0]->attack($this->hero);
                
                $this->dispatchEndRound(1);
                $this->dispatchEndGame();
                break;

            case 4:
                /**
                 * Le héros récupère de l'armure puis se fait attaquer par un 
                 * lieutenant minion (afficher la vie avant l'attaque puis après)
                 */
                
                $this->hero->increaseArmor(20);
                
                $this->dispatchStartGame();
                $this->dispatchStartRound(1);
                
                $this->generateLieutenant();
                $this->enemies[0]->attack($this->hero);
                
                $this->dispatchEndRound(1);
                $this->dispatchEndGame();
                break;
            case 5:
                /**
                 * Le héros doit combattre le chef minion durant 5 tours. Avant 
                 * chaque tour le héros a 1 chance sur 3 d'obtenir de l'armure 
                 * et 1 chance sur 5 d'obtenir de la vie. A chaque round le héros 
                 * attaque le chef minion puis le chef minion attaque le héros 
                 * (Afficher pour chaques round: la valeur d'armure et la quantité 
                 * de vie avant chaque attaque)
                 */
                $this->generateChef();
                $this->numberOfRound = 5;
                $this->start();
                break;

        }
        echo "<hr>";
    }
    
    private function dispatchStartGame()
    {
        if($this->eventDispatcher){
            $this->eventDispatcher->dispatch(GameEvents::START_GAME, new StartGameEvent($this->hero, $this->enemies));
        }
    }
    
    private function dispatchEndGame()
    {
        if($this->eventDispatcher){
            $this->eventDispatcher->dispatch(GameEvents::END_GAME, new EndGameEvent($this->hero, $this->enemies));
        }
    }
    
    private function dispatchStartRound($roundNumber)
    {
       if($this->eventDispatcher){
            $this->eventDispatcher->dispatch(GameEvents::START_ROUND, new StartRoundEvent($this->hero, $this->enemies,$roundNumber));
        } 
    }
    
    private function dispatchEndRound($roundNumber)
    {
       if($this->eventDispatcher){
            $this->eventDispatcher->dispatch(GameEvents::END_ROUND, new EndRoundEvent($this->hero, $this->enemies,$roundNumber));
        } 
    }
    
    private function dispatchHeroLifeIncreased()
    {
        if($this->eventDispatcher){
            $this->eventDispatcher->dispatch(GameEvents::HERO_LIFE_INCREASED, new HeroLifeIncreasedEvent($this->hero));
        }
    }
    
    private function dispatchHeroArmorIncreased()
    {
        if($this->eventDispatcher){
            $this->eventDispatcher->dispatch(GameEvents::HERO_ARMOR_INCREASED, new HeroArmorIncreasedEvent($this->hero));
        }
    }

}
