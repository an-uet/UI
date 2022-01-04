<?php
function fillBlankHtml($question, $index) {
    $isentence = $question['sentence'];
    $ikey = $question['key'];
    $key = $question['key'];
    $start_blank = strpos($isentence, $ikey);
    $img =  fetchItemData($question['image']);
    $url = $img['url_full'];

    return '
            <div class="fill_blank">
                <div class="fill_blank_wrp swiper-wrapper">
                    <div class="fill_blank_item swiper-slide">
                        <div class="fill_blank_img">
                            <img src="' . $url . '" alt="">
                        </div>
                        <div class="fill_blank_content">
                            <div class="fill_blank_title">Điền vào chỗ trống</div>
                            <div class="fill_blank_text">
                                <div>' . substr($isentence, 0, $start_blank)
                                    . '<input type="text" class="fill_blank_mask" id="fill_blank_mask'.$index.'">'
                                    . substr($isentence, $start_blank + strlen($ikey), strlen($isentence)) 
                                . '</div>
                            </div>
                            <a href="#" class="fill_blank__button fill_blank_id'.$index.'" id="fill_blank_id">Ghi nhận</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            
            $(".fill_blank_id'.$index.'").one("click", function() {
                var key = "'.$key.'"
                var k = key.replace(/\s/g, "");
                var mask = $("#fill_blank_mask'.$index.'").val().replace(/\s/g, "");
                if (mask.toUpperCase() === k.toUpperCase()) {
                    let pass = document.createElement("div")
                    pass.append("Chúc mừng bạn, câu trả lời hoàn toàn chính xác.")
                    pass.style.fontSize = "20px";
                    pass.style.color = "greenyellow";
                    
                   
                    $(".popup_result").empty()
                    $(".popup_result").css({"color":"#120972"});
                    $(".popup_result").append("<div>Chúc mừng! Đáp án của bạn hoàn toàn chính xác.</div>")
                    $("#fill_blank_mask'.$index.'").css({"color":"greenyellow"});
                    $("#fill_blank_mask'.$index.'").val("'.$key.'");
                    $(".fill_blank_id'.$index.'").addClass("none")
                    // ======================= Tăng điểm =========================
                    points += 2;
                    updatePoints();

                    $(".popup").addClass("active");
                    $("#my-canvas").addClass("active");
                } else {
                    let fail = document.createElement("div")
                    fail.append("Tiếc quá đáp án của bạn không chính xác")
                    fail.append(document.createElement("br"))
                    fail.append("Đáp án chính xác là: '.$key.'")
                    fail.style.fontSize = "20px";
                    fail.style.color = "rgb(124, 15, 7)";
                   
                    $(".popup_result").empty()
                    $(".popup_result").css({"color":"rgb(124, 15, 7)"})
                    $(".popup_result").append("<div>Rất tiếc! Đáp án của bạn không chính xác. Đáp án chính xác là: ' . $key . '</div>")
                    $(".popup").addClass("active");
                    //$("#my-canvas").addClass("active");
                    $("#fill_blank_mask'.$index.'").css({"color":"rgb(124, 15, 7)"})
                    $("#fill_blank_mask'.$index.'").val("'.$key.'");
                    $(".fill_blank_id'.$index.'").addClass("none")
                }
            })
            
            </script>
            ';
}
?>