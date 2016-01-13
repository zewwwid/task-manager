<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Client;

class LoadClentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $newClient1 = new Client();
        $newClient1->setFullname("Иванов Иван");
        $newClient1->setEmail("ivanov@email.com");
        $newClient1->setPhone("+7 (912) 12-34-567");
        $newClient1->setStatus("Действующий");
        $manager->persist($newClient1);
        
        $newClient2 = new Client();
        $newClient2->setFullname("Клиент 2");
        $newClient2->setEmail("client2@email.com");
        $newClient2->setStatus("Действующий");
        $manager->persist($newClient2);
        
        $newClient3 = new Client();
        $newClient3->setFullname("Клиент 3");
        $newClient3->setEmail("client3@email.com");
        $newClient3->setStatus("Потенциальный");
        $manager->persist($newClient3);
        
        $newClient4 = new Client();
        $newClient4->setFullname("Клиент 4");
        $newClient4->setEmail("client4@email.com");
        $newClient4->setPhone("+7 (912) 76-54-321");
        $newClient4->setStatus("Прошлый");
        $manager->persist($newClient4);
        
        $newClient5 = new Client();
        $newClient5->setFullname("Петр Петров");
        $newClient5->setEmail("petrov@email.com");
        $newClient5->setPhone("+7 (912) 00-00-000");
        $newClient5->setStatus("Потенциальный");
        $manager->persist($newClient5);
        
        $manager->flush();
        
        $this->addReference('Client1', $newClient1);
        $this->addReference('Client2', $newClient2);
        $this->addReference('Client3', $newClient3);
        $this->addReference('Client4', $newClient4);
        $this->addReference('Client5', $newClient5);
    }
    
    public function getOrder()
    {
        return 2;
    }
}