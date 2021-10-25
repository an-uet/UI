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
        $idata   = fetchItemData($itemid['image']);
        echo htmlItem('', 1, '', $idata, $itime, 'timeline-item', 'timeline__content', 'timeline__img', 'timeline__content-title', 'timeline__content-desc', $i);
        for ($j = 0; $j < sizeof($itemid['more']); $j++) {
          $more = $itemid['more'][$j];
          $more_data = fetchItemData($more);
          // echo showMoreInformation($more_data, $i);
          $url_full = $more_data['url_full'];
          $desc = $more_data['desc'];
          $html .= '<a href="' . $url_full . '" data-fancybox="' . $i . '" data-caption="' . $desc . '">';
        } 
      }

      ?>
    </div>
  </div>
  <?php echo $html;?>

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
        selectors.item.eq(0).addClass(selectors.activeClass);
        selectors.id.css(
          "background-image",
          "url(" +
          selectors.item
          .first()
          .find(selectors.img)
          .attr("src") +
          ")"
        );
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
              selectors.id.css(
                "background-image",
                "url(" +
                selectors.item
                .last()
                .find(selectors.img)
                .attr("src") +
                ")"
              );
              selectors.item.last().addClass(selectors.activeClass);
            } else if (pos <= max - 40 && pos >= min) {
              selectors.id.css(
                "background-image",
                "url(" +
                $(this)
                .find(selectors.img)
                .attr("src") +
                ")"
              );
              selectors.item.removeClass(selectors.activeClass);
              $(this).addClass(selectors.activeClass);
            }
          });
        });
      };
    })(jQuery);

    $("#timeline-1").timeline();
  </script>
</body>

</html>