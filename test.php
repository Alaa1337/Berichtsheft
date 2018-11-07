<?php
if (!empty($_POST['submitted'])) {
    // Was hammer bekommen

    $_GET['template'] = 3;
    $_GET['pdf'] = 1;
    include "index.php";


    //print_r($_POST);exit;
    // Array ( [submitted] => 1 [vom] => 2018-11-01 [bis] => 2018-11-02 )
    exit;
}


?>

<html>
 <style>



     @font-face {
         font-family: 'GoldenSans';
         font-style: normal;
         font-weight: 400;
         src: url('./media/fonts/317772_5_0.woff2') format('woff2');
         src: url('./media/fonts/317772_5_0.eot');
         src: url('./media/fonts/317772_5_0.eot?#iefix') format('embedded-opentype'), url('./media/fonts/317772_5_0.woff2') format('woff2'), url('./media/fonts/317772_5_0.woff') format('woff'), url('./media/fonts/317772_5_0.ttf') format('truetype');
     }


html, body {
    margin:0;
    padding:0;
    background-color: grey;

}

     .middle {
         width:300px;
         border: 300px double cyan ;
         margin-left:auto;
         margin-right:auto;
     }
     input,select,textarea {
         width:170px;
         background-color: darkcyan;
         border:2px double black;
     }




     label
     {
         border:4px dotted black;
         padding-right : 74px;
         padding-left: 70px;

     }

     * {
         font-family: GoldenSans;

        margin: 20 auto;
        width: 100%;
        padding-left : 50px ;


     }


 </style>






<div class="middle">
    <h2 style="padding-left: 80px;">Generator</h2>
<form action="" method="post">
    <input type="hidden" name="submitted" value="1">
        <label for="vom" style="padding-right: 64px">vom</label><br>
    <input type="date" id="vom" name="vom">
<br>

<p></p>
<label for="bis">bis</label><br>
<input type="date" id="bis" name="bis">
<br>
<input type="submit" value="Ab die Post!" style="padding-right: 64px; background-color: darkcyan;">
</form>
</div>

</body>
</html>
