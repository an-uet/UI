<?php

const APP_URL = 'trealet';

function initializeApp($exec)
{
	$app_url = '../../../..' . $_GET[APP_URL];
	$json_string = file_get_contents($app_url);
	if (!$json_string) die($app_url . ' not found!');
	$d = json_decode($json_string, true);
	if (!$d) die('Cannot parse the trealet content!');
	if (!isset($d['trealet'])) die('It is not a trealet!');
	if ($d['trealet']['exec'] != $exec) die('Wrong executable name!');
	return $d['trealet'];
}


function parseTrealetJSON($json_string, $exec)
{
	$d = json_decode($json_string, true);
	if (!$d) die('Cannot parse the trealet content!');
	if (!isset($d['trealet'])) die('It is not a trealet!');
	if ($d['trealet']['exec'] != $exec) die('Wrong executable name!');
	return $d['trealet'];
}

function fetchItemData($item_url)
{
	if (is_numeric($item_url)) {
		$item_url = 'https://hcloud.trealet.com/tiny' . $item_url . '/?json';
		$json_string = file_get_contents($item_url);
		if (!$json_string) return;
		$d = json_decode($json_string, true);
		return $d['image'];
	} else {
		return $item_url;
	}
}

function htmlStepQues($index, $idata, $game_title, $game_desc)
{
	if (isset($idata['url_full'])) //Show up the data item
	{
		$title 	  = isset($idata['title']) ? $idata['title'] : '';;
		$desc	  = isset($idata['desc']) ? $idata['desc'] : '';
		$url_full = isset($idata['url_full']) ? $idata['url_full'] : '';
		$path     = isset($idata['path']) ? $idata['path'] : '';

		$vobj	  = '';
		//Supported format APP, FLA, FLV, GIF, GLB, HTM, HTML, JPEG, JPG, M4A, M4V, MP3, MP4, PDF, PNG, PPS, PPT, TIF, TIFF, TXT		

		$ext = strtoupper(pathinfo($url_full, PATHINFO_EXTENSION));
		if ($ext == 'GIF' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG' || $ext == 'TIF' || $ext == 'TIFF') {
			//$vobj .= '<center><img src="'.$url_full.'" style="max-width:90%;"></center>';

			$html = 
			'<li>
			<div>
				<div class="icon animate pulse" data-wow-delay="0.4">
					<img id="'.$index.'" src="'.$url_full.'">
				</div>
				<div class="oneStep'.$index.'">
                    
                                        
            </div>
			</div>
			<div class="media-body">
				<h4>'.$game_title.'</h4>
				<p>'.$game_desc.'</p>
			</div>
		</li>';
		}
		return $html;
	}

	
}


