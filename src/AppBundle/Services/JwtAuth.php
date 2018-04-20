<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 10/03/18
 * Time: 23:11
 */
namespace AppBundle\Services;
use Firebase\JWT\JWT;

class JwtAuth{
    public $manager;
    public $key;

    public function __construct($manager)
    {
        $this->manager = $manager;
        $this->key = "Estaeslaclavesecreta12345678901234567890";
    }

    public function singup($email, $password, $getHash = null)
    {
        $user = $this->manager->getRepository('BackendBundle:User')->findOneBy(
            array(
                "email" => $email,
                "password" => $password
            )
        );

        $singup = false;
        if(is_object($user)) {
            $singup = true;
        }

        if ($singup == true){
            //Generar token
            $token = array(
                "sub" => $user->getIduser(),
                "username" => $user->getUsername(),
                "email" => $user->getEmail(),
                "nombre" => $user->getNombre(),
                "apellidos" => $user->getApellidos(),
                "fechaNacimiento" => $user->getFechanacimiento(),
                "iat"=> time(),
                "exp" => time() + (7*24*60*60)
            );
            //return $data = array("objeto" => $user->getFechanacimiento(), "email" => $email, "pass" => $password);

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key,array('HS256'));

            if ($getHash == null)
                $data = $jwt;
            else
                $data = $decoded;


        }
        else{
            $data = array("satus" => "error",
                "data"=> "Login fallido",
                "objeto" => $user,
                "email" => $email,
                "pass" => $password);
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;
        try{
            $decoded = JWT::decode($jwt, $this->key,array('HS256'));
        }catch (\UnexpectedValueException $e) {
            $auth = false;
        }catch  (\DomainException $e) {
            $auth = false;
        }

        if (isset($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }
        else {
            $auth = false;
        }

        if ($getIdentity == false) {
            return $auth;
        }
        else {
            return $decoded;
        }
    }
}