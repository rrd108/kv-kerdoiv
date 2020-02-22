<?php

use PDO;

require('./secrets.php');

if($secrets['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents('php://input');

    if (isset(json_decode($data)->status)) {
        $ch = curl_init($secrets['mailchimpUrl']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode('user:' . $secrets['mailchimpApiKey']),
            'Content-Length: ' . strlen($data)),
        );
        $result = curl_exec($ch);
        echo $result;
    }

    if (!isset(json_decode($data)->status)) {
        $data = json_decode($data);

        //var_dump($data);

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=' . $secrets['mysqlTable'], $secrets['mysqlUser'], $secrets['mysqlPass']);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $stmt = $pdo->prepare("INSERT INTO questionare (email, city, age, heard_fb, heard_kv, heard_inst, heard_plak, heard_ujs, heard_other, visits, tpl, ett, gos, kert, szab, vv_felk, vv_inf, vv_eloa, vv_seg, ett_val, ett_gyo, ett_men, ett_min, ett_ar, sh_val, sh_kisz, newsletter, vv_egyeb, ett_egyeb, sh_egyeb) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $stmt->bindValue(1, $data->email);
            $stmt->bindValue(2, $data->city);
            $stmt->bindValue(3, $data->age);

            $stmt->bindValue(4, 0);
            $stmt->bindValue(5, 0);
            $stmt->bindValue(6, 0);
            $stmt->bindValue(7, 0);
            $stmt->bindValue(8, 0);
            foreach($data->heard as $heard) {
                if ($heard == 'fb') {
                    $stmt->bindValue(4, 1);
                }
                if ($heard == 'kv') {
                    $stmt->bindValue(5, 1);
                }
                if ($heard == 'inst') {
                    $stmt->bindValue(6, 1);
                }
                if ($heard == 'plak') {
                    $stmt->bindValue(7, 1);
                }
                if ($heard == 'ujs') {
                    $stmt->bindValue(8, 1);
                }
            }

            $stmt->bindValue(9, $data->heardOther);
            $stmt->bindValue(10, $data->visits);

            $stmt->bindValue(11, 0);
            $stmt->bindValue(12, 0);
            $stmt->bindValue(13, 0);
            $stmt->bindValue(14, 0);
            $stmt->bindValue(15, 0);
            foreach($data->places as $place) {
                if($place[0] == 'tpl') {
                    $stmt->bindValue(11, $place[2]);
                }
                if($place[0] == 'ett') {
                    $stmt->bindValue(12, $place[2]);
                }
                if($place[0] == 'gos') {
                    $stmt->bindValue(13, $place[2]);
                }
                if($place[0] == 'kert') {
                    $stmt->bindValue(14, $place[2]);
                }
                if($place[0] == 'szab') {
                    $stmt->bindValue(15, $place[2]);
                }
            }

            $stmt->bindValue(16, 0);
            $stmt->bindValue(17, 0);
            $stmt->bindValue(18, 0);
            $stmt->bindValue(19, 0);
            $stmt->bindValue(20, 0);
            $stmt->bindValue(21, 0);
            $stmt->bindValue(22, 0);
            $stmt->bindValue(23, 0);
            $stmt->bindValue(24, 0);
            $stmt->bindValue(25, 0);
            $stmt->bindValue(26, 0);
            foreach($data->services as $services) {
                foreach($services as $service) {
                    if($service[0] == 'vv_felk') {
                        $stmt->bindValue(16, $service[2]);
                    }
                    if($service[0] == 'vv_inf') {
                        $stmt->bindValue(17, $service[2]);
                    }
                    if($service[0] == 'vv_eloa') {
                        $stmt->bindValue(18, $service[2]);
                    }
                    if($service[0] == 'vv_seg') {
                        $stmt->bindValue(19, $service[2]);
                    }
                    if($service[0] == 'ett_val') {
                        $stmt->bindValue(20, $service[2]);
                    }
                    if($service[0] == 'ett_gyo') {
                        $stmt->bindValue(21, $service[2]);
                    }
                    if($service[0] == 'ett_men') {
                        $stmt->bindValue(22, $service[2]);
                    }
                    if($service[0] == 'ett_min') {
                        $stmt->bindValue(23, $service[2]);
                    }
                    if($service[0] == 'ett_ar') {
                        $stmt->bindValue(24, $service[2]);
                    }
                    if($service[0] == 'sh_val') {
                        $stmt->bindValue(25, $service[2]);
                    }
                    if($service[0] == 'sh_kisz') {
                        $stmt->bindValue(26, $service[2]);
                    }
                }
            }

            $stmt->bindValue(27, $data->newsletter ? 1 : 0);
            $stmt->bindValue(28, $data->vv_egyeb);
            $stmt->bindValue(29, $data->ett_egyeb);
            $stmt->bindValue(30, $data->sh_egyeb);

            $stmt->execute();
        } catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }

    }
}