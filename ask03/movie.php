<?php
    //start GET request and variable set
    $movie = $_GET["film"];
    $moviesfolder = "moviefiles/";
?>

<?php
    //open files for the movie request from user
    $dir_info = $moviesfolder . $movie . "/info.txt";       //info file url
    $dir_img = $moviesfolder . $movie . "/overview.png";    //image file url
    $dir_overview = $moviesfolder . $movie . "/overview.txt";   //overview file url

    //open info file and save to url
    $file_info = fopen("$dir_info", "r") ; //or die("Unable to open file!");
    $contents_info = fread($file_info,filesize("$dir_info"));
    fclose($file_info);

    //open overview file and save to url
    $file_overview = fopen("$dir_overview", "r") ; //or die("Unable to open file!");
    $contents_overview = fread($file_overview,filesize("$dir_overview"));
    fclose($file_overview);


    //create array with line, use the split
    $array_info = preg_split ('/$\R?^/m', $contents_info);
    $array_overview = preg_split ('/$\R?^/m', $contents_overview);

    //get all review files for the movie
    $reviewlist = glob($moviesfolder. $movie ."/" . "review*.txt");




?>

    <html><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title> <?= $array_info[0] ?> - Rancid Tomatoes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="movie.css">
    <link rel="shortcut icon" type="image/gif" href="images/rotten.gif">
</head>
<body>
<div id="banner"><img src="images/banner.png" alt="banner"></div>
<h1><?= $array_info[0] ?> (<?= $array_info[1] ?>)</h1>
<div id="overall">
    <div id="Overview">
        <img src=<?= $dir_img ?> alt="overview">
        <dl class="OverViewdl">
            <?php
                for($i = 0; $i < sizeof($array_overview); $i++){
                    $nameTitle = explode(':',$array_overview[$i] );
            ?>
                    <dt><?= $nameTitle[0] ?> </dt> <dd> <?= $nameTitle[1] ?> </dd>

                <?php } ?>
        </dl>
    </div>
    <div id="reviews">
        <div id="reviewsbar">
            <?php
                if($array_info[2] >= 60){
                    echo  '<img id="reviewsbarimg" src="images/fresh.jpg" alt="overview">';
                }
                else{
                    echo  '<img id="reviewsbarimg" src="images/rottenbig.png" alt="overview">';
                }
            ?>

            <div id="rate"><?= $array_info[2]?>%</div>
        </div>


        <div class="reviewcol">

        <?php

        $number_review = sizeof($reviewlist);

        $number_row = ceil($number_review / 2 );




        for($i = 0; $i <$number_review; $i++) {

            if($i == $number_row){

                echo    '</div>';
                echo    '<div class="reviewcol">';
            }

            $dir_review = $moviesfolder . $movie . "/" . basename($reviewlist[$i]);

            $file_review = fopen($dir_review, "r") ; //or die("Unable to open file!");
            $contents_review = fread($file_review,filesize("$dir_review"));
            fclose($file_review);

            $array_review = preg_split ('/$\R?^/m', $contents_review);



            ?>


                <div class="reviewquote">
                    <?php
                    if("FRESH" == $array_review[1]){
                        echo '<img class="likeimg" src="images/fresh.gif" alt="fresh">';
                    }else{
                        echo '<img class="likeimg" src="images/rotten.gif" alt="rotten">';
                    }

                    echo "$array_review[0]" ;
                    ?>

                </div>
                <div class="personalquote">
                    <img class="personimg" src="images/critic.gif" alt="critic">
                    <?= $array_review[2]?><br>
                    <?= $array_review[3] ?>
                </div>


            <?php
            }
        ?>
        </div>


        <div id="bottombar">
            <?= "(1-" . $number_review . ") of" .$number_review ?>

    </div>
</div>
<div id="w3ccheck">
    <a href="http://validator.w3.org/check/referer"><img src="images/w3c-html.png" alt="Valid HTML5"></a> <br>
    <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="images/w3c-css.png" alt="Valid CSS"></a>
</div>


</body></html>
