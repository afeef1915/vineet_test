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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        //  Initiate curl

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
                    $alert_tasks->setBitcoinRates($postData['acmebundle_bitcoinbundle']['bitcoin']);
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

    public function ListUsersAction() {
        $result = $this->getDoctrine()->getManager();
        $person_data = $result->createQueryBuilder()
                ->select('u.id,u.email, u.phone_number,u.buy_min,u.buy_max,u.sell_min,u.sell_max,u.status,u.start_date,u.end_date,u.bitcoin_rates')
                ->from('AcmeBitcoinBundle:AlertData', 'u')
                ->orderBy('u.id', 'asc')
        ;
        //$sql=$results->getQuery();
        //echo   $sql->getSql();
        $data = $person_data->getQuery()->getResult();
        $json_data = json_encode($data);
        print_r($json_data);
        die;
    }

    public function ListUsersDataAction() {
        $result = $this->getDoctrine()->getManager();
        $person_data = $result->createQueryBuilder()
                ->select('u.id,u.email, u.phone_number,u.buy_min,u.buy_max,u.sell_min,u.sell_max,u.status,u.start_date,u.end_date,u.bitcoin_rates')
                ->from('AcmeBitcoinBundle:AlertData', 'u')
                ->orderBy('u.id', 'asc')
        ;
        //$sql=$results->getQuery();
        //echo   $sql->getSql();
        $data = $person_data->getQuery()->getResult();

        $json = '[';
        $first = 0;
        foreach ($data as $v) {
            $bitcoin = 'Sell';
            if ($v['bitcoin_rates'] == 1) {
                $bitcoin = 'Buy';
            }
//            $start_date=
//                    $end_date=
            if ($first++)
                $json .= ',';


            $json .= '["' . $v['id'] . '",
        "' . $v['email'] . '",
       
        "' . $v['phone_number'] . '",
            "' . $v['buy_min'] . '",
                "' . $v['buy_max'] . '",
            "' . $v['sell_min'] . '",
                "' . $v['sell_max'] . '",
            "' . $v['status'] . '",
                "' . $v['start_date']->format('d-M-Y') . '",
            "' . $v['end_date']->format('d-M-Y') . '",
                    "' . $bitcoin . '"]';
        }
        $json .= ']';
//        $response = json_decode($json, true);
//       $json_data=json_encode($response);

        return $this->render('AcmeBitcoinBundle:Datatable:list.html.twig', array(
                    'json_data' => $json
        ));
    }

    public function SendSmsAction() {
        $data = file_get_contents('http://localhost/afeeftest-master/web/app_dev.php/users-list');
        $json_decode = json_decode($data, true);
        $message_buy = 'Buy Alert
                       Buy Rate Touched : bit coin rates visit: www.buybtc.in to check more!';
        $message_sell = 'Sell Alert
                        Sell Rate Touched : bit coin rates visit: www.buybtc.in to check more!';



        foreach ($json_decode as $key => $value) {
            $phone_number = $value['phone_number'];
            try {
                file_get_contents('http://103.16.101.52:8080/sendsms/bulksms?username=4567-capaz&password=Kota0141&type=0&dlr=1&destination=' . $value['phone_number'] . '&source=buybtc&message=test');
            } catch (\Exception $e) {

                $message = $e->getMessage();
                print_r($message);
                die;
            }
        }
        die("message sent");
    }

}
