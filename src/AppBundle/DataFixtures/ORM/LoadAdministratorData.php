<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Administrator;

class LoadAdministratorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $newAdministrator1 = new Administrator();
        $newAdministrator1->setFullname("Администратор 1");
        $manager->persist($newAdministrator1);
        
        $newAdministrator2 = new Administrator();
        $newAdministrator2->setFullname("Администратор 2");
        $manager->persist($newAdministrator2);
        
        $newAdministrator3 = new Administrator();
        $newAdministrator3->setFullname("Администратор 3");
        $manager->persist($newAdministrator3);
        
        $manager->flush();
        
        $this->addReference('Administrator1', $newAdministrator1);
        $this->addReference('Administrator2', $newAdministrator2);
        $this->addReference('Administrator3', $newAdministrator3);
    }
    
    public function getOrder()
    {
        return 1;
    }
}