function htmlItem($trealet_id, $nij, $css_input_id = '', $idata, $itime, $timeline_item = '', $timeline__content = '', $timeline__img = '', $timeline__content_title = '', $timeline__content_desc = '', $index_more, $idesc)
{
	if (isset($idata['url_full'])) //Show up the data item
	{
		$title 	  = isset($idata['title']) ? $idata['title'] : '';;
		$desc	  = isset($idata['desc']) ? $idata['desc'] : '';
		$url_full = isset($idata['url_full']) ? $idata['url_full'] : '';
		$path     = isset($idata['path']) ? $idata['path'] : '';

		$vobj	  = '';
		//Supported format APP, FLA, FLV, GIF, GLB, HTM, HTML, JPEG, JPG, M4A, M4V, MP3, MP4, PDF, PNG, PPS, PPT, TIF, TIFF, TXT		

		$ext = strtoupper(pathinfo($url_full, PATHINFO_EXTENSION));

		//items
		if ($ext == 'GIF' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG' || $ext == 'TIF' || $ext == 'TIFF') {
			//$vobj .= '<center><img src="'.$url_full.'" style="max-width:90%;"></center>';

			$html = '<div class="' . $timeline_item . '" data-text="' . $desc . '">
						<div class="' . $timeline__content . '">
							<a href="' . $url_full . '"  data-fancybox="' . $index_more . '" data-caption="' . $desc . '">
								<img class="' . $timeline__img . '" src="' . $url_full . '">
							</a>
							<h2 class="' . $timeline__content_title . '">' . $itime . '</h2>
							<p class="' . $timeline__content_desc . '">' . $idesc . '</p>
						</div>
					</div>';
		}

		//Text
		if ($ext == 'TXT') {
			$vobj .= file_get_contents('https://hcloud.trealet.com' . $url_full); //For embedded video
			$vobj = '<iframe src="' . $url_full . '"></iframe>';
		}

		//Youtube
		if ($ext == "YTB") {
			$vid = file_get_contents('https://hcloud.trealet.com' . $url_full);
			$vobj .= '<div style="position: relative; width: 90%; height: 0; padding-bottom: 50%;">';
			$vobj .= '<iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="https://www.youtube.com/embed/' . $vid . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			$vobj .= '</div>';

			$html = '<div class="' . $timeline_item . '" data-text="' . $desc . '">
						<div class="' . $timeline__content . '">
							<div style="position: relative; width: 100%; height: 0; padding-bottom: 50%;">
							<iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="https://www.youtube.com/embed/' . $vid . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>	
							</div>
							<a  href="https://www.youtube.com/embed/' . $vid . '" data-fancybox="' . $index_more . '" data-caption="' . $desc . '"></a>
							<h2 class="' . $timeline__content_title . '">' . $itime . '</h2>
							<p class="' . $timeline__content_desc . '">' . $idesc . '</p>
						</div>
					</div>';
		}

		//GLB for 3D
		if ($ext == 'GLB') {
			$vobj .= '<div style="position: relative; width: 90%; height: 0; padding-bottom: 50%;">';
			$vobj .= '<iframe src="https://hcloud.trealet.com/h3r/embed/?glb=' . $url_full . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>';
			$vobj .= '</div>';
			$vobj = '<center>' . $vobj . '</center>';

			$html = '<div class="' . $timeline_item . '" data-text="' . $desc . '">
						<div class="' . $timeline__content . '">
							<div style="position: relative; width: 100%; height: 0; padding-bottom: 50%;">
							<iframe src="https://hcloud.trealet.com/h3r/embed/?glb=' . $url_full . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>	
							</div>
							<a  href="https://hcloud.trealet.com/h3r/embed/?glb=' . $url_full . '" data-fancybox="' . $index_more . '" data-caption="' . $desc . '"></a>
							<h2 class="' . $timeline__content_title . '">' . $itime . '</h2>
							<p class="' . $timeline__content_desc . '">' . $idesc . '</p>
						</div>
					</div>';
		}

		//Audio MP3
		if ($ext == 'MP3') {
			$vobj = '<audio controls><source src="' . $url_full . '" type="audio/mpeg">Your browser does not support the audio tag.</audio>';

			$html = '<div class="' . $timeline_item . '" data-text="' . $desc . '">
						<div class="' . $timeline__content . '">
							<audio controls><source src="' . $url_full . '" type="audio/mpeg">Your browser does not support the audio tag.</audio>
							<h2 class="' . $timeline__content_title . '">' . $itime . '</h2>
							<p class="' . $timeline__content_desc . '">' . $idesc . '</p>
						</div>
					</div>';
		}

		//Video MP4
		if ($ext == 'MP4') {
			$vobj = '<video width="90%" height="auto" controls><source src="' . $url_full . '" type="video/mp4">Your browser does not support the video tag.</video>';

			$html = '<div class="' . $timeline_item . '" data-text="' . $desc . '">
						<div class="' . $timeline__content . '">
							<a href="' . $url_full . '"  data-fancybox="' . $index_more . '" data-caption="' . $desc . '">
								<video width="100%" height="auto" controls><source src="' . $url_full . '" type="video/mp4">Your browser does not support the video tag.</video>
							</a>
							<h2 class="' . $timeline__content_title . '" style="padding: 30px 10px;">' . $itime . '</h2>
							<p class="' . $timeline__content_desc . '">' . $idesc . '</p>
							
						</div>
					</div>';
		}
		return $html;
	} else if (isset($idata['input']) && isset($idata['input']['type'])) {
		$type 	  = $idata['input']['type'];
		$title 	  = isset($idata['input']['label']) ? $idata['input']['label'] : '';
		$desc	  = isset($idata['input']['desc']) ? $idata['input']['desc'] : '';
		$vobj 	  = '';
		if ($type == 'picture') {
			$vobj = '<iframe style="position: relative; width: 90%;" src="https://hcloud.trealet.com/trealet-schema/input-picture/index.php?tr_id=' . $trealet_id . '&nij=' . $nij . '" title="' . $title . '" frameborder="0" allow="camera" onload="this.style.height=(this.contentWindow.document.body.scrollHeight+200)+\'px\';"></iframe>';
		} else if ($type == 'audio') {
			$vobj = '<iframe style="position: relative; width: 100%;" src="https://hcloud.trealet.com/trealet-schema/input-audio/index.php?tr_id=' . $trealet_id . '&nij=' . $nij . '" title="' . $title . '" frameborder="0" allow="microphone" onload="this.style.height=(this.contentWindow.document.body.scrollHeight+100)+\'px\';"></iframe>';
		} else if ($type == 'form') {
			$vobj = '<iframe style="position: relative; width: 90%;" src="https://hcloud.trealet.com/trealet-schema/input-form/index.php?tr_id=' . $trealet_id . '&nij=' . $nij . '" title="Input data from a form" frameborder="0" onload="this.style.height=(this.contentWindow.document.body.scrollHeight+250)+\'px\';"></iframe>';
		} else if ($type == 'qr') {
			$vobj 	 .= '<iframe style="position: relative; width: 90%;" src="https://hcloud.trealet.com/trealet-schema/input-qr/index.php?tr_id=' . $trealet_id . '&nij=' . $nij . '" title="Scan QR code from camera" frameborder="0" allow="camera" onload="this.style.height=(this.contentWindow.document.body.scrollHeight+200)+\'px\';"></iframe>';
		}
		$html 	  = '<div id="' . $css_input_id . '"><h1>' . $desc . '</h1><center>' . $vobj . '</center><br><p>' . $idesc . '</p></div>';
		return $html;
	}
}





