<?php
function whichFirstHtml($dataid, $index) {
    $temp = $dataid['options'];
            $image0 = fetchItemData($temp[0]['src']);
            $url0 = $image0['url_full'];
            $image1 = fetchItemData($temp[1]['src']);
            $url1 = $image1['url_full'];

            return '
            <div class="which_first">
                <div id="st1">
                    <div class="title">' . $dataid['question'] . '</div>
                    <div class="quiz_box">
                        <div>
                            <section id="section_'.$index.'"> 
                                <div class="image"><img class="wf_image_a'.$index.'" id ="img_a'.$index.'" src="' . $url0 . '"></div>
                                <div class="info">
                                    <span class="none">' . $temp[0]['time'] . '</span>
                                    <p>' . $temp[0]['desc'] . '</p> 
                                </div>
                            </section>
                        </div>
                        <div>
                            <section id="section_'.$index.'">
                                <div class="image"><img class="wf_image_b'.$index.'" id ="img_b'.$index.'" src=" ' . $url1 . ' "></div>
                                <div class="info">
                                    <span class="none">' . $temp[1]['time'] . ' </span>
                                    <p>' . $temp[1]['desc'] . '</p>
                                </div>
                            </section>
                        </div>
                    </div>
                    <span class="result" id="result'.$index.'"></span>
                </div>
            </div>
                        
            <script>
            $(".which_first #section_'.$index.' div img").one("click", function(event) {

                $(".info span").removeClass("none");
                $(".info span").addClass("after");
                if (' . $dataid['answer'] . ' == ' . $temp[0]['time'] . ' && $(this).attr("id") === "img_a'.$index.'" ) {
                    $("#result'.$index.'").css({"color":"greenyellow"});
                    $("#result'.$index.'").html("Chính xác");
                    $(".wf_image_b'.$index.'").addClass("noClick");
                    $(".wf_image_a'.$index.'").css("border", "5px solid green")
                    $(".wf_image_b'.$index.'").css("border", "5px solid red")
                    // ======================= Tăng điểm =========================
                    points += 2;
                    updatePoints();
                    
                    // ======================= Hiệu ứng ==========================
                    $(".popup_result").empty() 
                    $(".popup_result").css({"color":"#120972"});
                    $(".popup_result").append("<div>Chúc mừng! Đáp án của bạn hoàn toàn chính xác.</div>")
                    $(".popup").addClass("active");
                    $("#my-canvas").addClass("active");
                
                
                } else if (' . $dataid['answer'] . ' == ' . $temp[1]['time'] . ' && $(this).attr("id") === "img_b'.$index.'") {
                    $("#result'.$index.'").css({"color":"greenyellow"});
                    $("#result'.$index.'").html("Chính xác");
                    $(".wf_image_a'.$index.'").addClass("noClick");  
                    $(".wf_image_b'.$index.'").css("border", "5px solid green")
                    $(".wf_image_a'.$index.'").css("border", "5px solid red");
                    // ======================= Tăng điểm =========================
                    points += 2;
                    updatePoints();
                    
                    // ======================= Hiệu ứng ==========================
                    $(".popup_result").empty() 
                    $(".popup_result").css({"color":"#120972"});
                    $(".popup_result").append("<div>Chúc mừng! Đáp án của bạn hoàn toàn chính xác.</div>")
                    $(".popup").addClass("active");
                    $("#my-canvas").addClass("active");
                
                
                } else {
                    $("#result'.$index.'").css({"color":"#7a0b0b"});
                    $("#result'.$index.'").html("Không chính xác");
                    $(".wf_image_a'.$index.'").addClass("noClick");
                    $(".wf_image_b'.$index.'").addClass("noClick");
                    
                    // ======================= Hiệu ứng ==========================
                    $(".popup_result").empty()
                    $(".popup_result").css({"color":"rgb(124, 15, 7)"})
                    $(".popup_result").append("<div>Rất tiếc! Đáp án của bạn không chính xác.</div>")
                    $(".popup").addClass("active");
                    //$("#my-canvas").addClass("active");
                }
                
            });
            </script>
            ';
}
?>