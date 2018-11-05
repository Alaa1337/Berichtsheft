<?php

// include autoloader
require_once __DIR__ . '/vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;




$user = 75;
$meinearbeit = [];
$kw = [];
$text = [];
$beispiel = [

    [
        'bereich' => '1.1. Informations- u. telekommunikationstechnische Produkte u. Märkte',
        'zeit' =>',',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => '1.2 Herstellen und Betreuen von Systemlösungen',
        'zeit' =>'3 – 4 Monate',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => '2.1. Geschäfts- und Leistungsprozesse',
        'zeit' =>'2 - 4 Monate',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => '3.1. Geschäfts- und Leistungsprozesse',
        'zeit' =>',',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => '3.2. Herstellen und Betreuen von Systemlösungen',
        'zeit' =>',',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => 'Systementwicklung',
        'zeit' =>'3 – 5 Monate ',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => '3.1. Geschäfts- und Leistungsprozesse',
        'zeit' =>',',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => '3.2. Herstellen und Betreuen von Systemlösungen',
        'zeit' =>',',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => 'Systementwicklung',
        'zeit' =>'3 – 5 Monate ',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => 'Systementwicklung',
        'zeit' =>'3 – 5 Monate ',
        'vonbis' =>'10-20'
    ],

    [
        'bereich' => 'Systementwicklung',
        'zeit' =>'3 – 5 Monate ',
        'vonbis' =>'10-20'
    ],



];

$template_table = '<tr>
                <td width="40%">{{$bereich}}</td>
                <td width="20%">{{$zeit}}</td>
				<td width="40%">{{$vonbis}}</td>
            </tr>';

$bla = '';

foreach ($beispiel as $value)
{

    $final = str_replace('{{$bereich}}', $value ['bereich'],$template_table ) ;
    $final = str_replace('{{$zeit}}', $value ['zeit'],$final) ;
    $final = str_replace('{{$vonbis}}', $value ['vonbis'],$final ) ;
    $bla .= $final;



}


//echo ($zeile['bereich']); die;

// Config
setlocale(LC_ALL, 'de_DE@euro');

// Liste aller möglichen Templates
$pdo = new PDO('mysql:host=localhost;dbname=startworking;charset=utf8', 'root', 'password');

$sql = "SELECT * FROM hours WHERE user_id = $user";
foreach ($pdo->query($sql) as $row) {

   $dateTime = new DateTime($row['start_date']);
   $kw = $dateTime->format("W");
   $tag = $dateTime->format("d.m.Y");

   $meinearbeit[$kw][$tag] = $dateTime->format("").' '.$row['task_description'];
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

reset($meinearbeit[$allererste_woche]);
$montag = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);

$dienstag = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);

$mittwoch = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);

$donnerstag = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);

$freitag = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);

$samstag = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);

$sonntag = $meinearbeit[$allererste_woche][key($meinearbeit[$allererste_woche])];
next($meinearbeit[$allererste_woche]);



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



/**/




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
	'jahr'=>'1',
    'erster_tag'=>$first_day_in_array,
    'letzter_tag'=>$check_day,
    'montag'=> $montag,
    'dienstag'=> $dienstag,
    'mittwoch'=> $mittwoch,
    'donnerstag'=> $donnerstag,
    'freitag'=> $freitag,
    'samstag'=> $samstag,
    'sonntag'=> $sonntag,
    'bla' => $bla
];

// ---------------- DON'T MESS WITH THE CODE BELOW UNLESS YOU ARE A PROGRAMMING GOOF!

$templateContents = file_get_contents($template);

foreach ($variablen as $key=>$val) {
	$templateContents = str_replace('{{ '.$key.' }}', $val, $templateContents);
}

if (empty($_GET['pdf'])) {
    echo $templateContents;
} else {
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($templateContents);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream();
    // PDF (https://github.com/dompdf/dompdf)
}
