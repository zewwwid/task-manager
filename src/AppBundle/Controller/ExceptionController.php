<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\Debug\Exception\FlattenException;
use FOS\RestBundle\View\View;
use AppBundle\Representation\ExceptionRepresentation;

/**
 * Контроллер исключений.
 */
class ExceptionController extends Controller {

    /**
     * Сериализует исключение и возвращает исключение.
     * 
     * @param Request $request Запрос
     * @param FlattenException $exception Исключение
     * @param DebugLoggerInterface $logger Лог
     * @param string $format Формат сериализации
     * @return Response
     */
    public function showExceptionAction(Request $request,
            FlattenException $exception, DebugLoggerInterface $logger = null,
            $format = 'json') {

        /** @var \FOS\RestBundle\View\ViewHandler $viewHandler */
        $viewHandler = $this->get('fos_rest.view_handler');

        // Если формат сериализации не поддерживается, то выбирается json
        if ($viewHandler->isFormatTemplating($format)) {
            $format = 'json';
        }

        $view = View::create()
                ->setStatusCode($exception->getStatusCode())
                ->setData(new ExceptionRepresentation($exception->getStatusCode(),
                        $exception->getMessage(), null))
                ->setFormat($format);

        return $viewHandler->handle($view);
    }

}
