<?php
/**
 * Created by PhpStorm.
 * User: sebas
 * Date: 10/03/18
 * Time: 9:59
 */
namespace AppBundle\Services;

Class Helpers{
    public $manager;
    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function json($data)
    {
        $normalizers = array(new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer());
        $encoders = array("json" => new \Symfony\Component\Serializer\Encoder\JsonEncoder());
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers,$encoders);
        $json = $serializer->serialize($data, 'json');
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->setContent($json);
        $response->headers->set('Content-Type','application/json');
        return $response;
    }
}