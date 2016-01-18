<?php

namespace AppBundle\Representation;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Представление для сериализации коллекции клиентов.
 * 
 * @Serializer\XmlRoot("clients")
 */
class ClientsRepresentation {

    /**
     * Коллекция клиентов
     * @var ArrayCollection
     * 
     * @Serializer\Groups({"list"})
     * @Serializer\XmlList(inline = true, entry = "client")
     */
    private $clients;

    public function __construct($clients) {
        $this->clients = $clients;
    }

}
