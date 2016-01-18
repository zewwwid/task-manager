<?php

namespace AppBundle\Handler;

use FOS\RestBundle\View\ExceptionWrapperHandlerInterface;
use AppBundle\Representation\ExceptionRepresentation;

/**
 * Обертка для сериализации исключения.
 */
class ExceptionWrapperHandler implements ExceptionWrapperHandlerInterface {

    public function wrap($data) {

        return new ExceptionRepresentation($data["status_code"],
                $data["message"], $data["errors"]);
    }

}
