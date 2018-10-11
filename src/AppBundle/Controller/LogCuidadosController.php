<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 10/03/18
 * Time: 8:12 AM
 */

namespace AppBundle\Controller;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\LogCuidados;

class LogCuidadosController extends Controller {
    protected function authorization(Request $request)
    {
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);
        $token = $request->get('authorization', null);
        $authCheck = $jwt_auth->checkToken($token);
        return array($helpers, $jwt_auth, $token, $authCheck);
    }

    // Se pasa como parametro id, el id de userbonsai
    public function logCuidadosAction(Request $request, $id = null)
    {
        list($helpers, $jwt_auth, $token, $authCheck) = $this->authorization($request);

        if (!$authCheck) {
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Autorizacion no valida"
            );
            return $helpers->json($data);
        }

        $identity = $jwt_auth->checkToken($token, true);
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT t 
                FROM BackendBundle:LogCuidados t
                JOIN BackendBundle:UserBonsai u
                WITH u.iduserbonsai = t.iduserbonsai
                WHERE u.iduser = {$identity->sub} AND t.iduserbonsai = {$id}
                ORDER BY t.createdat DESC";
        $query = $em->createQuery($dql);
        $page = $request->query->getInt('page', 1);
        $paginator = $this->get('knp_paginator');
        $itemsPerPage = 10;
        $pagination = $paginator->paginate($query, $page, $itemsPerPage);
        $totalItemsCount = $pagination->getTotalItemCount();

        $data = array(
            "status" => "success",
            "code" => 200,
            "totalItemsCount" => $totalItemsCount,
            "pageActual" => $page,
            "itemsPerPage" => $itemsPerPage,
            "totalPages" => ceil($totalItemsCount / $itemsPerPage),
            "data" => $pagination
        );
        return $helpers->json($data);
    }

    // Se pasa como parametro id, el id de userbonsai
    public function newAction(Request $request, $id = null)
    {
        list($helpers, $jwt_auth, $token, $authCheck) = $this->authorization($request);

        if (!$authCheck) {
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Autorizacion no valida"
            );
            return $helpers->json($data);
        }

        $identity = $jwt_auth->checkToken($token, true);
        $json = $request->get('json', null);
        $params = json_decode($json);

        if ($json == null) {
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Cuidado no creado, no hay datos"
            );
            return $helpers->json($data);
        }

        $idUser = ($identity->sub != null)?$identity->sub:null;
        $cuidado = (isset($params->cuidado))?$params->cuidado:null;
        $createsAt = (isset($params->createdAt))?$params->createdAt:null;

        if ($idUser == null) {
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Id usuario vacio"
            );
            return $helpers->json($data);
        }

        $em = $this->getDoctrine()->getManager();
        $userBonsai = $em->getRepository('BackendBundle:UserBonsai')->findOneBy(array(
            'iduserbonsai' => $id
        ));

        if (!$identity->sub || $identity->sub != $userBonsai->getIduser()->getIdUser()) {
            $data = array(
                "status" => "success",
                "code" => 400,
                "data" => "No pertenece a su Id de usuario"
            );
            return $helpers->json($data);
        }

        $logCuidados = new LogCuidados();
        $logCuidados->setIduserbonsai($userBonsai);
        $logCuidados->setCuidado($cuidado);
        $logCuidados->setCreatedat(new \DateTime($createsAt));

        $em->persist($logCuidados);
        $em->flush();

        $data = array(
            "status" => "success",
            "code" => 200,
            "data" => $logCuidados
        );
        return $helpers->json($data);
    }

    // Se pasa como parametro id, el id del logCuidados
    public function removeAction(Request $request, $id = null)
    {
        list($helpers, $jwt_auth, $token, $authCheck) = $this->authorization($request);

        if (!$authCheck) {
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Autorizacion no valida"
            );
            return $helpers->json($data);
        }

        $identity = $jwt_auth->checkToken($token, true);
        $em = $this->getDoctrine()->getManager();
        $userBonsai = $em->getRepository('BackendBundle:LogCuidados')->findOneBy(array(
            'idlogcuidados' => $id
        ));

        if (!$userBonsai || $identity->sub != $userBonsai->getIduserbonsai()->getIduser()->getIduser()) {
            $data = array(
                "status" => "error",
                "code" => 404,
                "msg" => "Cuidado no encontrado"
            );
            return $helpers->json($data);
        }

        //Borrar objeto y registro de la tabla
        $em->remove($userBonsai);
        $em->flush();

        $data = array(
            "status" => "success",
            "code" => 200,
            "data" => $userBonsai
        );
        return $helpers->json($data);
    }
}