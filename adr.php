<?php
// adr extension for YELLOW, https://github.com/bsnosi/yellow-extension-adr
// Copyright ©2018-now Norbert Simon, https://nosi.de for
// YELLOW Copyright ©2013-now Datenstrom, http://datenstrom.se
// This file may be used and distributed under the terms of the public license.

class YellowAdr {
 const VERSION = "1.1.4";
 public $yellow; 

 public function onLoad($yellow) {
    $this->yellow = $yellow;
 }
    
 public function onParseContentShortcut($page, $name, $text, $type) {
   $output = null;
   if ($name=="adr" && ($type=="block" || $type=="inline")) {
     if (strlen($text)== 0) {
	 $output = '<b>[adr who street city phone web mail person fax mobile]</b>';  
     }	
     else {
	 list($who,$street, $city, $phone, $web, $mail,$person,$fax,$mobile) = $this->yellow->toolbox->getTextArguments($text);
	 $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
       $result = preg_replace('/(\n|\s)+/i','+',$street . '+' . $city);
	 $output .='<div><h3>'.$this->yellow->language->getTextHtml("adr_contactdata").'</h3>';
	 $output .= '<span class="adr">' . $who . '</span>';
	 if(!empty($person)) $output .= '<br/>'. $person;
	 $output .= '<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Address").'</span>'.$street.'<br/><span class="adr">&nbsp;</span>'.$city;
	 $output .='<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Map").'</span><a title="'.$this->yellow->language->getTextHtml("adr_ShowMaps").'" href="https://www.google.de/maps/dir//' . $result .'" target="map">'.$this->yellow->language->getTextHtml("adr_ShowMaps").'</a>';
	 if(!empty($phone)) $output .= '<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Tel").'</span>' . $phone;
	 if(!empty($mobile)) $output .= '<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Mobile").'</span>' . $mobile;
	 if(!empty($fax)) $output .= '<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Fax").'</span>' . $fax;
	 if(!empty($web)) $output .= '<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Web").'</span><a href="https://' . $web . '" target="ex" title="'.$this->yellow->language->getTextHtml("adr_ExternalLink").'">' . $web . '</a>';
	 if(!empty($mail)) $output .= '<br/><span class="ico">'.$this->yellow->language->getTextHtml("adr_Mail").'</span><a href="mailto://' . $mail . '?subject='.$this->yellow->language->getTextHtml("adr_InquiredBy").$root.$page->location.'" title="'.$this->yellow->language->getTextHtml("adr_ByMail").'">' . $mail . '</a>';
	 $output .= '</div>';
	 $output .= '<div class="adr">'.$this->yellow->language->getText("adr_OwnRisk").'</div>';
     }
  }
  return $output;
 }
	
 public function onParsePageExtra($page, $name) {
   $output = null;
   if ($name=="header" && $page->isExisting("adr")) {
     $extensionLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreExtensionLocation");
     $output = "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}adr.css\" />\n";
   }
   return $output;
 }
}
?>
