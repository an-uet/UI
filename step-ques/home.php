<?php
require_once('../lib/functions.php');

$d = initializeApp('step-ques');
$ni = sizeof($d['data']);
$iu = array($ni);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
    <?php echo $d['title']; ?>
    </title>
    <link rel="stylesheet" href="gameStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/daneden/animate.css/v3.1.0/animate.min.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://use.fontawesome.com/6a43f37e2c.js"></script>
    <!-- Style của các game -->
    <link rel="stylesheet" href="fill_blank/fill_blank.css">
    <link rel="stylesheet" href="which_first/which_first.css">
    <link rel="stylesheet" href="mc_quiz/mc_quiz.css">
    <link rel="stylesheet" href="matching/matching.css">
    <link rel="stylesheet" href="step/step.css">

</head>

<body class="main">
    <div id="wrap" class="home">
        <div id="content">
            <section class="progress">
                <div id="container">
                    <div class="start">
                        <ul class="row">
                            <li>
                                <div>
                                    <div class="animate fadeInLeft" data-wow-delay='0.4s'>
                                        <img id="step-0" src="image/icon.png">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4>Bắt đầu khám phá bảo tàng</h4>
                                    <p>Hãy đến từng phòng trưng bày theo chỉ dẫn sau, hoàn thành nhiệm vụ và nhận những phần quà từ chúng tôi</p>
                                </div>
                            </li>
                            <?php

                            for ($i = 0; $i < $ni; $i++) {
                                $itemid = $d['data'][$i];
                                ....
                            }
                            ?>
                            

                        </ul>
                    </div>
                </div>
            </section>
        </div>
        <div class="end">
        </div>
    </div>

    <button id="exit" class="none">exit</button>
    <div id="game">


    </div>
    <script src="wow.min.js"></script>
    <script src="data.js"></script>
    <script src="gametest.js "></script>
    <script src="fill_blank/fill_blank.js"></script>
    <script src="which_first/which_first.js"></script>
    <script src="mc_quiz/mc_quiz.js"></script>
    <script src="matching/matching.js"></script>
    <script src="step/step.js"></script>
    


    <script>
        var wow = new WOW({
            boxClass:'animate',
            animateClass: 'animated',
            offset: 30,
            mobile:true
        });
        wow.init();


    </script>

</body>

</html>