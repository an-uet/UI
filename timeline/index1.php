<?php
require_once('../lib/functions.php');

$d = initializeApp('timeline');
$ni = sizeof($d['items']);
$iu = array($ni);
?>

<!DOCTYPE HTML>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php echo $d['title']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
  <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
  <div class="timeline-container" id="timeline-1">
    <div class="timeline-header">
      <div id="logo">
        <h2 class="timeline-header__title"><?php echo $d['title']; ?></h2>
        <h3 class="timeline-header__subtitle"><?php echo $d['desc']; ?></h3>
      </div>
    </div>

    <div class="timeline">
      <?php
      $html = '';
      for ($i = 0; $i < $ni; $i++) {
        $itemid = $d['items'][$i];
        $itime = $itemid['time'];
        $idesc = $itemid['idesc'];
        $idata   = fetchItemData($itemid['image']);
        echo htmlItem('', 1, '', $idata, $itime, 'timeline-item', 'timeline__content', 'timeline__img', 'timeline__content-title', 'timeline__content-desc', $i, $idesc);
        for ($j = 0; $j < sizeof($itemid['more']); $j++) {
          $more = $itemid['more'][$j];
          $more_data = fetchItemData($more);
          $url_full = $more_data['url_full'];
          $desc = $more_data['desc'];
          $ext = strtoupper(pathinfo($url_full, PATHINFO_EXTENSION));
          $vid = file_get_contents('https://hcloud.trealet.com' . $url_full);

          if ($ext == "YTB" || $ext=='GLB') {
            $html .= '<a href="https://www.youtube.com/embed/' . $vid . '" data-fancybox="' . $i . '" data-caption="' . $desc . '"></a>';
          } 
          else if($ext=='MP4') {
            $html .= '<div style="display:none"><a href="' . $url_full . '" data-fancybox="' . $i . '" data-caption="' . $desc . '">
                        <img class="rounded" src= "../lib/iconmp4.jpg">
                        </a></div>';
          }
          else {
            $html .= '<div style="display:none"><a href="' . $url_full . '" data-fancybox="' . $i . '" data-caption="' . $desc . '">
                        <img class="rounded" src= "' . $url_full . '">
                        </a></div>';
          }
        }
      }

      ?>
    </div>
  </div>
  <?php echo $html; ?>
  <a href="">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

  <script>
    (function($) {
      $.fn.timeline = function() {
        var selectors = {
          id: $(this),
          item: $(this).find(".timeline-item"),
          activeClass: "timeline-item--active",
          img: ".timeline__img"
        };
        
        var itemLength = selectors.item.length;
        $(window).scroll(function() {
          var max, min;
          var pos = $(this).scrollTop();
          selectors.item.each(function(i) {
            min = $(this).offset().top;
            max = $(this).height() + $(this).offset().top;
            var that = $(this);
            if (i == itemLength - 2 && pos > min + $(this).height() / 2) {
              selectors.item.removeClass(selectors.activeClass);
              
              selectors.item.last().addClass(selectors.activeClass);
            } else if (pos <= max - 0 && pos >= min) {
              
              selectors.item.removeClass(selectors.activeClass);
              $(this).addClass(selectors.activeClass);
            }
          });
        });
      };
    })(jQuery);

    $("#timeline-1").timeline();
  </script>



  <script>
    //set color to trealet.
    $('.timeline-container').css('background-color', '<?php echo $d['bgcolor']; ?>') //set background-color
    $('.timeline-header__title,.timeline-header__subtitle, .timeline__content-desc, .timeline__content-title, .timeline-item').css('color', '<?php echo $d['color']; ?>') //set text color.
  </script>

  <script>
    /*
    Fancybox.bind("[data-fancybox]", {
      placeFocusBack: false,
    });

    $('[data-fancybox]').fancybox({
    type : 'iframe',
    iframe : {
        scrolling : 'no',
        hideScrollbar: true,
        preload: false,
    }
})*/
  </script>
  <script>
    Fancybox.bind('[data-fancybox="gallery"]', {
    dragToClose: false,
/*
  Toolbar: false,
  closeButton: "top",

  Image: {
    zoom: true,
  },

  on: {
    initCarousel: (fancybox) => {
      const slide = fancybox.Carousel.slides[fancybox.Carousel.page];

      fancybox.$container.style.setProperty(
        "--bg-image",
        `url("${slide.$thumb.src}")`
      );
    },
    "Carousel.change": (fancybox, carousel, to, from) => {
      const slide = carousel.slides[to];

      fancybox.$container.style.setProperty(
        "--bg-image",
        `url("${slide.$thumb.src}")`
      );
    },
  },*/
});
  </script>

</body>

</html>