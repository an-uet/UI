<?php
require_once('../lib/functions.php');
require_once('./mc_quiz/mc_quiz.php');
require_once('./fill_blank/fill_blank.php');
require_once('./which_first/which_first.php');
require_once('./display/display.php');

$d = initializeApp('step-ques');
$home_bg = fetchItemData($d['image']);
$home_bg_url = $home_bg['url_full'];
$title = $d['title'];
$desc = $d['desc'];
$ni = sizeof($d['data']);
$iu = array($ni);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $d['title']; ?>
    </title>
    <link rel="stylesheet" href="homeStyle.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="gameStyle.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/daneden/animate.css/v3.1.0/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://use.fontawesome.com/6a43f37e2c.js"></script>
    <!-- Style của các game -->
    <link rel="stylesheet" href="./which_first/which_first.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./fill_blank/fill_blank.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./mc_quiz/mc_quiz.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="giftBox.css">

    <style>
        .home:before {
            background-image: url("<?php echo $home_bg_url; ?>");
        }

        .none {
            display: none;
        }
    </style>
</head>

<body>
    <div class="abc">
        <div class="progress none">
            <h1 class="progress-text is-active"></h1>
            <div class="progress-bar">
                <div data-progress="0" style="width: 0%;"></div>
            </div>
        </div>
        <div class="score none">Điểm: <label id="points-label">0</label></div>
    </div>
    <div class="meo">
        <div class="buttons none">
            <a href="#" data-direction="prev" class="btn prev">&lt;</a>
            <a href="#" data-direction="next" class="btn next">&gt;</a>

        </div>
        <div class="hint_close">
            <a id="close" class="none"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
            <a title="Hướng dẫn" class="btn_hint none"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="home">
        <?php
        echo "<div class='home-title'><h1>$title</h1></div>";
        ?>
        <button id="start" class="fill_blank__button">Bắt đầu</button>
        <button class="none fill_blank__button" id="continue">Tiếp tục</button>
        <?php
        echo "<div class='home-desc'><h1>$desc</h1></div>";
        ?>
    </div>




    <?php
    $html = [];
    $result = [];
    $hint = [];
    $key = "";
    $key_display = "";
    $question = "";
    $gift1 = $d['gift']['gift1'];
    $gift2 = $d['gift']['gift2'];
    $gift3 = $d['gift']['gift3'];


    for ($i = 0; $i < $ni; $i++) {
        $dataid = $d['data'][$i];
        $game_title = $dataid['title'];
        $game_desc = $dataid['desc'];
        $image   = fetchItemData($dataid['image']);
        // echo htmlStepQues($i, $image, $game_title, $game_desc);
        $type = $dataid['type'];
        $hint[$i] = $dataid['hint'];

        if ($type == "which_first") {
            $html[$i] = whichFirstHtml($dataid, $i);
        }
        if ($type == "fill_blank") {
            $html[$i] = fillBlankHtml($dataid, $i);
        }

        if ($type == "display") {
            $html[$i] = displayGameHtml($dataid, $i);
        }
        if ($type == "mc_quiz") {
            $html[$i] = mcQuizHtml($dataid);
        }
    }
    ?>


    <div id="game">

        <?php
        for ($i = 0; $i < $ni; $i++) {
            if ($i == 0) {
                echo '
                <div id="game0" class="none selectedDiv first"> 
                    ' . $html[$i] . '
                </div>
                ';
            } else if ($i > 0 && $i < $ni - 1) {
                echo '
                <div id="game' . $i . '" class="none"> 
                    ' . $html[$i] . '
                </div>
                ';
            } else {
                echo '
                <div id="game' . $i . '" class="none last"> 
                    ' . $html[$i] . '
                </div>
                ';
            }
        }
        ?>

    </div>

    <!--thông báo kết quả-->
    <div class="popup">
        <b class="popup_close">x</b>
        <div class="popup_result"></div>
    </div>
    <!--hướng dẫn chơi-->
    <div class="popup_hint">
        <b class="close_hint">x</b>
        <div class="popup_hint_data">

        </div>
    </div>
    <canvas id="my-canvas"></canvas>


    <script>
        var points = 0;
        var count = 0;

        function updatePoints() {
            $("#points-label").text(points.toString())

        }
    </script>

    <script src="animation.js"></script>

    <script>
        const steps = $("#game > div").length
        let currentStep = 0
        const $progressText = $('.progress-text')
        const $progressData = $('[data-progress]')

        $progressText.text(`${currentStep}/${steps}`)

        $('.btn').on('click', ({
            currentTarget
        }) => {
            const $button = $(currentTarget)
            const direction = $button.data('direction')
            const isNextStep = direction === 'next' && currentStep < steps
            const isPrevStep = direction === 'prev' && currentStep > 0

            if (isNextStep) currentStep++
            if (isPrevStep) currentStep--

            $progressData.animate({
                width: (currentStep / steps) * 100 + '%'
            }, 1000, () => {
                if (currentStep) {
                    $progressText.text(`${currentStep}/${steps}`).addClass('is-active')
                } else {
                    $progressText.text(`${currentStep}/${steps}`).removeClass('is-active')
                }

                if (currentStep && currentStep < steps) {
                    $button.siblings().prop('disabled', false)
                } else {
                    $button.prop('disabled', true)
                }
            })
        })
        $("#start").click(function() {
            $(".home").addClass("none");
            $("#game0").removeClass("none");
            $("#close").removeClass("none");
            $(".progress").removeClass("none");
            $(".buttons").removeClass("none");
            $(".btn_hint").removeClass("none");
            $(".score").removeClass("none");
            if ($('.first').css('display') == "block") {
                $(".prev").addClass("none");
            }
        })

        

        $(".prev").click(function() {
            var prevElement = $('.selectedDiv').prev();
            prevElement.removeClass("none");
            $(".selectedDiv").addClass("none");
            $(".selectedDiv").removeClass("selectedDiv");
            prevElement.addClass("selectedDiv");

            if ($('.first').css('display') == "block") {
                $(".prev").addClass("none");
            } else {
                $(".next").removeClass("none");
            }
        });

        $(".next").click(function() {
            var nextElement = $('.selectedDiv').next();
            nextElement.removeClass("none");
            $(".selectedDiv").addClass("none");
            $(".selectedDiv").removeClass("selectedDiv");
            nextElement.addClass("selectedDiv");
            if ($('.last').css('display') == "block") {
                $(".next").addClass("none");
            } else {
                $(".prev").removeClass("none");
            }
            if ($('.container_box').css('display') == "block") {
                $('.btn_hint').addClass("none");
            }
        });

        $("#close").click(function() {
            $(".home").removeClass("none");
            $("#game").children().addClass("none");
            $(".buttons").addClass("none");
            $(".progress").addClass("none");
            $("#start").addClass("none");
            $("#continue").removeClass("none");
            $(".btn_hint").addClass("none");
            $("#close").addClass("none");
            $(".score").addClass("none");

        })
        $("#continue").click(function() {
            $(".home").addClass("none");
            $(".selectedDiv").removeClass("none");
            $("#continue").addClass("none");

            $("#close").removeClass("none");
            $(".progress").removeClass("none");
            $(".buttons").removeClass("none");
            $(".score").removeClass("none");
            if (count < steps) {
                $(".btn_hint").removeClass("none");

            }
        })

        //them hint
        for (var i = 0; i < steps; i++) {
            $(".popup_hint_data").append('<div class="none hint' + i + '"><h2>Hướng dẫn</h2></div>')
        }
    </script>

    <?php
    //append hint: phải để đây nó mới chạy
    for ($i = 0; $i < $ni; $i++) {
        echo
        '<script>
        $(".hint' . $i . '").append("<p>' . $hint[$i] . '</p>")
        </script>';
    }

    ?>

    <script>
        $(".btn_hint").click(function() {

            for (var i = 0; i < steps; i++) {
                if ($('.selectedDiv').attr("id") == "game" + i) {
                    $(".hint" + i).removeClass("none");
                }
            }
            $(".popup_hint").addClass("active");
        })

        $(".close_hint").click(function() {
            $(".popup_hint").removeClass("active");
            $(".popup_hint_data").children().addClass("none");
        })

        let popup = document.querySelector(".popup")
        let btn_close = document.querySelector(".popup_close")
        let conf = document.querySelector("#my-canvas")


        btn_close.onclick = function() {
            popup.classList.remove("active")
            conf.classList.remove('active')

            count++;
            console.log(count);
            if (count == steps) {
                $(".next").removeClass("none");
                $('.last').removeClass('last');
                if (points <= 2) {
                    gift_text = "<?php echo $gift1 ?>";

                } else if (points <= 2 * steps / 2) {
                    gift_text = "<?php echo $gift2 ?>";
                } else {
                    gift_text = "<?php echo $gift3 ?>";
                }

                $("#game").append('<div class="container_box none last"><div class="row"><div class="col-12"><h3 class="text-center text-light my-5"></h3></div><div class="col-12 mt-5 d-flex justify-content-center"><div class="box"><div class="box-body"><p class="img_box">' + gift_text + '</p><div class="box-lid"><div class="box-bowtie"></div></div></div></div></div></div> </div>')


            }
        }
        var confettiSettings = {
            target: 'my-canvas'
        };
        var confetti = new ConfettiGenerator(confettiSettings);
        confetti.render();
    </script>

</body>

</html>