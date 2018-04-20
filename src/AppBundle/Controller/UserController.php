<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 10/03/18
 * Time: 8:41 PM
 */

namespace AppBundle\Controller;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use BackendBundle\Entity\User;

class UserController extends Controller
{

    protected function authorization(Request $request)
    {
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);
        $token = $request->get('authorization', null);
        $authCheck = $jwt_auth->checkToken($token);
        return array($helpers, $jwt_auth, $token, $authCheck);
    }

    public function newAction(Request $request)
    {
        $helpers = $this->get(Helpers::class);
        $json = $request->get('json', null);
        $params = json_decode($json);

        $data = array(
            'status' => 'error',
            'code' => 400,
            'msg' => 'Usuario no creado'
        );

        if ($json != null) {
            $username = (isset($params->username))?$params->username:null;
            $email = (isset($params->email))?$params->email:null;
            $password = (isset($params->password))?$params->password:null;
            $nombre = (isset($params->nombre))?$params->nombre:null;
            $apellidos = (isset($params->apellidos))?$params->apellidos:null;
            $imgUser = (isset($params->imgUser))?$params->imgUser:null;
            $fechaNacimiento = (isset($params->fechaNacimiento))?$params->fechaNacimiento:null;
            $createdAt = new \DateTime('now');

            $emailConstraint = new Assert\Email();
            $emailConstraint->message = "Este email no es valido";
            $validate_email = $this->get("validator")->validate($email, $emailConstraint);

            if ($email != null && count($validate_email) == 0 && $password != null &&
                $username != null && $nombre != null && $apellidos != null && $fechaNacimiento != null)
            {
                $user = new User();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setNombre($nombre);
                $user->setApellidos($apellidos);
                $user->setFechanacimiento(new \DateTime($fechaNacimiento));
                $user->setImguser($imgUser);
                $user->setCreacion($createdAt);

                //Cifrar password
                $pwd = hash('SHA256',$password);
                $user->setPassword($pwd);

                $em = $this->getDoctrine()->getManager();
                $issetUser = $em->getRepository("BackendBundle:User")->findBy(array(
                    "email" =>$email
                ));

                if (count($issetUser) == 0){
                    $em->persist($user);
                    $em->flush();
                    $data = array(
                        'status' => 'success',
                        'code' => 200,
                        'msg' => 'Nuevo usuario creado',
                        'user' => $user
                    );
                }
                else {
                    $data = array(
                        'status' => 'error',
                        'code' => 400,
                        'msg' => 'Usuario no creado, ya existe'
                    );
                }
            }
        }
        return $helpers->json($data);
    }

    public function editAction(Request $request)
    {
        list($helpers, $jwt_auth, $token, $authCheck) = $this->authorization($request);

        if ($authCheck == true) {
            //Entity manager
            $em = $this->getDoctrine()->getManager();
            //Conseguir datos de usuario identificado con el token
            $identity = $jwt_auth->checkToken($token, true);
            //Conseguir el objeto a actualizar
            $user = $em->getRepository('BackendBundle:User')->findOneBy(array(
                "iduser" => $identity->sub
            ));
            //Recoger datos post
            $json = $request->get('json', null);
            $params = json_decode($json);
            //Array de error por defecto
            $data = array(
                'status' => 'error',
                'code' => 400,
                'msg' => 'Usuario no creado'
            );

            if ($json != null) {
                $email = (isset($params->email))?$params->email:null;
                $password = (isset($params->password))?$params->password:null;
                $nombre = (isset($params->nombre))?$params->nombre:null;
                $apellidos = (isset($params->apellidos))?$params->apellidos:null;
                $fechaNacimiento = (isset($params->fechaNacimiento))?$params->fechaNacimiento:null;
                $imgUser = (isset($params->imgUser))?$params->imgUser:null;

                $emailConstraint = new Assert\Email();
                $emailConstraint->message = "Este email no es valido";
                $validate_email = $this->get("validator")->validate($email, $emailConstraint);

                if ($user && $email != null && count($validate_email) == 0) {
                    if ($nombre != null)
                        $user->setNombre($nombre);

                    if ($apellidos != null)
                        $user->setApellidos($apellidos);

                    if ($fechaNacimiento != null)
                        $user->setFechanacimiento(new \DateTime($fechaNacimiento));

                    if ($imgUser != null)
                        $user->setImguser($imgUser);

                    if ($password != null){
                        //Cifrar password
                        $pwd = hash('SHA256',$password);
                        $user->setPassword($pwd);
                    }

                    $issetUser = $em->getRepository("BackendBundle:User")->findBy(array(
                        "email" =>$email
                    ));


                    if (count($issetUser) == 0 || $identity->email == $email){
                        $em->persist($user);
                        $em->flush();
                        $data = array(
                            'status' => 'success',
                            'code' => 200,
                            'msg' => 'Nuevo usuario actualizado',
                            'user' => $user
                        );
                    }
                    else {
                        $data = array(
                            'status' => 'error',
                            'code' => 400,
                            'msg' => 'Usuario no actualizado'
                        );
                    }
                }
            }
        }
        else {
            $data = array(
                'status' => 'error',
                'code' => 400,
                'msg' => 'Autorizacion no valida'
            );
        }
        return $helpers->json($data);
    }
}