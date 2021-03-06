<?php

use PDO;

// TODO do not responde to api calls without authentication

require('./secrets.php');

if($secrets['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

$months = ['január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //TODO check API key
    if($_GET['data'] == 'all') {
        // filled and newsletter subscribers
        $pdo = new PDO('mysql:host=localhost;dbname=' . $secrets['mysqlTable'], $secrets['mysqlUser'], $secrets['mysqlPass']);
        $result = $pdo->query("SELECT DATE_FORMAT(created, '%Y-%m') as month, COUNT(id) as filled, SUM(newsletter) as newsletter
            FROM questionare
            GROUP BY month")->fetchAll();

        $data = new stdClass;
        $data->filled = new stdClass;
        foreach ($result as $r) {
            $data->filled->labels[] = $r['month'];
            $data->filled->datasets[0]['data'][] = $r['filled'];
            $data->filled->datasets[1]['data'][] = $r['newsletter'];
        }

        // cities
        $result = $pdo->query("SELECT COUNT(id) AS db, city
            FROM questionare
            GROUP BY city")->fetchAll();
        $data->city = new stdClass;
        foreach ($result as $r) {
            $data->city->labels[] = $r['city'];
            $data->city->datasets[0]['data'][] = $r['db'];
        }

        // age
        $result = $pdo->query("SELECT COUNT(id) AS db, age
            FROM questionare
            GROUP BY age
            ORDER BY age")->fetchAll();
        $data->age = new stdClass;
        foreach ($result as $r) {
            $data->age->labels[] = $r['age'] . ' év';
            $data->age->datasets[0]['data'][] = $r['db'];
        }
        $data->age->datasets[0]['label'] = 'Életkor';

        // heard
        $result = $pdo->query("SELECT SUM(heard_fb) AS facebook, SUM(heard_kv) AS krisnavolgy, SUM(heard_inst) AS instagram, SUM(heard_plak) AS plakát, SUM(heard_ujs) AS újság
            FROM questionare")->fetchAll();
        $data->heard = new stdClass;
        foreach ($result[0] as $heard => $r) {
            if (is_string($heard)) {
                $data->heard->labels[] = $heard;
                $data->heard->datasets[0]['data'][] = is_string($r) ? $r : $r[0];
            }
        }
        $data->heard->datasets[0]['label'] = 'Honnan halottál rólunk?';
        // TODO heard other

        // visits
        $result = $pdo->query("SELECT COUNT(id) AS db, visits
            FROM questionare
            GROUP BY visits
            ORDER BY visits")->fetchAll();
        $data->visits = new stdClass;
        foreach ($result as $r) {
            $data->visits->labels[] = $r['visits'];
            $data->visits->datasets[0]['data'][] = $r['db'];
        }
        $data->visits->datasets[0]['label'] = 'Vendég';

        // liked
        $result = $pdo->query("SELECT AVG(NULLIF(tpl, 0)) AS templom, AVG(NULLIF(ett, 0)) AS étterem, AVG(NULLIF(gos, 0)) AS gosala, AVG(NULLIF(kert, 0)) AS kert, AVG(NULLIF(szab, 0)) AS szabadtér
            FROM questionare")->fetchAll();
        $data->liked = new stdClass;
        foreach ($result[0] as $liked => $r) {
            if (is_string($liked)) {
                $data->liked->labels[] = $liked;
                $data->liked->datasets[0]['data'][] = is_string($r) ? $r : $r[0];
            }
        }
        $data->liked->datasets[0]['label'] = 'Mennyire tetszett?';

        //satisfied
        // TODO add egyéb mindháromhoz
        //vv
        $result = $pdo->query("SELECT AVG(NULLIF(vv_felk, 0)) AS felkészültség, AVG(NULLIF(vv_inf, 0)) AS információ, AVG(NULLIF(vv_eloa, 0)) AS előadás, AVG(NULLIF(vv_seg, 0)) AS segítőkészség
            FROM questionare")->fetchAll();
        $data->satisfiedVv = new stdClass;
        foreach ($result[0] as $satisfiedVv => $r) {
            if (is_string($satisfiedVv)) {
                $data->satisfiedVv->labels[] = $satisfiedVv;
                $data->satisfiedVv->datasets[0]['data'][] = is_string($r) ? $r : $r[0];
            }
        }
        $data->satisfiedVv->datasets[0]['label'] = 'Vendégvezetés';

        //ett
        $result = $pdo->query("SELECT AVG(NULLIF(ett_val, 0)) AS választék, AVG(NULLIF(ett_gyo, 0)) AS gyorsaság, AVG(NULLIF(ett_men, 0)) AS menü, AVG(NULLIF(ett_min, 0)) AS minőség, AVG(NULLIF(ett_ar, 0)) AS ár
            FROM questionare")->fetchAll();
        $data->satisfiedEtt = new stdClass;
        foreach ($result[0] as $satisfiedEtt => $r) {
            if (is_string($satisfiedEtt)) {
                $data->satisfiedEtt->labels[] = $satisfiedEtt;
                $data->satisfiedEtt->datasets[0]['data'][] = is_string($r) ? $r : $r[0];
            }
        }
        $data->satisfiedEtt->datasets[0]['label'] = 'Étterem';

        //shop
        $result = $pdo->query("SELECT AVG(NULLIF(sh_val, 0)) AS választék, AVG(NULLIF(sh_kisz, 0)) AS kiszolgálás, AVG(NULLIF(sh_ar, 0)) AS ár, AVG(NULLIF(sh_min, 0)) AS minőség
            FROM questionare")->fetchAll();
        $data->satisfiedSh = new stdClass;
        foreach ($result[0] as $satisfiedSh => $r) {
            if (is_string($satisfiedSh)) {
                $data->satisfiedSh->labels[] = $satisfiedSh;
                $data->satisfiedSh->datasets[0]['data'][] = is_string($r) ? $r : $r[0];
            }
        }
        $data->satisfiedSh->datasets[0]['label'] = 'Ajándékbolt';

        echo json_encode($data);
        return;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents('php://input');

    if (isset(json_decode($data)->email) && isset(json_decode($data)->password)) {
        // with this identification passwords should be unique
        if(json_decode($data)->email == array_search(md5(json_decode($data)->password), $secrets['users'])) {
            echo array_search(md5(json_decode($data)->password), $secrets['users']);
            return;
        }
        return;
    }

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
        return;
    }

    if (!isset(json_decode($data)->status)) {
        $data = json_decode($data);

        $pdo = new PDO('mysql:host=localhost;dbname=' . $secrets['mysqlTable'], $secrets['mysqlUser'], $secrets['mysqlPass']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $pdo->prepare("INSERT INTO questionare (email, city, age, heard_fb, heard_kv, heard_inst, heard_plak, heard_ujs, heard_other, visits, tpl, ett, gos, kert, szab, vv_felk, vv_inf, vv_eloa, vv_seg, ett_val, ett_gyo, ett_men, ett_min, ett_ar, sh_val, sh_kisz, sh_ar, sh_min, newsletter, vv_egyeb, ett_egyeb, sh_egyeb) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

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
                if($service[0] == 'sh_ar') {
                    $stmt->bindValue(27, $service[2]);
                }
                if($service[0] == 'sh_min') {
                    $stmt->bindValue(28, $service[2]);
                }
            }
        }

        $stmt->bindValue(29, $data->newsletter ? 1 : 0);
        $stmt->bindValue(30, $data->vv_egyeb);
        $stmt->bindValue(31, $data->ett_egyeb);
        $stmt->bindValue(32, $data->sh_egyeb);

        echo $stmt->execute();
        return;
    }
}