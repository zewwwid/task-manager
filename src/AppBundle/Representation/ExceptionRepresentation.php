<?php

namespace AppBundle\Representation;

use JMS\Serializer\Annotation as Serializer;

/**
 * Представление для сериализации исключения.
 * 
 * @Serializer\XmlRoot("error")
 */
class ExceptionRepresentation {

    /**
     * Код ошибки
     * @var integer
     * 
     * @Serializer\Groups({"card", "list"})
     */
    private $code;

    /**
     * Сообщение ошибки
     * @var string
     * 
     * @Serializer\Groups({"card", "list"})
     */
    private $message;

    /**
     * Внутренние ошибки
     * @var array
     * 
     * @Serializer\Groups({"card", "list"})
     * @Serializer\XmlList(inline = false, entry = "error")
     */
    private $errors;

    public function __construct($code, $message, $errors) {
        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
    }

}
