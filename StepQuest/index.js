var data = {
    "sentence": "Lê Duẩn tên thật là Lê Văn Nhuận, sinh ngày 7 tháng 4 năm 1907, tại làng Bích La, xã Triệu Đông (nay thuộc xã Triệu Thành), huyện Triệu Phong, tỉnh Quảng Trị",
    "key": "Lê Văn Nhuận"
}
$(document).ready(function() {

    $("#step-1 ").click(function() {
        //hiện button exit 
        $("#exit ").removeClass("none");
        //ẩn button step1.
        $(".progress ").addClass("none");
        $.getJSON('questions.json', function(data) {
            $.each(data.quiz, function(i, f) {
                var temp = f.options;
                var html = '';
                html += '<div id="st1 ">' + '<div class="title ">Sự kiện nào diễn ra trước?</div>' +
                    '<div class="quiz_box ">' +
                    '<div>' +
                    '<section>' +
                    '<div>' + '<img id ="img0 " src=" ' + temp[0].src + ' ">' + '</div>' +
                    ' <div class="info ">' +
                    '<span class="none ">' + temp[0].time + '</span>' +
                    '<p>' + temp[0].desc + '</p>' +
                    '</div>' +
                    '</section>' +
                    '</div>' +
                    '<div>' +
                    '<section>' +
                    '<div>' + '<img id ="img1 " src=" ' + temp[1].src + ' ">' + '</div>' +
                    ' <div class="info ">' +
                    '<span class="none ">' + temp[1].time + '</span>' +
                    '<p>' + temp[1].desc + '</p>' +
                    '</div>' +
                    '</section>' +
                    '</div>' +
                    '</div>' +
                    '<span class="result "></span>' +
                    '</div>'
                $("#game1 ").append(html);

                //show result
                $('img').one("click", function(event) {
                    $('.info span').removeClass('none');
                    $('.info span').addClass('after');
                    if (f.answer == temp[0].time && $(this).attr("id") == "img0") {
                        $(".result").html("");
                        $(".result").html('Chính xác');

                    } else if (f.answer == temp[1].time && $(this).attr("id") == "img1") {
                        $(".result").html("");
                        $(".result").html('Chính xác');

                    } else {
                        $(".result").removeData();
                        $(".result").html("");
                        $(".result").html("Sai")
                    }

                });


            });

            exit('#game1');
        });

    });


    //start game huyen
    $("#step-2 ").click(function() {
        $('#game2').addClass('display_game2')
            //hiện button exit 
        $("#exit ").removeClass("none ");
        //ẩn button step1.
        $(".progress ").addClass("none ");
        play(data.sentence, data.key);
        exit('#game2');

    });
});


//game huyen
function play(sentence, key) {
    var index_key = sentence.search(key)
    var blog = '<div class="blog ">' + sentence.slice(0, index_key) + '<input type="text " class="mask ">' + sentence.slice(index_key + key.length, sentence.length) + '</div>'
    $('#game2').append(blog)
    $('.mask').change(function() {
        var result_pass = $('.pass')
        var result_fail = $('.fail')
        $('.pass').remove()
        $('.fail').remove()

        if ($('.mask').val().toUpperCase() === key.toUpperCase()) {
            var pass = '<div class="pass ">Chúc mừng bạn, câu trả lời hoàn toàn chính xác, bạn giỏi quá</div>'
            $('#game2').append(pass)
        } else {
            var fail = '<div class="fail ">Tiếc quá bạn sai rồi</div>'
            $('#game2').append(fail)
        }
    })
}

//exit man choi
function exit(game_id) {
    $("#exit").click(function() {
        $(game_id).html(" ");
        $(".progress ").removeClass("none ");
        $("#exit ").addClass("none ")
        $('#game2').removeClass('display_game2')


    });

}