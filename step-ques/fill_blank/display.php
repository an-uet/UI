<?php
function displayGameHtml($dataid, $index) {
    $img = fetchItemData($dataid['id']);
    $url_full = $img['url_full'];
    $ext = strtoupper(pathinfo($url_full, PATHINFO_EXTENSION));
    $d = $img['desc'];

        $q = $dataid['question'];
        $k = $dataid['key'];
        $temp = "";
        if ($ext == 'GIF' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG' || $ext == 'TIF' || $ext == 'TIFF'){
            $temp = ' <div class="sec">
            <div class="display_container">
                <p class="display_section-title">Hãy xem nội dung sau và trả lời câu hỏi</p>
                <div class="display_content">
                    <div class="display_image">
                       <img src="'.$url_full.'">
                        <p>' . $d . '</p>
                    </div>
                    <div class="display_info">
                        <p class="display_question">' . $q . '</p>
                        <input id="display_input_answer" class="display_input_answer'.$index.'" type="text" placeholder="Đáp án của bạn">
                        <button class="display_submit_answer'.$index.'" id="display_submit_answer">Ghi nhận</button>
                        <div class="display_result'.$index.'" id="display_result"></div>
                    </div>
                </div>
            </div>
        </div>';
        }

        if ($ext == "YTB"){
            $vid = file_get_contents('https://hcloud.trealet.com' . $url_full);
            $temp = ' <div class="sec">
            <div class="display_container">
                <p class="display_section-title">Hãy xem nội dung sau và trả lời câu hỏi</p>
                <div class="display_content">
                    <div class="display_image">
                        <iframe width="700" height="394" src="https://www.youtube.com/embed/' . $vid . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <p>' . $d . '</p>
                    </div>
                    <div class="display_info">
                    <p class="display_question">' . $q . '</p>
                    <input id="display_input_answer" class="display_input_answer'.$index.'" type="text" placeholder="Đáp án của bạn">
                    <button class="display_submit_answer'.$index.'" id="display_submit_answer">Ghi nhận</button>
                    <div class="display_result'.$index.'" id="display_result"></div>
                    </div>
                </div>
            </div>
        </div>';
        };


        return $temp . '<script>
        $(".display_submit_answer'.$index.'").one("click", function(event) {
            key = "' . $k . '";
            if ($(".display_input_answer'.$index.'").val().toUpperCase() == key.toUpperCase()) {
                $(".display_input_answer'.$index.'").css({"color":"greenyellow"});
                $(".display_result'.$index.'").css({"color":"greenyellow"});
                $(".display_result'.$index.'").append("<p>Chính xác</p>")
                // ======================= Tăng điểm =========================
                points += 2;
                updatePoints();
                $(".popup_result").empty()
                $(".popup_result").css({"color":"#120972"});
                $(".popup_result").append("<div>Chúc mừng! Đáp án của bạn hoàn toàn chính xác.</div>")
                $(".popup").addClass("active");
                $("#my-canvas").addClass("active");
                $(".display_submit_answer'.$index.'").addClass("none");
            } else {
                $(".display_result'.$index.'").css({"color":"rgb(124, 15, 7)"})
                $(".display_result'.$index.'").append("<p>Không chính xác</p>")
                $(".popup_result").empty()
                $(".popup_result").css({"color":"rgb(124, 15, 7)"})
                    $(".popup_result").append("<div>Rất tiếc! Đáp án của bạn không chính xác. Đáp án chính xác là: ' . $k . '</div>")
                    $(".popup").addClass("active");
                    $(".display_submit_answer'.$index.'").addClass("none");
                    $(".display_input_answer'.$index.'").val(key);
                    $(".display_input_answer'.$index.'").css({"color":"rgb(124, 15, 7)"})
                    //$("#my-canvas").addClass("active");
            }
        }) 
        </script>';
                           
        
}
?>