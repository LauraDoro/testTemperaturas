<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Message;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpKernel\KernelInterface;


/**
 * @Route("/temperatura")
 */
class TemperaturaController extends AbstractController
{

    /**
     * @Route("/", name="tester")
     */
    public function indexAction(Request $request)
    {


        
    }

    /**
     * @Route("/correo", name="correo")
     */
    public function correoAction(Request $request)
    {
        $temperaturas = $request->query->get('temperaturas');

        $html = $this->renderView('temperaturas/mail.html.twig', [
            'temperaturas' => $temperaturas
        ]);
      
        // Create the Transport
        $transport = (new Swift_SmtpTransport('in-v3.mailjet.com', 587, 'tls'))
        ->setUsername('536b3b0ee2c88f009d2694b04f97a581')
        ->setPassword('421da94756d17be7e64045378fcbe60f');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Wonderful Subject'))
        ->setFrom(['test@codery.net' => 'Test'])
        ->setTo(['lauradoro83@gmail.com'])
        ->setBody($html, 'text/html');

        // Send the message
        $result = $mailer->send($message);

        return new Response("Correo enviado");
    }

    /**
     * @Route("/apiTemperaturas", name="apiTemperaturas")
     */
    public function apiTemperaturasAction()
    {
        $apiKey = "68844f79d62759155fa0ee2382446c87";
        $citiesId = [3119841, 3117813, 3114965, 3113209];
        $temperaturas = [];

        foreach ($citiesId as $city){
            $apiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $city . "&lang=en&units=metric&APPID=" . $apiKey ."&units=metric";

            $request = file_get_contents($apiUrl);

            $jsonPHP  = json_decode($request, true);

            array_push($temperaturas, $jsonPHP);
        }
    
        
        return $this->render('temperaturas/index.html.twig', [
            'temperaturas' =>  $temperaturas,
        ]);

    }




}