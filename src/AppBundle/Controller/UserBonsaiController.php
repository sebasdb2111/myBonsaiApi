<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 10/03/18
 * Time: 8:10 AM
 */

namespace AppBundle\Controller;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\UserBonsai;

class UserBonsaiController extends Controller {
    protected function authorization(Request $request)
    {
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);
        $token = $request->get('authorization', null);
        $authCheck = $jwt_auth->checkToken($token);
        return array($helpers, $jwt_auth, $token, $authCheck);
    }

    public function imgBonsai ($idBonsai) {
        if ($idBonsai == 1)
            $img = 'https://planetahuerto-6f4f.kxcdn.com/estaticos/imagenes/ficha/969/969_1_1400.jpg';
        elseif ($idBonsai == 2)
            $img = 'https://planetahuerto-6f4f.kxcdn.com/estaticos/imagenes/ficha/1163/1163_1_1400.jpg';
        elseif ($idBonsai == 3)
            $img = 'https://planetahuerto-6f4f.kxcdn.com/estaticos/imagenes/ficha/987/987_1_1400.jpg';
        elseif ($idBonsai == 4)
            $img = 'https://planetahuerto-6f4f.kxcdn.com/estaticos/imagenes/ficha/993/993_1_1400.jpg';

        return $img;
    }

    public function userBonsaiAction(Request $request, $id = null)
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
        $dql = "SELECT t FROM BackendBundle:UserBonsai t WHERE t.iduser = {$identity->sub} ORDER BY t.iduserbonsai DESC";
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
                "msg" => "Bonsai no creado, parametros erroneos"
            );
            return $helpers->json($data);
        }

        //Sacar datos del json
        $idUser = ($identity->sub != null)?$identity->sub:null;
        $idBonsai = (isset($params->idBonsai))?$params->idBonsai:null;
        $alias = (isset($params->alias))?$params->alias:null;
        $edad = (isset($params->edad))?$params->edad:null;
        $fechaAdquisicion = (isset($params->fechaAdquisicion))?$params->fechaAdquisicion:null;
        $descripcion = (isset($params->descripcion))?$params->descripcion:null;
        $imgBonsai = (isset($params->imgBonsai))?$params->imgBonsai:null;

        if ($idUser == null){
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "Bonsai no creado, validacion fallida"
            );
            return $helpers->json($data);
        }

        //Crear registro
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BackendBundle:User')->findOneBy(array(
            'iduser' => $idUser
        ));
        $bonsai = $em->getRepository('BackendBundle:Bonsai')->findOneBy(array(
            'idbonsai' => $idBonsai
        ));

        // Si tiene Id crea un registro nuevo, sino modifica el existente
        if ($id == null) {
            $userBonsai = new UserBonsai();
            $userBonsai->setIduser($user);
            $userBonsai->setIdbonsai($bonsai);
            $userBonsai->setAlias($alias);
            $userBonsai->setEdad($edad);
            $userBonsai->setFechaadquisicion(new \DateTime($fechaAdquisicion));
            $userBonsai->setDescripcion($descripcion);
            $imagen = $this->imgBonsai($idBonsai);
            $userBonsai->setImgbonsai($imagen);

            $em->persist($userBonsai);
            $em->flush();

            $data = array(
                "status" => "success",
                "code" => 200,
                "data" => $userBonsai
            );
            return $helpers->json($data);
        }

        $em = $this->getDoctrine()->getManager();
        $userBonsai = $em->getRepository('BackendBundle:UserBonsai')->findOneBy(array(
            'iduserbonsai' => $id
        ));
        $bonsai = $em->getRepository('BackendBundle:Bonsai')->findOneBy(array(
            'idbonsai' => $idBonsai
        ));

        if (!$identity->sub || $identity->sub != $userBonsai->getIduser()->getIdUser()){
            $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "No eres el dueño del bonsai"
            );
            return $helpers->json($data);
        }

        $userBonsai->setIdbonsai($bonsai);
        $userBonsai->setAlias($alias);
        $userBonsai->setEdad($edad);
        $userBonsai->setFechaadquisicion(new \DateTime($fechaAdquisicion));
        $userBonsai->setDescripcion($descripcion);
        $imagen = $this->imgBonsai($idBonsai);
        $userBonsai->setImgbonsai($imagen);

        $em->persist($userBonsai);
        $em->flush();

        $data = array(
            "status" => "success",
            "code" => 200,
            "data" => $userBonsai
        );
        return $helpers->json($data);
    }

    public function detailAction(Request $request, $id = null)
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
        $userBonsai = $em->getRepository('BackendBundle:UserBonsai')->findOneBy(array(
            'iduserbonsai' => $id
        ));

        if (!$userBonsai || $identity->sub != $userBonsai->getIduser()->getIduser()){
            $data = array(
                "status" => "error",
                "code" => 404,
                "msg" => "Bonsai no encontrada"
            );
            return $helpers->json($data);
        }

        $data = array(
            "status" => "success",
            "code" => 200,
            "data" => $userBonsai
        );
        return $helpers->json($data);
    }

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
        $userBonsai = $em->getRepository('BackendBundle:UserBonsai')->findOneBy(array(
            'iduserbonsai' => $id
        ));

        if (!$userBonsai || $identity->sub != $userBonsai->getIduser()->getIduser()) {
            $data = array(
                "status" => "error",
                "code" => 404,
                "msg" => "Bonsai no encontrada"
            );
            return $helpers->json($data);
        }

        //Borrar objeto y registro de los logCuidados existentes
        $remCuidados = $this->getDoctrine()->getManager();
        $logCuidado = $remCuidados->getRepository('BackendBundle:LogCuidados')->findBy(array(
            'iduserbonsai' => $id
        ));
        foreach ($logCuidado as $cuidado){
            $remCuidados->remove($cuidado);
            $remCuidados->flush();
        }

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