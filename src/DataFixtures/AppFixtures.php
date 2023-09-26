<?php

namespace App\DataFixtures;

use App\Entity\Hthcard;
use App\Entity\HearthstoneCardbook;
use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadMembers($manager);
        $this->loadHearthstoneCardBooks($manager);
        $this->loadHthcards($manager);
        
        $manager->flush();
    }

    private function loadMembers(ObjectManager $manager): void
    {
        foreach ($this->getMembers() as [$name,$desc]) {
            $member = new Member();
            $member->setNom($name);
            $member->setDescription($desc);
            
            $this->addReference($name,$member);

            $manager->persist($member);
        }
        $manager->flush();
    }

    private function loadHearthstoneCardBooks(ObjectManager $manager): void
    {
        foreach ($this->getBooksData() as [$name, $member]) {
            $book = new HearthstoneCardbook();
            $book->setName($name);
            $book->setMember($this->getReference($member));
            
            $manager->persist($book);
        }
        $manager->flush();
    }
    
    private function loadHthcards(ObjectManager $manager): void
    {
        foreach ($this->getHthcardsData() as [$name, $description, $manacost, $isminion, $bookName]) {
            $card = new Hthcard();
            $card->setName($name);
            $card->setDescription($description);
            $card->setManacost($manacost);
            $card->setIsminion($isminion);

            $book = $manager->getRepository(HearthstoneCardbook::class)->findOneByName($bookName);

            if($book == null){
                throw new Exception("Lors de la création des cartes, le livre du nom ". $bookName ." n'a pas été trouvé !");
            }

            $card->setHearthstoneCardbook($book);
            
            $manager->persist($card);
        }
        $manager->flush();
    }
    
    
    private function getMembers()
    {
        yield ['Malfurion', 'He attacc, he protecc but most importantly, he drips'] ;
        yield ['Anduin', 'An interesting priest'];
        yield ['The lich king', 'He really think himself as a king fruit. Don\'t spoil the party'];
        yield ['Alice', 'She has a lot of inspiration. She needs an php elephant'];
        yield ['Adrien', 'He is the kindest person I know and he has a nice car where we can blast music. Great guy.'];
        
    }
    
    private function getBooksData()
    {
        yield ['My wonderful collection', "Malfurion"];
        yield ['My other collection', "Anduin"];
    }
    
    private function getHthcardsData()
    {
        yield ['Murloc', 'This is an incredible description', 2, true, "My wonderful collection"] ;
        yield ['Reno', 'A true explorer', 7, true, "My wonderful collection"];
        yield ['Lord Jaraxxux', 'A real demon', 8,  true, "My wonderful collection"];
        
    }
    
}
