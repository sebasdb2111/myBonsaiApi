<?php

namespace AppBundle\Controller;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function loginAction(Request $request)
    {
        $helpers = $this->get(Helpers::class);

        //Recibir json por POST
        $json = $request->get('json', null);

        //Array a devolver por defecto
        $data = array(
            'satus' => 'error',
            'data' => 'Send Json via POST'
        );

        if ($json != NUll) {
            //HACER LOGIN

            //convertir Json a objeto
            $params = json_decode($json);

            $email = (isset($params->email))?$params->email:null;
            $password = (isset($params->password))?$params->password:null;
            $getHass = (isset($params->getHash))?$params->getHash:null;

            $emailConstraint = new Assert\Email();
            $emailConstraint->message = 'This email is not valid!';
            $validate_email = $this->get('validator')->validate($email, $emailConstraint);

            //Cifrar contraseña
            $pwd = hash('SHA256',$password);

            if ($email != null && count($validate_email) == 0 && $pwd != null) {
                $jwt_auth = $this->get(JwtAuth::class);

                if ($getHass == null || $getHass == false)
                    $singup = $jwt_auth->singup($email, $pwd);
                else
                    $singup = $jwt_auth->singup($email, $pwd, true);

                return $this->json($singup);
            }
            else {
                $data = array(
                    'satus' => 'error',
                    'data' => 'Email incorrecto o contraseña incorrecto'
                );
            }
        }
        else {

        }
        return $helpers->json($data);
    }
}
