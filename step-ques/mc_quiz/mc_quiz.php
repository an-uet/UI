<?php

function getImageUrl($imgId)
{
    $img = fetchItemData($imgId);
    return $img["url_full"];
}

function getAskHtml($question)
{
    $img = '';
    if ($question["ask"]["item"] != "") {
        $img = '<img src="' . getImageUrl($question["ask"]["item"]) . '" alt="image" class="img-style">';
    }
    return '
    <div class="row ask-container">
        <div class="ask-wrapper vertical">
            <p>' . $question["ask"]["text"] . '</p>'
            . $img . '
        </div>
    </div>';
}

function getOptionHtml($question)
{
    $html = '<div class="row options-container">';
    $options = $question["options"];
    foreach ($options as $option) {
        $img = '';
        if ($option["item"] != "") {
            $img = '<img src="' . getImageUrl($option["item"]) . '" alt="image" class="img-style">';
        }
        $optionHtml = '
        <div class="option-wrapper">
            <button class="option vertical" id="mc' . $option["id"] . '">
                <p>' . $option["text"] . '</p>
                ' . $img . '
            </button>
        </div>
        ';
        $html .= $optionHtml;
    }
    $html .= '</div>';
    return $html;
}


function mcQuizHtml($question)
{
    return '
    <div id="game_mc_quiz">' . getAskHtml($question) . getOptionHtml($question) . '
    <button type="submit" id="mc_submit" class="fill_blank__button">ghi nhận</button>
    </div>
    
    <script>
    const option_bg = "#f6eabe"
    const selected_option_bg = "#ffbf86"
    const right_option_bg = "green"
    const wrong_option_bg = "red"

    container = "#game_mc_quiz"
    let selected_option = null
    startGame()

    //--------------------------------------------START--------------------------------------------
    
    // Bắt đầu thực hiện các chức năng của game
    function startGame() {
        selected_option = null
        enableAllOptionView()
        $("#game_mc_quiz #mc_submit").show()
    }


    // ---------------------------------------- SELECT OPTION ------------------------------------------


    // Khi option được chọn
    function selectOptionView(id) {
        selected_option = id
        $("#" + id).css("background-color", selected_option_bg)
    }

    // Bỏ chọn tất cả các option
    function nonSelectAllOptionView() {
        selected_option = null
        $(".option").css("background-color", option_bg)
    }


    // Khi click vào 1 option
    $(document).on("click", ".option", function () {
        nonSelectAllOptionView()
        let id = $(this).attr("id")
        selectOptionView(id)
    })

    // Hiệu ứng chọn đúng 1 option
    function showRight(id) {
        $("#" + id).css("background-color", right_option_bg)
        $(".popup_result").empty() 
        $(".popup_result").css({"color":"#120972"});
        $(".popup_result").append("<div>Chúc mừng! Đáp án của bạn hoàn toàn chính xác.</div>")
        $(".popup").addClass("active");
        $("#my-canvas").addClass("active");

    }

    // Hiệu ứng khi chọn sai 1 option
    function showWrong(id) {
        $("#" + id).css("background-color", wrong_option_bg)
        $(".popup_result").empty()
        $(".popup_result").css({"color": "rgb(124, 15, 7)"});
        $(".popup_result").append("<div>Rất tiếc! Đáp án của bạn không chính xác.</div>")
        $(".popup").addClass("active");
        //$("#my-canvas").addClass("active");
    }

    // Vô hiệu hóa (không thể click các option) sau khi người chơi đã submit
    function disableAllOptionView() {
        $(".option").prop("disabled", true)
    }

    // Enable lại các option (có thể click chọn)
    function enableAllOptionView() {
        $(".option").removeAttr("disabled");
    }

    //------------------------------------------CHECK-------------------------------------

    // Kiểm tra xem 1 option có đúng không 
    function isAnswer(option_id) {
        return option_id == "mc'.$question["answer"].'"
    }
    
    // Kiểm tra tất cả các options: đúng, sai, thiếu, và trả về kết quả chơi: đúng hết hoặc không
    function check() {
        let correct = false
        if (isAnswer(selected_option)) {
            showRight(selected_option)
            correct = true
            // ======================= Tăng điểm =========================
            points += 2;
            updatePoints();
        } else {
            showWrong(selected_option)
            correct = false
        } 
        return correct
    }

    //--------------------------------------------SUBMIT BUTTON----------------------------------------------
    // Khi click submit button
    $(document).on("click", "#game_mc_quiz #mc_submit", function () {
        disableAllOptionView()
        let win = check()
        console.log(win)
        console.log("rồi nhá");
        $("#game_mc_quiz #mc_submit").hide()
    })
    </script>
    ';
}
?>