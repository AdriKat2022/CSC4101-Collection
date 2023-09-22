<?php

namespace App\DataFixtures;

use App\Entity\HearthstoneCardbook;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hthcard;
use App\Repository\HearthstoneCardbookRepository;
use Exception;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadHearthstoneCardBooks($manager);
        $this->loadHthcards($manager);
        
        $manager->flush();
    }
    
    private function loadHthcards(ObjectManager $manager)
    {
        foreach ($this->getHthcardsData() as [$name, $description, $manacost, $isminion, $bookName]) {
            $card = new Hthcard();
            $card->setName($name);
            $card->setDescription($description);
            $card->setManacost($manacost);
            $card->setIsminion($isminion);



            $book = $manager->getRepository(HearthstoneCardbook::class)->findByName($bookName);

            if($bookName == null){
                throw new Exception("Lors de la création des cartes, le livre du nom ". $bookName ." n'a pas été trouvé !");
            }

            $card->setHearthstoneCardbook($book[0]);
            
            $manager->persist($card);
        }
        $manager->flush();
    }
    
    private function loadHearthstoneCardBooks(ObjectManager $manager)
    {
        foreach ($this->getBooksData() as [$name, $cards]) {
            $book = new HearthstoneCardbook();
            $book->setName($name);

            foreach($cards as $card){
                $book->addCard($card); 
            }
            
            
            $manager->persist($book);
        }
        $manager->flush();
    }
    
    private function getBooksData()
    {
        yield ['My wonderful collection', []];
        yield ['My other collection', []];
    }
    
    private function getHthcardsData()
    {
        yield ['Murloc', 'This is an incredible description', 2, true, "My wonderful collection"] ;
        yield ['Reno', 'A true explorer', 7, true, "My wonderful collection"];
        yield ['Lord Jaraxxux', 'A real demon', 8,  true, "My wonderful collection"];
        
    }
    
}
