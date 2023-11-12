<?php

namespace App\DataFixtures;

use App\Entity\Hthcard;
use App\Entity\Deck;
use App\Entity\User;
use App\Entity\HearthstoneCardbook;
use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Exception;

class AppFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadMembers($manager);
        $this->loadHearthstoneCardBooks($manager);
        $this->loadDecks($manager);
        $this->loadHthcards($manager);
        
        $manager->flush();
    }

    private function loadMembers(ObjectManager $manager): void
    {
        foreach ($this->getMembers() as [$name,$desc,$username]) {

            $member = new Member();
            if ($username) {
                $user = $manager->getRepository(User::class)->findOneByUsername($username);
                $member->setUser($user);
            }
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

    private function loadDecks(ObjectManager $manager): void
    {
        foreach ($this->getDecksData() as [$desc, $member, $public]) {
            $deck = new Deck();
            $deck->setDescription($desc);
            $deck->setPublic($public);
            $deck->setMember($this->getReference($member));
            
            $this->addReference($desc,$deck);


            $manager->persist($deck);
        }
        $manager->flush();
    }
    
    private function loadHthcards(ObjectManager $manager): void
    {
        foreach ($this->getHthcardsData() as [$name, $description, $manacost, $isminion, $bookName, $decks]) {
            $card = new Hthcard();
            $card->setName($name);
            $card->setDescription($description);
            $card->setManacost($manacost);
            $card->setIsminion($isminion);

            foreach($decks as $deck) {
                $card->addDeck($this->getReference($deck)); // Using REFERENCES for DECKS
            }

            $book = $manager->getRepository(HearthstoneCardbook::class)->findOneByName($bookName); // NOT USING REFERENCES

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
        yield ['Malfurion', 'He attacc, he protecc but most importantly, he drips' , 'malfurion'] ;
        yield ['Anduin', 'An interesting priest' , 'anduin'];
        yield ['The lich king', 'He really think himself as a king fruit. Don\'t spoil the party', 'the_lich'];
        yield ['Alice', 'She has a lot of inspiration. She needs an php elephant', 'alice'];
        yield ['Adrien', 'He is the kindest person I know and he has a nice car where we can blast music. Great guy.', 'adrikat'];
        
    }
    
    private function getBooksData()
    {
        yield ['My wonderful collection', "Malfurion"];
        yield ['My other collection', "Anduin"];
        yield ['How to battle correctly', "Adrien"];
    }
    
    private function getDecksData()
    {
        yield ['Cool deck battle', "Malfurion", false];
        yield ['Cooler deck battle', "Anduin", false];
        yield ['Defensive deck', "Adrien", false];
    }
    
    private function getHthcardsData()
    {
        yield ['Murloc', 'This is an incredible description', 2, true, "My wonderful collection", []] ;
        yield ['Reno', 'A true explorer', 7, true, "My wonderful collection", []];
        yield ['Lord Jaraxxux', 'A real demon', 8,  true, "My wonderful collection", ["Cool deck battle"]];
        yield ['Bloodfen Raptor', 'A cool dinausor', 8,  true, "My other collection", ["Cooler deck battle"]];
        yield ['Ironfuz Grizzly', 'A terrifying bear', 8,  true, "How to battle correctly", ["Defensive deck"]];
        
    }
    
}
