<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Document;

class LoadDocumentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $newDocument1 = new Document();
        $newDocument1->setFilename("Счет.doc");
        $newDocument1->setAdministrator($this->getReference('Administrator1'));
        $newDocument1->setTask($this->getReference('Task1'));
        $manager->persist($newDocument1);
        
        $newDocument2 = new Document();
        $newDocument2->setFilename("Акт.doc");
        $newDocument2->setAdministrator($this->getReference('Administrator2'));
        $newDocument2->setClient($this->getReference('Client1'));
        $manager->persist($newDocument2);
        
        $newDocument3 = new Document();
        $newDocument3->setFilename("Коммерческое предложение.pdf");
        $newDocument3->setAdministrator($this->getReference('Administrator3'));
        $newDocument3->setClient($this->getReference('Client1'));
        $manager->persist($newDocument3);
        
        $newDocument4 = new Document();
        $newDocument4->setFilename("Документ 4.doc");
        $newDocument4->setAdministrator($this->getReference('Administrator2'));
        $newDocument4->setTask($this->getReference('Task1'));
        $manager->persist($newDocument4);
        
        $newDocument5 = new Document();
        $newDocument5->setFilename("Документ 5.doc");
        $newDocument5->setAdministrator($this->getReference('Administrator3'));
        $newDocument5->setTask($this->getReference('Task4'));
        $manager->persist($newDocument5);
        
        $newDocument6 = new Document();
        $newDocument6->setFilename("Документ 6.doc");
        $newDocument6->setAdministrator($this->getReference('Administrator1'));
        $newDocument6->setClient($this->getReference('Client3'));
        $manager->persist($newDocument6);
        
        $newDocument7 = new Document();
        $newDocument7->setFilename("Документ 7.doc");
        $newDocument7->setAdministrator($this->getReference('Administrator1'));
        $newDocument7->setClient($this->getReference('Client5'));
        $manager->persist($newDocument7);      
                
        $manager->flush();
        
        $this->addReference('Document1', $newDocument1);
        $this->addReference('Document2', $newDocument2);
        $this->addReference('Document3', $newDocument3);
        $this->addReference('Document4', $newDocument4);
        $this->addReference('Document5', $newDocument5);
        $this->addReference('Document6', $newDocument6);
        $this->addReference('Document7', $newDocument7);        
    }
    
    public function getOrder()
    {
        return 4;
    }
}