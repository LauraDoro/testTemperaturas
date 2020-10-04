<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/temperatura")
 */
class TemperaturaController extends AbstractController
{
    
    /**
     * @Route("/", name="apiTemperaturas")
     */
    public function apiTemperaturasAction()
    {
        $apiKey = "68844f79d62759155fa0ee2382446c87";
        $citiesId = [3119841, 3117813, 3114965, 3113209];
        $temperaturas = [];

        //Llamada a la api para cada ciudad.
        foreach ($citiesId as $city){
            $apiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $city . "&lang=en&units=metric&APPID=" . $apiKey ."&units=metric";
            $curl = curl_init();
            $headers = array();
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $apiUrl);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            $json = curl_exec($curl);
            curl_close($curl);
            $jsonPHP  = json_decode($json, true);
            array_push($temperaturas, $jsonPHP);

        }

        return $this->render('temperaturas/index.html.twig', [
            'temperaturas' =>  $temperaturas,
        ]);

    }


    /**
     * @Route("/correo", name="correo")
     */
    public function correoAction(Request $request)
    {
        $temperaturas = $request->query->get('temperaturas');

        //Formateo del texto para mail 
        $html = $this->renderView('temperaturas/mail.html.twig', [
            'temperaturas' => $temperaturas
        ]);

        try{
            // Create the Transport
            $transport = (new Swift_SmtpTransport('in-v3.mailjet.com', 587, 'tls'))
            ->setUsername('536b3b0ee2c88f009d2694b04f97a581')
            ->setPassword('421da94756d17be7e64045378fcbe60f');

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['test@codery.net' => 'Test'])
            ->setTo(['gestion@codery.es'])
            ->setBody($html, 'text/html');

            // Send the message
            $result = $mailer->send($message);

        }catch(\Swift_TransportException $e){
            $result = $e->getMessage() ;
        }

        return new Response("Correo enviado");
    }


}