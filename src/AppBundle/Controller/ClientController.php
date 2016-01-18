<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Representation\ClientsRepresentation;
use AppBundle\Form\ClientType;
use AppBundle\Entity\Client;

class ClientController extends Controller {

    /**
     * Обрабатывает форму создания/изменения карточки клиента.
     * 
     * @param Client $client Экземпляр клиента.
     * @return Response|FormInterface
     */
    private function processForm(Client $client) {
        // Определяем статус-код успешного завершения в зависимости от того 
        // создается ли новый клиент или изменяется существующий.
        $statusCode = is_null($client->getId()) ?
                Codes::HTTP_CREATED : Codes::HTTP_NO_CONTENT;

        $form = $this->createForm(new ClientType(), $client);       
        $form->submit($this->getRequest(), is_null($client->getId()));
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush($client);

            // В соответствии со спецификацией HTTP возвращаем URI 
            // созданного/измененного ресурса используя заголовок Location.
            $response = new Response();
            $response->setStatusCode($statusCode);            
            $response->headers->set('Location',
                    $this->generateUrl(
                            'app_client_get', array('id' => $client->getId()),
                            true
                    )
            );

            return $response;
        }

        return $form;
    }

    /**
     * Добавляет нового клиента.
     *  
     * @ApiDoc(
     *  resource = "Clients",
     *  description = "Добавляет нового клиента.",
     *  input = "AppBundle\Form\ClientType",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  parameters={
     *      { "name" = "client[fullname]", "dataType" = "string", "required" = true, "description" = "ФИО" },
     *      { "name" = "client[email]", "dataType" = "string", "required" = true, "description" = "Email" },
     *      { "name" = "client[phone]", "dataType" = "string", "required" = false, "description" = "Телефон" },
     *      { "name" = "client[status]", "dataType" = "enum", "required" = true, 
     *          "format" = "{1 : Действующий, 2 : Потенциальный, 3 : Прошлый}",
     *          "description" = "Статус (1|2|3)"
     *      },
     *      { "name" = "client", "dataType" = "object", "readonly" = true }
     *  },
     *  statusCodes = {
     *      201 = "Created",
     *      400 = "Bad Request"
     *  }
     * )
     * @return Response|FormInterface
     */
    public function addAction() {
        return $this->processForm(new Client());
    }
    
    /**
     * Изменяет данные в карточке клиента.
     *  
     * @ApiDoc(
     *  resource = "Clients",
     *  description = "Изменяет данные в карточке клиента.",
     *  input = "AppBundle\Form\ClientType",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  parameters={
     *      { "name" = "client[fullname]", "dataType" = "string", "required" = false, "description" = "ФИО" },
     *      { "name" = "client[email]", "dataType" = "string", "required" = false, "description" = "Email" },
     *      { "name" = "client[phone]", "dataType" = "string", "required" = false, "description" = "Телефон" },
     *      { "name" = "client[status]", "dataType" = "integer", "required" = false, 
     *          "format" = "{1 : Действующий, 2 : Потенциальный, 3 : Прошлый}",
     *          "description" = "Статус (1|2|3)"
     *      },
     *      { "name" = "client", "dataType" = "object", "readonly" = true }
     *  },
     *  statusCodes = {
     *      204 = "No Content",
     *      400 = "Bad Request"
     *  }
     * )
     * 
     * @param int $id Идентификатор клиента
     * @return Response|FormInterface
     */
    public function editAction($id) {
        $client = $this->getDoctrine()
                        ->getRepository('AppBundle:Client')->find($id);

        if (!$client instanceof Client) {
            throw new NotFoundHttpException('Client not found');
        }

        return $this->processForm($client);
    }
    
    /**
     * Возвращает карточку клиента со списком прикрепленных к клиенту документов.
     * 
     * @Rest\View(serializerGroups={"card"})
     * 
     * @ApiDoc(
     *  resource = "Clients",
     *  description="Возвращает карточку клиента со списком прикрепленных к клиенту документов.",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  statusCodes = {
     *      200 = "OK",
     *      404 = "Client not found"
     *  }
     * )
     * @param int $id Идентификатор клиента
     * @return Client
     */
    public function getAction($id) {
        $client = $this->getDoctrine()
                        ->getRepository('AppBundle:Client')->find($id);

        if (!$client instanceof Client) {
            throw new NotFoundHttpException('Client not found');
        }

        return $client;
    }
            
    /**
     * Возвращает список клиентов с постраничной навигацией.
     * 
     * @Rest\View(serializerGroups={"list"})
     * 
     * @ApiDoc(
     *  resource = "Clients",
     *  description="Возвращает список клиентов с постраничной навигацией.",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  statusCodes = {
     *      200 = "OK",
     *      400 = "Parameters ""page"" and ""count""  must be greater than zero"
     *  }
     * )
     * 
     * @param int $page Номер страницы
     * @param int $count Количество клиентов на одной странице
     * @return array|ClientsRepresentation
     */
    public function listAction($page, $count, $_format) {
        if ($page <= 0 || $count <= 0) {
            throw new HttpException(Codes::HTTP_BAD_REQUEST,
            'Parameters "page" and "count"  must be greater than zero');
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM AppBundle:Client c')
                ->setMaxResults($count)
                ->setFirstResult(($page - 1) * $count);
        $clients = $query->getResult();

        // Обернем коллекцию клиентов для правильной сериализации.
        return $_format === 'xml' ? new ClientsRepresentation($clients) : $clients;
    }

}
