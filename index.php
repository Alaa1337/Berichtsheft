<?php

// include autoloader
require_once __DIR__ . '/vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Carbon\Carbon;




$user = 75;
$meinearbeit = [];
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

if ($_POST['vom'] !== null){
    $carbon_vom =  Carbon::createFromFormat('Y-m-d', $_POST['vom']);

}

if ($_POST['bis'] !== null){
    $carbon_bis =  Carbon::createFromFormat('Y-m-d', $_POST['bis']);

}

// Liste aller möglichen Templates
$pdo = new PDO('mysql:host=localhost;dbname=startworking;charset=utf8', 'root', 'password');

$vom = $carbon_vom->format('d.m.Y');
$bis = $carbon_bis->format('d.m.Y');

$sql = "SELECT * FROM hours WHERE user_id = :user";  /*and start_date>='$_POST[from]' AND start_date<='$_POST[to]'*/

if ($carbon_vom !== null) {
    $sql .= " AND start_date>=:startddate";

}
if ($carbon_bis !== null) {
    $sql .= " AND start_date<=:enddate";

}



$prepared = $pdo->prepare($sql);
$prepared->bindValue('user', $user);
$prepared->bindValue('startddate', $carbon_vom->format('Y-m-d'));
$prepared->bindValue('enddate', $carbon_bis->format('Y-m-d'));
$prepared->execute();


foreach ($prepared->fetchAll() as $row) {

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





$templates = [
	1=>__DIR__.'/Nachweis.html',
	2=>__DIR__.'/Nachweis2.html',
	3=>__DIR__.'/Nachweis3.html',
];



// Unsere Auswahl
$template = $templates[$_GET['template']];



// ===============================================================================
// DO NOT TOUCH A FUCKING THING ABOVE THIS LINE
// ===============================================================================

$c = 0;

foreach ($meinearbeit as $allererste_woche=>$data) {

    $c++;

    //$pagebreak = echo '</html>';
    $letztewoche = $kw;

    reset($meinearbeit[$allererste_woche]);
    $montag_key = key($meinearbeit[$allererste_woche]);
    $montag = $meinearbeit[$allererste_woche][$montag_key];
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

    $sonntag_key = key($meinearbeit[$allererste_woche]);
    $sonntag = $meinearbeit[$allererste_woche][$sonntag_key];
    next($meinearbeit[$allererste_woche]);

    $html = file_get_contents($template);
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
        'erster_tag'=>$montag_key,
        'letzter_tag'=>$sonntag_key,
        'montag'=> $montag,
        'dienstag'=> $dienstag,
        'mittwoch'=> $mittwoch,
        'donnerstag'=> $donnerstag,
        'freitag'=> $freitag,
        'samstag'=> $samstag,
        'sonntag'=> $sonntag,
        'pagebreak' => $pagebreak
    ];


    if ($c >= count($meinearbeit)) {
        $variablen['pagebreak'] = "";
    } else {
        $variablen['pagebreak'] = "<div style=\"page-break-after: always;\">";
    }


    foreach ($variablen as $key=>$val) {
    	$html = str_replace('{{ '.$key.' }}', $val, $html);


    }

//print_r(key($meinearbeit));die;

    $templateContents .= $html;


}






$templateContents .= "</html>";


if (key($meinearbeit) == $letztewoche )
{

    //$pagebreak = "nomraler text";
    echo $variablen['pagebreak'];
}

// ===============================================================================
// DO NOT TOUCH A FUCKING THING BELOW THIS LINE
// ===============================================================================



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
