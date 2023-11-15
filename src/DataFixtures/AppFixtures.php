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

        // test
    }

    private function loadMembers(ObjectManager $manager): void
    {
        foreach ($this->getMembers() as [$name, $desc, $username]) {

            $member = new Member();

            if ($username) {
                $user = $manager->getRepository(User::class)->findOneBy(['username' => $username]);
                $member->setUser($user);
                // if($user !== null){
                //     $user->setMember($member);
                // }
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
        foreach ($this->getDecksData() as [$name, $member, $public]) {
            $deck = new Deck();
            $deck->setName($name);
            $deck->setPublic($public);
            $deck->setMember($this->getReference($member));
            
            $this->addReference($name,$deck);


            $manager->persist($deck);
        }
        $manager->flush();
    }
    
    private function loadHthcards(ObjectManager $manager): void
    {
        foreach ($this->getHthcardsData() as [$name, $description, $manacost, $isminion, $bookName, $decks, $atk, $hp]) {
            $card = new Hthcard();
            $card->setName($name);
            $card->setDescription($description);
            $card->setManacost($manacost);
            $card->setIsminion($isminion);

            if($isminion){
                $card->setAtk($atk);
                $card->setHp($hp);
            }

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
        yield ['The Lich King', "He really think himself as a king fruit. Don't spoil the party", 'the_lich'];
        yield ['Alice', 'She has a lot of inspiration. She needs an php elephant', 'alice'];
        yield ['Shyguy', 'A pretty shy guy. He might not have enough courage to upload anything...', 'shyguy'];
        yield ['Adrien', 'He is the kindest person I know and he has a nice car where we can blast music. Great guy.', 'adrikat'];
        
    }
    
    private function getBooksData()
    {
        yield ["The nature's defenders", "Malfurion"];
        yield ['My deadly army', "The Lich King"];
        yield ['The Holy Cards', "Anduin"];
        yield ['My card inventory', "Alice"];
        yield ['Me.', "Adrien"];
    }
    
    private function getDecksData()
    {
        yield ['Cool deck battle', "Malfurion", true];
        yield ['Cooler deck battle', "Malfurion", false];
        yield ['Insanity', "Malfurion", true];

        yield ['Holy holy deck', "Anduin", true];
        yield ['Royalty deck', "Anduin", false];
        yield ['Priest deck', "Anduin", true];

        yield ['Knighty deck', "The Lich King", true];
        yield ["Death's cold breath", "The Lich King", false];
        yield ['Literally cheating', "The Lich King", true];
        
        yield ["Da' PHP crew", "Alice", true];
        yield ['Elephants!!!!!', "Alice", false];
        yield ['Battle ? Nah Elephants', "Alice", true];

        yield ['Defensive deck', "Adrien", true];
        yield ['Balanced deck', "Adrien", false];
        yield ['What', "Adrien", true];
    }
    
    private function getHthcardsData()
    {
        yield ['Murloc', 'A little creature that will fight to achieve what it wants.', 3, true, "The nature's defenders", ['Cool deck battle','Cooler deck battle'], 2,2] ;
        yield ['Bloodfen Raptor', 'A cool dinausor that will chase anything moving.', 8,  true, "The nature's defenders", ['Cooler deck battle','Insanity'] , 3, 4];
        yield ['Dancing Potions', 'Heals 3 HP to all minions your side of the battlefield.', 8,  true, "The nature's defenders", ['Cool deck battle','Insanity'] , null, null];


        yield ['The Church', "A magestic monument. Very sturdy, it won't croissant.", 4,  true, "The Holy Cards", ['Holy holy deck','Royalty deck'] , 0, 8];
        yield ['Believer', 'He has a strong faith. Heals 1 HP every end of turn.', 3,  true, "The Holy Cards", ['Priest deck','Holy holy deck'] , 1, 4];
        yield ['Quick prayer', 'Pray to gain strength. Gives +2/+2 to one minion.', 8,  false, "The Holy Cards", ['Priest deck','Royalty deck'] , null, null];
        

        yield ['Lord Jaraxxux', 'A real demon. Beware of his trickeries.', 8,  true, "My deadly army", ["Knighty deck","Death's cold breath"] , 8, 8];
        yield ['The Four Knights', 'Four knights raised from the dead.', 5,  true, "My deadly army", ["Literally cheating","Death's cold breath"] , 4, 4];
        yield ["Death's touch", 'Makes your opponent discard 3 random cards from their hands. Pretty much cheating.', 8,  false, "My deadly army", ["Knighty deck",'Literally cheating'] , null, null];
        

        yield ['Phplephant', "An elephant that learns php. It's very cute !", 5,  true, "My card inventory", ["Da' PHP crew","Elephants!!!!!"] , 3, 6];
        yield ['Mousey', 'The mouse called Mousey leaning on the top of the elephant. So heartwarming !', 5,  true, "My card inventory", ["Battle ? Nah Elephants","Da' PHP crew"] , 1, 1];
        yield ['Normal elephant', 'An elephant. Nice.', 4,  true, "My card inventory", ["Battle ? Nah Elephants","Elephants!!!!!"] , 3, 4];
        
        
        yield ['Ironfuz Grizzly', "A terrifying bear. Don't steal his honey. Ever.", 4,  true, "Me.", ["Defensive deck",'What'] , 2, 4];
        yield ['Reno The Explorer', 'A true explorer. Ready to go on unknown adventures !', 7, true, "Me.", ["Defensive deck", "Balanced deck"], 5, 6];
        yield ['Defile', 'Deals one damage to all minions. If any dies, cast this again.', 5,  false, "Me.", ["Balanced deck",'What'] , null, null];
    }
}
