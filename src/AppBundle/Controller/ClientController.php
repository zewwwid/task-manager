<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Client;

class ClientController extends Controller {

    /**
     * Возвращает список клиентов с постраничной навигацией.
     * 
     * @Rest\View(serializerGroups={"list"})
     * 
     * @ApiDoc(
     *  resource=false,
     *  description="Возвращает список клиентов с постраничной навигацией."
     * )
     * 
     * @param int $page Номер страницы.
     * @param int $count Количество клиентов на одной странице.
     * @return View|array
     */
    public function listAction($page, $count) {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT c FROM AppBundle:Client c')
                ->setMaxResults($count)
                ->setFirstResult(($page - 1) * $count);
        $clients = $query->getArrayResult();

        return array('clients' => $clients);

        // doctrine2 не загружает по умолчанию сущности из свзей, без обращения к ним.
        // Т.к. заданная группа полей для сериализатора (list) не включает в себя свзи, то выполнится всего один запрос
        // SELECT 
        //     t0.`id` AS id_1, 
        //     t0.`fullname` AS fullname_2, 
        //     t0.`email` AS email_3, 
        //     t0.`phone` AS phone_4, 
        //     t0.`status` AS status_5 
        // FROM 
        //     clients t0
        // LIMIT 
        //   ? OFFSET ?
    }

    /**
     * Возвращает карточку клиента со списком прикрепленных к клиенту документов.
     * 
     * @Rest\View(serializerGroups={"card"})
     * 
     * @ApiDoc(
     *  resource=false,
     *  description="Возвращает карточку клиента со списком прикрепленных к клиенту документов."
     * )
     * @param int $id Идентификатор клиента.
     * @return View|array
     */
    public function cardAction($id) {
        
        $client = $this->getDoctrine()->getRepository('AppBundle:Client')->find($id);
        
        if (!$client instanceof Client) {
            throw new NotFoundHttpException('Client not found');
        }

        return array('client' => $client);
    }

}
