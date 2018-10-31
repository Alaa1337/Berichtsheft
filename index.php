<?php

$user = 75;
$meinearbeit = [];
$kw = [];

// Config
setlocale(LC_ALL, 'de_DE@euro');

// Liste aller möglichen Templates
$pdo = new PDO('mysql:host=localhost;dbname=startworking;charset=utf8', 'root', 'password');

$sql = "SELECT * FROM hours WHERE user_id = $user";
foreach ($pdo->query($sql) as $row) {

   $dateTime = new DateTime($row['start_date']);
   $kw = $dateTime->format("W");
   $tag = $dateTime->format("d.m.Y");

   $meinearbeit[$kw][$tag] = $dateTime->format("l").': '.$row['task_description'];
}


foreach ($meinearbeit as $kw=>$data) {
    if (count($data) != 7) {
        reset($data);
        $first_day_in_array = key($data);

        $dateTime = new DateTime($first_day_in_array);
        $monday_in_selected_week = $dateTime->modify("monday")->format('d.m.Y');

        for ($t=0; $t<7; $t++) {
            $dt = new DateTime($monday_in_selected_week);
            $check_day = $dt->add(new DateInterval('P'.$t.'D'))->format('d.m.Y');
            if (!isset($meinearbeit[$kw][$check_day])) {
                $meinearbeit[$kw][$check_day] = 'Habe nix geobeit, hehe';
            }
        }
    }
}

foreach ($meinearbeit as $kw=>&$data) {
    ksort($data);
}

reset($meinearbeit);
$allererste_woche = key($meinearbeit);


print_r($meinearbeit[$allererste_woche]);

/*

$meinearbeit = [

    'KW 30'=>[


    ],
    'KW 31'=>[
        '10.09.2018'=>"Geschuftet",
        'xx.09.2018'=>"Geschuftet",
        'xx.09.2018'=>"Geschuftet",
        'xx.09.2018'=>"Geschuftet",
        'xx.09.2018'=>"Geschuftet",
        'xx.09.2018'=>"",
        'xx.09.2018'=>""
    ]
];


$kw = 30;
$tag = "irgendeinmontag";

$meinearbeit = [];
$meinearbeit[$kw] = [$dateTime->format("l d.m.Y").'<br>'];
$meinearbeit[$kw][$tag] = "task";



*/




$templates = [
	1=>__DIR__.'/Nachweis.html',
	2=>__DIR__.'/Nachweis2.html',
	3=>__DIR__.'/Nachweis3.html',
];

// Unsere Auswahl
$template = $templates[$_GET['template']];

$variablen = [
	'heftnr'=>'1',
	'vorname'=>'Alaa',
	'nachname'=>'Falah',
    'adresse'=>'Salzstraße 18',
    'beruf'=>'Fachinformatiker, Anwendungsentwicklung',
    'betrieb'=>'itspoon GmbH',
    'ausbilder'=>'Margus Kohv',
    'ende'=>'2021',
	'jahr'=>'1'
];

// ---------------- DON'T MESS WITH THE CODE BELOW UNLESS YOU ARE A PROGRAMMING GOOF!

$templateContents = file_get_contents($template);

foreach ($variablen as $key=>$val) {
	$templateContents = str_replace('{{ '.$key.' }}', $val, $templateContents);
}

echo $templateContents;
