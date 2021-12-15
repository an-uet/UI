function initGameFillBlank(question, container) {
    play()

    //game huyen
    function play() {
        let sentence = question.sentence
        let key = question.key
        let index_key = sentence.search(key)
        let blog = '<div class="blog ">' + sentence.slice(0, index_key) + '<input type="text " class="mask ">' + sentence.slice(index_key + key.length, sentence.length) + '</div>'
        $(container).append(blog)
        $('.mask').change(function() {
            let result_pass = $('.pass')
            let result_fail = $('.fail')
            $('.pass').remove()
            $('.fail').remove()
    
            if ($('.mask').val().toUpperCase() === key.toUpperCase()) {
                let pass = '<div class="pass ">Chúc mừng bạn, câu trả lời hoàn toàn chính xác, bạn giỏi quá</div>'
                $(container).append(pass)
            } else {
                let fail = '<div class="fail ">Tiếc quá bạn sai rồi</div>'
                $(container).append(fail)
            }
        })
    }
}