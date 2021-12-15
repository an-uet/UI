$(document).ready(function() {
   // exitGame()

    $('#step-3').click(function() {
        initGame(data, 0)
    })

    $('#step-2').click(function() {
        initGame(data, 1);
    })

    $('#step-1').click(function() {
        initGame(data, 2)
    })

    $('#step-4').click(function() {
        initGame(data, 3)
    })

    $('#step-5').click(function() {
        initGame(data, 4)
    })

    function initGame(data, i) {
        hideHome()
        if (data[i].type == "fill_blank") {
            setGameClass("fill_blank")
            initGameFillBlank(data[i], '#game')

        } else if (data[i].type == "which_first") {
            setGameClass("which_first")
            initGameWhichCameFirst(data[i], '#game')

        } else if (data[i].type == "mc_quiz") {
            setGameClass("mc_quiz")
            initGameMultipleChoices(data[i], '#game')

        } else if (data[i].type == "matching") {
            setGameClass("matching")
            initGameMatching(data[i], '#game')
        } else if (data[i].type == "step") {
            setGameClass("step")
            initGameStep(data[i], '#game')
        }

    }

    $('#exit').click(function() {
        exitGame()
    })

    function exitGame() {
        $('#game').empty()
        showHome()
    }

    function setGameClass(type) {
        $('#game').removeClass()
        $('#game').addClass(type)
    }

    function showHome() {
        $(".home ").removeClass("none ");
        $('#exit').addClass("none")
    }

    function hideHome() {
        $(".home ").addClass("none ");
        $('#exit').removeClass("none")
    }
})