function initGameMatching(question, container) {
    loadGameHtml()
    showQuestion()
    startGame()

    // Nội dung file html
    function loadGameHtml() {
        let html = '';
        html += '<header class="question-header">' + '<h1>DRAG AND DROP GAME</h1>' +
            '</header>' + '<section class="question-body">' + '<table class="table">' + '<thead class="header">' + '<tr>' + '<th class="keywords">Key word</th>' +
            '<th class="answers">Answers</th>' + '<th class="options">Options</th>' + '</tr>' + '</thead>' +
            '<tbody class="body">' + '</tbody>' + '</table>' + '</section>' + '<footer class="question-footer">' +
            '<div class="score-card"></div>' + '<div class="buttons">' + '<button class="reset-btn">Reset</button>' + '<button class="check-answer">Check answer</button>' +
            '</div>' + '</footer>'
        $(container).append(html);
    }

    function showQuestion() {
        for (let option of question.list) {
            var tblRow = "<tr>" + "<td class='keyword'>" + "<div>" + "<img src = '" + option.time + "'" + "style='width:146px;height:102px;'>" + "</div>" + "</td>" +
                "<td class='answer'>" + "</td>" + "<td class='option'>" + "<div class='card'>" + option.description + "</div>" + "</td>" + "</tr>"
            $("tbody").append(tblRow);

        }
    }

    function startGame() {

        // Set the initial score to zero...
        var score = 0;
        var answers = [
            "Làng Hậu Kiên, xã Triệu Thành, huyện Triệu Phong, tỉnh Quảng Trị - nơi gắn bó với tuổi thơ đồng chí Lê Văn Nhuận (tức Lê Duẩn)",
            "Ga Hàng cỏ những năm 1927-1930 - nơi đồng chí Lê Duẩn làm thư ký Sở Hỏa xa Đông Dương năm 1928.",
            "Nhà tù Hỏa Lò, Sơn La - nơi giam giữ đồng chí Lê Duẩn cùng nhiều đồng chí cách mạng những năm 1931-1936.",
            "Đồng chí Lê Duẩn và các vị lãnh đạo Đảng, Nhà nước trên lễ đài mừng chiến thắng của nhân dân Thủ đô Hà Nội (7/5/1975).",
            "Tổng Bí thư Lê Duẩn và gia đình trong ngày sinh nhật lần thứ 78, Hà Nội tháng 4 năm 1985."
        ];
        console.log(question.list.length)

        var tableDefault = $(".table").html();


        function dragAndDrop(dragTarget, dropTarget) {
            $(dragTarget).draggable({ revert: true });
            $(dropTarget).droppable({
                drop: function(event, ui) {
                    $(this).append(ui.draggable);
                    ui.draggable.css({
                        position: "static",
                        top: "auto",
                        left: "auto"
                    });
                    ui.draggable.css({
                        position: "relative"
                    });
                }
            });
        }

        dragAndDrop(".card", ".answer");
        dragAndDrop(".card", ".option");

        $(".check-answer").on("click", function() {

            $(".answer").each(function(i) {


                var answer = answers[i];

                var guess = $(this).find("div").text();

                if (guess === answer) {
                    score++;
                    $(this).css("background", "#2ecc71");
                } else {
                    $(this).css("background", "#e74c3c");
                }
            });

            $(".score-card").html("<p style ='background-color:#CCC8C8;width: 150px;height: 60px; text-align: center;padding-top: 15px;margin-top:10px;'>Score: " + score + "/5</p>");

            $(".reset-btn").css("display", "flex");
            $(".check-answer").css("display", "none");
        });

        $(".reset-btn").on("click", function() {

            $(".table").html(tableDefault);

            dragAndDrop(".card", ".answer");
            dragAndDrop(".card", ".option");

            $(".reset-btn").css("display", "none");
            $(".check-answer").css("display", "flex");

            $(".score-card").html("");

            score = 0;
        });
    }
}