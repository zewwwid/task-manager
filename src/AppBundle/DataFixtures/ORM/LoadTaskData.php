<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $newTask1 = new Task();
        $newTask1->setName("Написать клиенту");
        $newTask1->setText("Написать клиенту");
        $newTask1->setStatus("Новая");
        $newTask1->setResponsible($this->getReference('Administrator1'));
        $manager->persist($newTask1);
        
        $newTask2 = new Task();
        $newTask2->setName("Выставить счет");
        $newTask2->setText("Выставить счет");
        $newTask2->setStatus("В работе");
        $newTask2->setResponsible($this->getReference('Administrator2'));
        $manager->persist($newTask2);
        
        $newTask3 = new Task();
        $newTask3->setName("Составить список задач на неделю");
        $newTask3->setText("Составить список задач на неделю");
        $newTask3->setStatus("Закрыта");
        $newTask3->setResponsible($this->getReference('Administrator1'));
        $manager->persist($newTask3);
        
        $newTask4 = new Task();
        $newTask4->setName("Задача 4");
        $newTask4->setText("Задача 4");
        $newTask4->setStatus("Новая");
        $newTask4->setResponsible($this->getReference('Administrator3'));
        $manager->persist($newTask4);
        
        $newTask5 = new Task();
        $newTask5->setName("Задача 5");
        $newTask5->setText("Задача 5");
        $newTask5->setStatus("Закрыта");
        $newTask5->setResponsible($this->getReference('Administrator1'));
        $manager->persist($newTask5);
        
        $newTask6 = new Task();
        $newTask6->setName("Задача 6");
        $newTask6->setText("Задача 6");
        $newTask6->setStatus("Новая");
        $newTask6->setResponsible($this->getReference('Administrator1'));
        $manager->persist($newTask6);
        
        $newTask7 = new Task();
        $newTask7->setName("Задача 7");
        $newTask7->setText("Задача 7");
        $newTask7->setStatus("Новая");
        $newTask7->setResponsible($this->getReference('Administrator3'));
        $manager->persist($newTask7);
        
        $newTask8 = new Task();
        $newTask8->setName("Задача 8");
        $newTask8->setText("Задача 8");
        $newTask8->setStatus("В работе");
        $newTask8->setResponsible($this->getReference('Administrator2'));
        $manager->persist($newTask8);
        
        $newTask9 = new Task();
        $newTask9->setName("Задача 9");
        $newTask9->setText("Задача 9");
        $newTask9->setStatus("Закрыта");
        $newTask9->setResponsible($this->getReference('Administrator2'));
        $manager->persist($newTask9);
        
        $newTask10 = new Task();
        $newTask10->setName("Задача 10");
        $newTask10->setText("Задача 10");
        $newTask10->setStatus("Новая");
        $newTask10->setResponsible($this->getReference('Administrator1'));
        $manager->persist($newTask10);       
                        
        $manager->flush();
        
        $this->addReference('Task1', $newTask1);
        $this->addReference('Task2', $newTask2);
        $this->addReference('Task3', $newTask3);
        $this->addReference('Task4', $newTask4);
        $this->addReference('Task5', $newTask5);
        $this->addReference('Task6', $newTask6);
        $this->addReference('Task7', $newTask7);
        $this->addReference('Task8', $newTask8);
        $this->addReference('Task9', $newTask9);
        $this->addReference('Task10', $newTask10);       
    }
    
    public function getOrder()
    {
        return 3;
    }
}