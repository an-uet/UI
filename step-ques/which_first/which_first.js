function initGameWhichCameFirst(question, container) {
    showQuestion();

    function showQuestion() {
        let temp = question.options;
        let html = '';
        html += '<div id="st1 ">' + '<div class="title ">Sự kiện nào diễn ra trước?</div>' +
            '<div class="quiz_box ">' +
            '<div>' +
            '<section>' +
            '<div class="image">' + '<img id ="img0 " src=" ' + temp[0].src + ' ">' + '</div>' +
            ' <div class="info ">' +
            '<span class="none ">' + temp[0].time + '</span>' +
            '<p>' + temp[0].desc + '</p>' +
            '</div>' +
            '</section>' +
            '</div>' +
            '<div>' +
            '<section>' +
            '<div class="image">' + '<img id ="img1 " src=" ' + temp[1].src + ' ">' + '</div>' +
            ' <div class="info ">' +
            '<span class="none ">' + temp[1].time + '</span>' +
            '<p>' + temp[1].desc + '</p>' +
            '</div>' +
            '</section>' +
            '</div>' +
            '</div>' +
            '<span class="result "></span>' +
            '</div>'
        $(container).append(html);
    }

    //show result
    $('section div img').one("click", function(event) {
        let temp = question.options;
        $('.info span').removeClass('none');
        $('.info span').addClass('after');
        if (question.answer == temp[0].time && $(this).attr("id") === "img0 ") {
            $(".result").html("");
            $(".result").html('Chính xác');

        } else if (question.answer == temp[1].time && $(this).attr("id") === "img1 ") {
            $(".result").html("");
            $(".result").html('Chính xác');

        } else {
            $(".result").removeData();
            $(".result").html("");
            $(".result").html("Sai")
        }

    });

}