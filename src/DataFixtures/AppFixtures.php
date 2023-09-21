<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hthcard;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadHthcards($manager);
        
        $manager->flush();
    }
    
    private function loadHthcards(ObjectManager $manager)
    {
        foreach ($this->getHthcardsData() as [$name, $description, $manacost, $isminion]) {
            $card = new Hthcard();
            $card->setName($name);
            $card->setDescription($description);
            $card->setManacost($manacost);
            $card->setIsminion($isminion);
            
            $manager->persist($card);
        }
        $manager->flush();
    }
    
    private function getHthcardsData()
    {
        // todo = [title, completed];
        yield ['Murloc', 'This is an incredible description', 2, true];
        yield ['Reno', 'A true explorer', 7, true];
        yield ['Lord Jaraxxux', 'A real demon', 8,  true];
        
    }
    
}
