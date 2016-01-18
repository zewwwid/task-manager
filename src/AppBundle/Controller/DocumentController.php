<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Form\DocumentToClientType;
use AppBundle\Entity\Document;

class DocumentController extends Controller {

    /**
     * Обрабатывает форму загрузки нового документа к карточке клиента.
     * 
     * @param Document $document Экземпляр документа.
     * @return Response|FormInterface
     */
    private function processForm(Document $document) {

        $form = $this->createForm(new DocumentToClientType(), $document);
        $form->submit($this->getRequest(), is_null($document->getId()));

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Методы загрузки файла вызываются через Lifecycle Callbacks после
            // сохранения документа в базе
            
            $em->persist($document);
            $em->flush($document);

            // В соответствии со спецификацией HTTP возвращаем URI 
            // созданного/измененного ресурса используя заголовок Location.
            $response = new Response();
            $response->setStatusCode(Codes::HTTP_CREATED);
            $response->headers->set('Location',
                    $this->generateUrl(
                            'app_document_get',
                            array('id' => $document->getId()), true
                    )
            );

            return $response;
        }

        return $form;
    }

    /**
     * Добавляет новый документ к карточке клиента.
     *  
     * @ApiDoc(
     *  resource = "Documents",
     *  description = "Добавляет новый документ к карточке клиента.",
     *  input = "AppBundle\Form\DocumentToClientType",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  parameters={
     *      { 
     *          "name" = "document[client]", "dataType" = "integer", "required" = true, 
     *          "description" = "Идентификатор клиента, к карточке которого добавляется новый документ" 
     *      },
     *      { 
     *          "name" = "document[administrator]", "dataType" = "integer", "required" = true, 
     *          "description" = "Идентификатор администратора загружающего файл" 
     *      },
     *      { "name" = "document[file]", "dataType" = "file", "required" = false, "description" = "Файл" },
     *      { "name" = "document", "dataType" = "object", "readonly" = true }
     *  },
     *  statusCodes = {
     *      201 = "Created",
     *      400 = "Bad Request"
     *  }
     * )
     * 
     * @return Response|FormInterface
     */
    public function addToClientAction() {
        return $this->processForm(new Document());
    }
    
    /**
     * Открепляет документ от карточки клиента.
     *  
     * @ApiDoc(
     *  resource = "Documents",
     *  description = "Открепляет документ от карточки клиента.",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  statusCodes = {
     *      204 = "No Content",
     *      404 = "Document not found"
     *  }
     * )
     * 
     * @param integer $id Идентификатор открепляемого документа
     * @return Response|FormInterface
     */
    public function detachFromClientAction($id) {
        $document = $this->getDoctrine()
                        ->getRepository('AppBundle:Document')->find($id);

        if (!$document instanceof Document) {
            throw new NotFoundHttpException('Document not found');
        }

        $document->setClient(null);

        $em = $this->getDoctrine()->getManager();
        $em->persist($document);
        $em->flush($document);

        $response = new Response();
        $response->setStatusCode(Codes::HTTP_NO_CONTENT);
        $response->headers->set('Location',
                $this->generateUrl(
                        'app_document_get', array('id' => $document->getId()),
                        true
                )
        );

        return $response;
    }
    
    /**
     * Взвращает документ.
     * 
     * @ApiDoc(
     *  resource = "Documents",
     *  description = "Взвращает документ.",
     *  requirements={
     *      {
     *          "name" = "_format", "dataType" = "string", "requirement" = "json|xml",
     *          "description" = "Формат ответа (json|xml)", "default" = "json"
     *      }
     *  },
     *  tags={
     *      "NotImplemented"
     *  }
     * )
     * 
     * @param integer $id Идентификатор документа.
     * @throws NotImplementedException 
     */
    public function getAction($id) {
        throw new NotImplementedException("Не реализовано");
    }

}
