<?php

namespace PublicVar\GameMinions\Engine;

use PublicVar\GameMinions\Character\Chef;
use PublicVar\GameMinions\Character\Hero;
use PublicVar\GameMinions\Character\Lieutenant;
use PublicVar\GameMinions\Character\Minions;

/**
 * Description of Game
 *
 * @author 
 */
class Game
{

    private $hero;
    private $enemy;
    private $numberOfRound;

    const WAIT_TIME = 2;

    public function __construct()
    {
        $this->numberOfRound = 1;
    }

    /**
     * Start a game
     */
    public function start()
    {
        for ($i = 0; $i < $this->numberOfRound; $i++) {

            if ($this->isHeroAlive()) {
                $this->randomHeroBonusLife();
                $this->randomHeroBonusArmor();
                
                //c'est moche mais c'est pour voir.
                echo "round Number : " . ($i + 1);
                echo "<br>\n";
                echo "before the round : ";
                echo "<br>\n";
                
                $this
                    ->displayHeroLife()
                    ->displayHeroArmor()
                ;

                $this->roundGame();


                echo "after the round : ";
                echo "<br>\n";

                $this
                    ->displayHeroLife()
                    ->displayHeroArmor()
                ;

                echo "<br>\n";
                echo "<br>\n";
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

    private function displayHeroLife()
    {
        echo "hero life : " . $this->hero->getLife();
        echo "<br>\n";
        return $this;
    }

    private function displayHeroArmor()
    {
        echo "hero armor : " . $this->hero->getArmor();
        echo "<br>\n";
        return $this;
    }

    /**
     * Stop a game
     */
    public function stop()
    {
        echo "Fin !";
    }

    /**
     * It's there where the game logic happen, for every round of the game
     */
    public function roundGame()
    {
        //The hero attack the enemies
        foreach ($this->enemy as $enemy) {
            $this->hero->attack($enemy);
        }

        //The enemies attack the hero
        foreach ($this->enemy as $enemy) {
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
        $this->enemy[] = Minions::create(20, 10);

        return $this;
    }

    /**
     * 
     * @return Game
     */
    public function generateLieutenant()
    {
        $this->enemy[] = Lieutenant::create(40, 30);

        return $this;
    }

    /**
     * 
     * @return Game
     */
    public function generateChef()
    {
        $this->enemy[] = Chef::create(60, 100);

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
                echo "life Hero : " . $this->hero->getLife();
                echo "<br />\n";
                $this->hero->increaseLife(50);
                echo "life Hero : " . $this->hero->getLife();
                break;
            case 2:
                /**
                 * Le héros récupère un bonus d'armure (afficher la quantité 
                 * d'armure avant puis après)
                 */
                echo "armor Hero : " . $this->hero->getArmor();
                echo "<br />\n";
                $this->hero->increaseArmor(20);
                echo "armor Hero : " . $this->hero->getArmor();
                break;
            case 3:
                /**
                 * Le héros se fait un attaquer par un minion(afficher la vie 
                 * avant l'attaque puis après)
                 */
                $this->generateMinion();
                echo "life Hero : " . $this->hero->getLife();
                echo "<br />\n";
                $this->enemy[0]->attack($this->hero);
                echo "life Hero : " . $this->hero->getLife();
                echo "<br />\n";
                break;

            case 4:
                /**
                 * Le héros récupère de l'armure puis se fait attaquer par un 
                 * lieutenant minion (afficher la vie avant l'attaque puis après)
                 */
                $this->generateLieutenant();
                echo "life Hero : " . $this->hero->getLife();
                echo "<br />\n";
                $this->hero->increaseArmor(20);
                echo "life Armor : " . $this->hero->getArmor();
                echo "<br />\n";
                $this->enemy[0]->attack($this->hero);
                echo "Lieutenant attack hero";
                echo "<br />\n";
                echo "life Hero : " . $this->hero->getLife();
                echo "<br />\n";
                echo "life Armor : " . $this->hero->getArmor();
                echo "<br />\n";
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

}
