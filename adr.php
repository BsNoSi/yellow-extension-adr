<?php
// adr extension for YELLOW, https://github.com/bsnosi/yellow-extension-adr
// Copyright ©2018-now Norbert Simon, https://nosi.de for
// YELLOW Copyright ©2013-now Datenstrom, http://datenstrom.se
// This file may be used and distributed under the terms of the public license.
// requires YELLOW 0.8.4 or higher

class YellowAdr {
    const VERSION = "1.1";
	const TYPE = "feature";
    public $yellow;         //access to API
    
	
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="adr" && ($type=="block" || $type=="inline")) {
		  if (strlen($text)== 0) {
			$output = '<b>[adr who street city phone web mail person fax mobile]</b>';  
		  }	
		  else {
			list($who,$street, $city, $phone, $web, $mail,$person,$fax,$mobile) = $this->yellow->toolbox->getTextArgs($text);
			$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
									
            $result = preg_replace('/(\n|\s)+/i','+',$street . '+' . $city);
			$output .='<div><h3>'.$this->yellow->text->getHtml("adr_contactdata").'</h3>';
			$output .= '<span class="adr">' . $who . '</span>';
			if(!empty($person)) $output .= '<br/>'. $person;
			$output .= '<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Address").'</span>'.$street.'<br/><span class="adr">&nbsp;</span>'.$city;
			$output .='<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Map").'</span><a title="'.$this->yellow->text->getHtml("adr_ShowMaps").'" href="https://www.google.com/maps/place/' . $result .'" target="map">'.$this->yellow->text->getHtml("adr_ShowMaps").'</a>';
			if(!empty($phone)) $output .= '<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Tel").'</span>' . $phone;
			if(!empty($mobile)) $output .= '<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Mobile").'</span>' . $mobile;
			if(!empty($fax)) $output .= '<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Fax").'</span>' . $fax;
			if(!empty($web)) $output .= '<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Web").'</span><a href="https://' . $web . '" target="ex" title="'.$this->yellow->text->getHtml("adr_ExternalLink").'">' . $web . '</a>';
			if(!empty($mail)) $output .= '<br/><span class="ico">'.$this->yellow->text->getHtml("adr_Mail").'</span><a href="mailto://' . $mail . '?subject='.$this->yellow->text->getHtml("adr_InquiredBy").$root.$page->location.'" title="'.$this->yellow->text->getHtml("adr_ByMail").'">' . $mail . '</a>';
			$output .= '</div>';
			$output .= '<div class="adr">'.$this->yellow->text->get("adr_OwnRisk").'</div>' . $lng;;
		  }
        }
        return $output;
    }
	
	// Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="header") {
            $extensionLocation = $this->yellow->system->get("serverBase").$this->yellow->system->get("extensionLocation");
            $output = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}adr.css\" />\n";
        }
        return $output;
    }
}
