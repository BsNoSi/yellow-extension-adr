<?php
// adr plugin, https://github.com/BsNoSi/yellow-extention-adr
// Copyright (c) 2018 Norbert Simon, nosi@nosi.de
// This file may be used and distributed under the terms of the public license.
// 2018-11-12 Initial Release
// 2019-03-03 Update to new YELLOW API, language stripped from code to files
// Icons gegen text getauscht

class Yellowadr {
    const VERSION = "1.1";
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
			$lng = $this->yellow->page->get("language");
						
            $result = preg_replace('/(\n|\s)+/i','+',$street . '+' . $city);
			$output .='<div><h3>'.$this->yellow->text->getTextHtml("adr_contactdata", $lng ).'</h3>';
			$output .= '<span class="adr">' . $who . '</span>';
			if(!empty($person)) $output .= '<br/>'. $person;
			$output .= '<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Address", $lng ).'</span>'.$street.'<br/><span class="adr">&nbsp;</span>'.$city;
			$output .='<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Map", $lng ).'</span><a title="'.$this->yellow->text->getTextHtml("adr_ShowMaps", $lng ).'" href="https://www.google.com/maps/place/' . $result .'" target="map">'.$this->yellow->text->getTextHtml("adr_ShowMaps", $lng ).'</a>';
			if(!empty($phone)) $output .= '<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Tel", $lng ).'</span>' . $phone;
			if(!empty($mobile)) $output .= '<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Mobile", $lng ).'</span>' . $mobile;
			if(!empty($fax)) $output .= '<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Fax", $lng ).'</span>' . $fax;
			if(!empty($web)) $output .= '<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Web", $lng ).'</span><a href="https://' . $web . '" target="ex" title="'.$this->yellow->text->getTextHtml("adr_ExternalLink", $lng ).'">' . $web . '</a>';
			if(!empty($mail)) $output .= '<br/><span class="ico">'.$this->yellow->text->getTextHtml("adr_Mail", $lng ).'</span><a href="mailto://' . $mail . '?subject='.$this->yellow->text->getTextHtml("adr_InquiredBy", $lng ).$root.$page->location.'" title="'.$this->yellow->text->getTextHtml("adr_ByMail", $lng ).'">' . $mail . '</a>';
			$output .= '</div>';
			$output .= '<div class="adr">'.$this->yellow->text->getText("adr_OwnRisk", $lng ).'</div>';
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
