<?php
// adr plugin, https://github.com/nosibs/yellow-plugin-adr
// Copyright (c) 2018 Norbert Simon, nosi@nosi.de
// This file may be used and distributed under the terms of the public license.
// 2018-11-12 Initial Release

class Yellowadr {
    const VERSION = "1.0";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    // Handle page content parsing of custom block
    public function onParseContentBlock($page, $name, $text, $shortcut) {
        $output = null;
        if ($name=="adr" && $shortcut) {
			list($who,$street, $city, $phone, $web, $mail,$person,$fax,$mobile) = $this->yellow->toolbox->getTextArgs($text);
			$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
			$lng = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			if (preg_match('/de/i', $lng)) {
				$hdl = 'Kontaktdaten';
				$hdlink = 'Externer Link zur Anbieterseite';
				$hdmap = 'In GoogleMaps anzeigen';
				$hdq = 'Anfrage%20von%20';
				$hdem = 'E-Mail per Mailprogramm';
				$hddis = 'Das Nutzen externer Links erfolgt auf eigene Gefahr.<br/>Sie sind <b>kein Bestandteil</b> dieser Webseite(n).';
			} 
			else {
				$hdl = 'Contact Details';
				$hdlink = 'External link to provider page';
				$hdmap = 'Show in GoogleMaps';
				$hdq = 'Inquiry%20from%20';
				$hdem = 'E-Mail by your E-Mail Program';
				$hddis = 'The use of external links is at your own risk.<br/>They are <b>not part</b> of this website.';
			}
            $result = preg_replace('/(\n|\s)+/i','+',$street . '+' . $city);
			$output .='<div><h3>'.$hdl.'</h3>';
			$output .= '<span class="adr">' . $who . '</span>';
			if(!empty($person)) $output .= '<br/>'. $person;
			$output .= '<br/><span class="adr">&#128393;</span>'.$street.'<br/><span class="adr">&nbsp;</span>'.$city;
			$output .='<br/><span class="adr">&#9873;</span><a title="'.$hdmap.'" href="https://www.google.com/maps/place/' . $result .'" target="map">'.$hdmap.'</a>';
			if(!empty($phone)) $output .= '<br/><span class="adr">&#8481;</span>' . $phone;
			if(!empty($mobile)) $output .= '<br/><span class="adr">&#128385;</span>' . $mobile;
			if(!empty($fax)) $output .= '<br/><span class="adr">&#8507;</span>' . $fax;
			if(!empty($web)) $output .= '<br/><span class="adr">&#10150;</span><a href="https://' . $web . '" target="ex" title="'.$hdlink.'">' . $web . '</a>';
			if(!empty($mail)) $output .= '<br/><span class="adr">&#9993;</span><a href="mailto://' . $mail . '?subject='.$hdq.$root.$page->location.'" title="'.$hdem.'">' . $mail . '</a>';
			$output .= '</div>';
			$output .= '<div class="adr">'.$hddis.'</div>';
        }
        return $output;
    }
}