function initGameStep(question, container) {
    showQuestion();

    function showQuestion() {
        let html = '';
        html += '<div class="align-center">' + '<h1 class="heading">Memory</h1>' + '<button class="btn" id="btn-start">' +
            'Start' + '</button>' + '<div class="cards-container">' + '<div class="flip-container hide" id="card-template">' + '<div class="flipper">' +
            '<div class="front">' + '<label></label>' + '</div>' + '<div class="back">' + '<label></label>' + '</div>' +
            '</div>' + '</div>' + '</div>' + '<div class="timer">' + '<label id="minutes"></label>:' + '<label id="seconds"></label>' +
            '<div class="time">' + 'MY BEST TIME: <span id="bestTime"></span>' + '</div>' + '</div>' + '</div>'
        $(container).append(html);
    }
    var BRAINYMO = BRAINYMO || {};
    BRAINYMO.Game = (function() {
        var activeCards = [];
        var numOfCards;
        var cardHitCounter = 0;
        var card;
        var timer;
        var storage;
        // Creat sounds
        var correctSound = document.createElement('audio');
        correctSound.setAttribute('src', 'http://www.orangefreesounds.com/wp-content/uploads/2017/06/Ting-sound-effect.mp3');

        //var errorSound = document.createElement('audio');
        //errorSound.setAttribute('src', 'http://soundbible.com/mp3/Buzz-SoundBible.com-1790490578.mp3');

        function handleCardClick() {

            var connection = $(this).data('connection');
            var hit;
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
                activeCards.push($(this));


                if (activeCards.length == 2) {
                    hit = checkActiveCards(activeCards);
                }

                if (hit === true) {
                    correctSound.play();
                    cardHitCounter++;
                    activeCards[0].add(activeCards[1]).unbind().addClass('wobble cursor-default');
                    activeCards = [];
                    // Game End
                    if (cardHitCounter === (numOfCards / 2)) {
                        // Reset active cards
                        activeCards = [];
                        // Reset counter
                        cardHitCounter = 0;
                        // End game
                        endGame();
                    }
                } else {
                    // errorSound.play();
                    if (activeCards.length === 3) {
                        for (var i = 0; i < activeCards.length - 1; i++) {
                            activeCards[i].removeClass('active');
                        }
                        activeCards.splice(0, 2);
                    }
                }
            }
        }

        function endGame() {
            timer.stopTimer();
            var time = timer.retrieveTime();
            var timeFromStorage = storage.retrieveBestTime();

            if (timeFromStorage != undefined && timeFromStorage != '') {
                if (time.minutes < timeFromStorage.minutes || (time.minutes == timeFromStorage.minutes && time.seconds < timeFromStorage.seconds)) {
                    storage.setBestTime(time);
                }
            } else {
                storage.setBestTime(time);
            }

            timer.updateBestTime();
        }

        function checkActiveCards(connections) {
            return connections[0].data('connection') === connections[1].data('connection');
        }

        return function(config) {

            this.startGame = function() {
                card = new BRAINYMO.Card();
                timer = new BRAINYMO.Timer();
                storage = new BRAINYMO.Storage();
                numOfCards = config.cards.length;
                card.attachCardEvent(handleCardClick, config);
            };

            this.generateCardSet = function() {
                card.generateCards(config.cards);
                activeCards = [];

                timer.stopTimer();
                timer.startTimer();
            };
            this.startGame();
        }

    })();

    BRAINYMO.Card = (function() {

        var $cardsContainer = $('.cards-container');
        var $cardTemplate = $('#card-template');

        function prepareCardTemplate(card) {
            var template = $cardTemplate
                .clone()
                .removeAttr('id')
                .removeClass('hide')
                .attr('data-connection', card.connectionID);

            if (card.backImg != '' && card.backImg != undefined) {
                template.find('.back').css({
                    'background': 'url(' + card.backImg + ') no-repeat center center',
                    'background-size': 'cover'
                });
            } else if (card.backTxt != '' && card.backTxt != undefined) {
                template.find('.back > label').html(card.backTxt);
            }
            return template;
        }

        function shuffleCards(cardsArray) {
            var currentIndex = cardsArray.length,
                temporaryValue, randomIndex;

            while (0 !== currentIndex) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;
                temporaryValue = cardsArray[currentIndex];
                cardsArray[currentIndex] = cardsArray[randomIndex];
                cardsArray[randomIndex] = temporaryValue;
            }
            return cardsArray;
        }

        return function() {
            this.generateCards = function(cards) {
                var templates = [];
                var preparedTemplate;

                cards.forEach(function(card) {
                    preparedTemplate = prepareCardTemplate(card);
                    templates.push(preparedTemplate);
                });

                templates = shuffleCards(templates);

                $cardsContainer.hide().empty();

                templates.forEach(function(card) {
                    $cardsContainer.append(card);
                });

                $cardsContainer.fadeIn('slow');
            };

            this.attachCardEvent = function(func) {
                $cardsContainer.unbind().on('click', '.flip-container', function() {
                    func.call(this);
                });
            }
        }

    })();

    BRAINYMO.Timer = (function() {

        var $timer = $('.timer');
        var $seconds = $timer.find('#seconds');
        var $minutes = $timer.find('#minutes');
        var $bestTimeContainer = $timer.find('.time');


        var minutes, seconds;

        function decorateNumber(value) {
            return value > 9 ? value : '0' + value;
        }

        return function() {
            var interval;
            var storage = new BRAINYMO.Storage();

            this.startTimer = function() {
                var sec = 0;
                var bestTime;

                interval = setInterval(function() {
                    seconds = ++sec % 60;
                    minutes = parseInt(sec / 60, 10);
                    $seconds.html(decorateNumber(seconds));
                    $minutes.html(decorateNumber(minutes));
                }, 1000);

                $timer.delay(1000).fadeIn();

                this.updateBestTime();
            };

            this.updateBestTime = function() {
                bestTime = storage.retrieveBestTime();
                if (bestTime != undefined && bestTime != '') {
                    $bestTimeContainer
                        .find('#bestTime')
                        .text(bestTime.minutes + ':' + bestTime.seconds)
                        .end()
                        .fadeIn();
                }
            };
            this.stopTimer = function() {
                clearInterval(interval);
            };

            this.retrieveTime = function() {
                return {
                    minutes: decorateNumber(minutes),
                    seconds: decorateNumber(seconds)
                }
            };
        }
    })();

    BRAINYMO.Storage = (function() {

        return function() {
            this.setBestTime = function(time) {
                localStorage.setItem('bestTime', JSON.stringify(time));
            };
            this.retrieveBestTime = function() {
                return JSON.parse(localStorage.getItem('bestTime'));
            };

        }
    })();

    // Game init
    $(function() {
        var brainymo = new BRAINYMO.Game(question);

        $('#btn-start').click(function() {
            brainymo.generateCardSet();
            $(this).text('Restart');
        });

    });

}