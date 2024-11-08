<?php
session_start();

$initialParticipants = 
[
    ["code" => 1, "name" => "Іван", "gender" => "Чоловік", "age" => 25, "country" => "Україна", "score1" => 80, "score2" => 85, "score3" => 90],
    ["code" => 2, "name" => "Марія", "gender" => "Жінка", "age" => 22, "country" => "Україна", "score1" => 70, "score2" => 75, "score3" => 80],
    ["code" => 3, "name" => "Олег", "gender" => "Чоловік", "age" => 30, "country" => "Польща", "score1" => 85, "score2" => 80, "score3" => 88],
    ["code" => 4, "name" => "Анна", "gender" => "Жінка", "age" => 28, "country" => "Україна", "score1" => 78, "score2" => 82, "score3" => 87],
    ["code" => 5, "name" => "Дмитро", "gender" => "Чоловік", "age" => 27, "country" => "Білорусь", "score1" => 65, "score2" => 70, "score3" => 72]
];

if (!isset($_SESSION['tournament'])) 
{
    $_SESSION['tournament'] = [];
}

function generateUniqueCode() 
{
    $code = 1;
    while (array_key_exists($code, $_SESSION['tournament'])) 
    {
        $code++;
    }
    return $code;
} 

$action = $_POST['action'];
switch ($action) 
{
    case 'add':
        $code = generateUniqueCode();
        $participant = 
        [
            "code" => $code,
            "name" => $_POST['name'],
            "gender" => $_POST['gender'],
            "age" => intval($_POST['age']),
            "country" => $_POST['country'],
            "score1" => intval($_POST['score1']),
            "score2" => intval($_POST['score2']),
            "score3" => intval($_POST['score3'])
        ];
        $_SESSION['tournament'][$code] = $participant;
        echo json_encode($participant);
        break;

    case 'filter':
        $country = $_POST['country'];
        $age = intval($_POST['age']);
        $filtered = array_filter($_SESSION['tournament'], function ($p) use ($country, $age) 
        {
            return (!$country || strcasecmp($p['country'], $country) == 0) &&
                   (!$age || $p['age'] >= $age);
        });
        echo json_encode(array_values($filtered));
        break;

    case 'update':
        $code = intval($_POST['code']);
        if (isset($_SESSION['tournament'][$code])) 
        {
            $_SESSION['tournament'][$code]['name'] = $_POST['name'];
            $_SESSION['tournament'][$code]['gender'] = $_POST['gender'];
            $_SESSION['tournament'][$code]['age'] = intval($_POST['age']);
            $_SESSION['tournament'][$code]['country'] = $_POST['country'];
            $_SESSION['tournament'][$code]['score1'] = intval($_POST['score1']);
            $_SESSION['tournament'][$code]['score2'] = intval($_POST['score2']);
            $_SESSION['tournament'][$code]['score3'] = intval($_POST['score3']);
            echo json_encode($_SESSION['tournament'][$code]);
        }
        break;

    case 'getAll':
        echo json_encode(array_values($_SESSION['tournament']));
        break;

    case 'reset':
        $_SESSION['tournament'] = [];
        foreach ($initialParticipants as $participant) 
        {
            $_SESSION['tournament'][$participant['code']] = $participant;
        }
        echo json_encode(array_values($_SESSION['tournament']));
        break;

    case 'save':
        file_put_contents('./data/saveData.json', json_encode(array_values($_SESSION['tournament'])));
        echo json_encode(["status" => "success", "message" => "Дані збережено успішно."]);
        break;

    case 'load':
        if (file_exists('loadData.json')) 
        {
            $loadedData = json_decode(file_get_contents('loadData.json'), true);
                
             $_SESSION['tournament'] = [];
            foreach ($loadedData as $participant) 
            {
                $_SESSION['tournament'][$participant['code']] = $participant;
            }
            echo json_encode(array_values($_SESSION['tournament']));
        } 
        else 
        {    
            echo json_encode(["status" => "error", "message" => "Файл для завантаження не знайдено."]);
            
        }
        break;
}
?>