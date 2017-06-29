<?php

namespace Acme\Bundle\BitcoinBundle\Controller;

header('Access-Control-Allow-Origin: *');

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Cookie;
//use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; //inheriting the Request class
use \DateTime;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('AcmeBitcoinBundle:Default:index.html.twig');
    }

    public function datatableAction() {
        $alert_form = $this->createForm(new \Acme\Bundle\BitcoinBundle\Form\AddNewRatesType(), null, array(
            'action' => $this->generateUrl('acme_bitcoin_form_update'),
        ));

        return $this->render('AcmeBitcoinBundle:Bitcoin:table.html.twig', array(
                    'form' => $alert_form->createView()
        ));
    }

    public function graphAction() {
        return $this->render('AcmeBitcoinBundle:Graphs:graphs.html.twig');
    }

    public function AlertAction() {
        return $this->render('AcmeBitcoinBundle:Bitcoin:alert.html.twig');
    }

    public function MangeAlertAction() {
        return $this->render('AcmeBitcoinBundle:Bitcoin:manage-alert.html.twig');
    }

    public function ApiDataAction() {
        $url = "http://www.bitcoinrates.in/getdata.php";
        $ch = curl_init($url);
        //  $ch = curl_init('https://sendgrid.com/api/invalidemails.get.json?api_user=10times&api_key=10T75@mailer&date=1');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        //  Initiate curl
//        $ch = curl_init();
//        // Disable SSL verification
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        // Will return the response, if false it print the response
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        // Set the url
//        curl_setopt($ch, CURLOPT_URL, $url);
//        // Execute
//        $result = curl_exec($ch);
//        // Closing
//        curl_close($ch);
//
//        // Will dump a beauty json :3
//        //var_dump(json_decode($result, true));
//        // $result = file_get_contents($url);
//        $data = json_decode($result, true);
        $json = json_encode($response);

        print_r($json);
        die;
    }

    public function FormDataAction() {
        $alert_form = $this->createForm(new \Acme\Bundle\BitcoinBundle\Form\AddNewRatesType(), null, array(
            'action' => $this->generateUrl('acme_bitcoin_form_update'),
        ));

        return $this->render("AcmeBitcoinBundle:AlertForm:alertform.html.twig", array(
                    'form' => $alert_form->createView(),
        ));
    }

    public function AlertCreateAction(Request $request) {
        $status = false;
        $errors_array = array();
        $message = '';
        $em = $this->getDoctrine()->getManager();
        $alert_form = $this->createForm(new \Acme\Bundle\BitcoinBundle\Form\AddNewRatesType(), null, array(
            'action' => $this->generateUrl('acme_bitcoin_form_update'),
        ));

        if ($request->isMethod('POST')) {
            $alert_form->handleRequest($request);
            if ($alert_form->isValid()) {
                try {
                    $postData = $request->request->all();
//                    print_r($postData);
//                    die;
                    $date = new \DateTime("now");

                    $dates = $date->format('Y-m-d H:i:s');
                    // print_r($dates);die;
                    $alert_tasks = new \Acme\Bundle\BitcoinBundle\Entity\AlertData();
                    $alert_tasks->setEmail($postData['acmebundle_bitcoinbundle']['email']);
                    $alert_tasks->setPhoneNumber($postData['acmebundle_bitcoinbundle']['phone_number']);
                    $alert_tasks->setBuyMin($postData['acmebundle_bitcoinbundle']['buy_min']);
                    $alert_tasks->setBuyMax($postData['acmebundle_bitcoinbundle']['buy_max']);
                    $alert_tasks->setSellMin($postData['acmebundle_bitcoinbundle']['sell_min']);
                    $alert_tasks->setSellMax($postData['acmebundle_bitcoinbundle']['sell_max']);
                    $alert_tasks->setStatus('1');
                    $alert_tasks->setStartDate($dates);
                    $alert_tasks->setEndDate($dates);

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($alert_tasks);
                    $em->flush();
                    $message = "Alert Succesfully Added!";

                    $status = true;
                } catch (Exception $ex) {
                    print_r($ex->getMessage());
                    die;
                }
                if ($status == true) {
                    $url = $this->generateUrl("acme_bitcoin_datatable", array());
                    return $this->redirect($url);
                }
            }
        }
    }

}
