const option_bg = "linear-gradient(to top right, rgb(255, 225, 225), rgb(186, 255, 180))"
const selected_option_bg = "linear-gradient(to top right, #ffbbcc, #c1a1d3)"
const right_option_bg = "linear-gradient(to top right, #81fbb8, #28c76f)"
const wrong_option_bg = "linear-gradient(to top right, #c10202, #c10000)"
const inadequate_option_bg = "linear-gradient(to top right, #fdeb71, #f8d800)"

function initGameMultipleChoices(question, container) {

    let selected_options = new Set()
    startGameHtml()
    startGame()

    //--------------------------------------------START--------------------------------------------
    // Tạo khung html cho game trong <div id:"game"> 
    function startGameHtml() {
        $(container).empty()
        let question_contain_html = $(document.createElement('div')).prop({
            class: "vertical",
            id: "question-frame"
        })
        let ask_contain_html = $(document.createElement('div')).prop({
            class: "vertical",
            id: "ask"
        })
        let options_contain_html = $(document.createElement('div')).prop({
            class: "horizontal center",
            id: "options-container"
        })
        question_contain_html.append(ask_contain_html, options_contain_html)
        let submit_btn_html = $(document.createElement('button')).prop({
            type: "submit",
            id: "submit"
        })
        submit_btn_html.append("Submit")
        $(container).append(question_contain_html, submit_btn_html)
    }

    // Bắt đầu thực hiện các chức năng của game
    function startGame() {
        selected_options.clear()
        showQuestion()
        enableAllOptionView()
        $('#submit').show()
    }

    // -------------------------------------------SHOW QUESTION-------------------------------------------
    // Hiện game
    function showQuestion() {
        showAsk(question.ask)
        if (question.answer.length == 1) {
            showOptions(question.options)
        } else {
            showCheckboxOptions(question.options)
        }
        setSameWidth(getMaxWidth('.option'), '.option') 
    }
    
    // Hiện câu hỏi
    function showAsk(ask) {
        $('#ask').empty()
        $('#ask').append(getAskHtml(ask))
    }
    
    // Hiện các options để chọn (chỉ được chọn 1 option)
    function showOptions(options) {
        $('#options-container').empty()
        for (let option of options) {
            $('#options-container').append(getOptionHtml(option))
        }
    }
    
    // Hiện các options để chọn (được chọn nhiều options - checkbox)
    function showCheckboxOptions(options) {
        $('#options-container').empty()
        for (let option of options) {
            $('#options-container').append(getCheckboxOptionHtml(option))
        }
    }
    
    // Lấy đoạn code html cho 1 option (loại chỉ được chọn 1)
    function getOptionHtml(option) {
        let html = ''
        html += '<button class="option vertical" id="' + option.id + '">'
        html += '<p>'
        html += option.text
        html += '</p>'
        html += '</button>'
        return html
    }
    
    // Lấy đoạn code html cho 1 option (loại được chọn nhiều - checkbox)
    function getCheckboxOptionHtml(option) {
        let html = ''
        html += '<button class="option horizontal left" id="' + option.id + '">'
        html += '<input type="checkbox">'
        html += '<p>'
        html += option.text
        html += '</p>'
        html += '</button>'
        return html
    }
    
    // Lấy đoạn code html cho 1 câu hỏi
    function getAskHtml(ask) {
        let html = ''
        html += '<p>'
        html += ask.text
        html += '</p>'
        return html
    }

    // Set các đối tượng có class = classname chung 1 chiều rộng width
    function setSameWidth(width, class_name) {
        $(class_name).width(width)
    }

    // Lấy độ rộng lớn nhất của các đối tượng có class = classname
    function getMaxWidth(class_name) {
        let maxWidth = 0
        $(class_name).each(function () {
            if ($(this).width() > maxWidth) {
                maxWidth = $(this).width()
            }
        })
        maxWidth += 10
        return maxWidth
    }

    // ---------------------------------------- SELECT OPTION ------------------------------------------

    // Làm rỗng danh sách các options đã chọn (để cho màn tiếp theo, game mới,...)
    function clearSelectedOptions() {
        selected_options.clear()
    }

    // Thêm vào danh sách các option đã chọn (để check khi người chơi submit)
    function addToSelectedOptions(opt_id) {
        for (let id of selected_options) {
            if (opt_id === id) {
                return;
            }
        }
        selected_options.add(opt_id)
    }

    // Loại option khỏi dánh sách các options đã chọn (khi người dùng bỏ chọn 1 option)
    function removeFromSelectedOptions(opt_id) {
        selected_options.delete(opt_id)
    }

    // Khi option được chọn
    function selectOptionView(id) {
        nonSelectAllOptionView()
        addToSelectedOptions(id)
        $('#' + id).css("background-image", selected_option_bg)
    }

    // Khi option không được chọn nữa
    function nonSelectOptionView(id) {
        removeFromSelectedOptions(id)
        $('#' + id).css("background-image", option_bg)
    }

    // Bỏ chọn tất cả các option
    function nonSelectAllOptionView() {
        clearSelectedOptions()
        $('.option').css("background-image", option_bg)
    }

    // Khi option-checkbox được chọn
    function selectCheckboxOptionView(id) {
        addToSelectedOptions(id)
        $('#' + id).find('input').prop('checked', true)
        $('#' + id).css("background-image", selected_option_bg)
    }

    // Khi 1 option checkbox bị bỏ chọn
    function nonSelectCheckboxOptionView(id) {
        removeFromSelectedOptions(id)
        $('#' + id).find('input').prop('checked', false)
        $('#' + id).css("background-image", option_bg)
    }

    // Bỏ chọn tất cả các option checkbox
    function nonSelectAllCheckboxOptionView() {
        clearSelectedOptions()
        $('.option input').prop('checked', false)
        $('.option').css("background-image", option_bg)
    }

    // Khi click vào 1 option
    $(document).on('click', '.option', function () {
        let id = $(this).attr('id')
        if (question.answer.length == 1) {
            selectOptionView(id)
        } else {
            if ($(this).find('input').is(':checked')) {
                nonSelectCheckboxOptionView(id)
                console.log('non-select checkbox')
            } else {
                selectCheckboxOptionView(id)
                console.log('select checkbox')
            }
        }
    })

    // Hiệu ứng chọn đúng 1 option
    function showRight(id) {
        $('#' + id).css("background-image", right_option_bg)
    }

    // Hiệu ứng khi chọn sai 1 option
    function showWrong(id) {
        $('#' + id).css("background-image", wrong_option_bg)
    }

    // Hiệu ứng đối với option bị chọn thiếu
    function showInadequate(id) {
        $('#' + id).css("background-image", inadequate_option_bg)
    }

    // Vô hiệu hóa (không thể click các option) sau khi người chơi đã submit
    function disableAllOptionView() {
        $('.option').prop('disabled', true)
        $('.option input').prop('disabled', true)
    }

    // Enable lại các option (có thể click chọn)
    function enableAllOptionView() {
        $('.option').removeAttr("disabled");
        $('.option input').removeAttr("disabled");
    }

    //------------------------------------------CHECK-------------------------------------
    // Kiểm tra xem 1 option có được chọn không
    function isSelectedOption(id) {
        return selected_options.has(id)
    }

    // Kiểm tra xem 1 option có đúng không (nằm trong danh sách answer)
    function isAnswer(answer, option_id) {
        for (let id of answer) {
            if (option_id === id) {
                return true
            }
        }
        return false
    }
    
    // Kiểm tra tất cả các options: đúng, sai, thiếu, và trả về kết quả chơi: đúng hết hoặc không
    function checkAllOptions(answer) {
        let correct = false
        let all_options = $('.option').map(function() {
            return $(this).attr('id');
        });
        for (let id in all_options) {
            if (isSelectedOption(id)) {
                if (isAnswer(answer, id)) {
                    showRight(id)
                    correct = true
                } else {
                    showWrong(id)
                    correct = false
                }
            } else {
                if (isAnswer(answer, id)) {
                    showInadequate(id)
                    correct = false
                }
            }
        }
        return correct
    }

    //--------------------------------------------SUBMIT BUTTON----------------------------------------------
    // Khi click submit button
    $(document).on('click', '#submit', function () {
        disableAllOptionView()
        let win = checkAllOptions(question.answer)
        console.log(win)
        $('#submit').hide()
    })

}

