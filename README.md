# Yellow Plugin Adr

Creator for well formated adress display

## The Idea Behind

Sometimes you need a more or less big amount of adress data *well formated* on a web site. To ease this, I created this plugin.

## How do I Install This?

1. Download and install [Datenstrom Yellow CMS](https://github.com/datenstrom/yellow/).
2. Download [adr plugin](https://github.com/BsNoSi/yellow-plugin-adr/archive/master.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy the `yellow-plugin-adr-master.zip` into the `system/plugins` folder.

To uninstall simply delete the [plugin files](https://github.com/BsNoSi/yellow-plugin-ontime/blob/master/update.ini).

## Using the adr plugin

`[adr name1 street city phone website e-mail-adress name2 fax mobile]`

All given parts are displayed in a structured form, you can leave out what you want. The order follows (descending my) typical availability/need of information details.

The output is in different order, only available (given) information is displayed and may look like this (see additional css below):

![sample-display](sample-display.png)

> All external links open in a new tab/window (depending to browser settings of the user).

There is no check if

- the address has a meaningful display in google maps
- any of the given addresses are valid

### Translations

The plugin contains English and German translations. You may add your language by inserting it into the php file:

```php+HTML
if (preg_match('/de/i', $lng)) {
				$hdl = 'Kontaktdaten';
				$hdlink = 'Externer Link zur Anbieterseite';
				$hdmap = 'In GoogleMaps anzeigen';
				$hdq = 'Anfrage%20von%20';
				$hdem = 'E-Mail per Mailprogramm';
				$hddis = 'Das Nutzen externer Links erfolgt auf eigene Gefahr.<br/>Sie sind <b>kein Bestandteil</b> dieser Webseite(n).';
			} 
```
Here you can insert an 

```php
else
if (preg_match('/yourlanguage/i', $lng)) {
…
}
```

copying the first part and changing the language and translations as required. Or you simply translate the German area to your required language and keep English as fallback.

```php+HTML
			else {
				$hdl = 'Contact Details';
				$hdlink = 'External link to provider page';
				$hdmap = 'Show in GoogleMaps';
				$hdq = 'Inquiry%20from%20';
				$hdem = 'E-Mail by your E-Mail Program';
				$hddis = 'The use of external links is at your own risk.<br/>They are <b>not part</b> of this website.';
```

## Additional css

To get the utf-8 symbols *well aligned* and to highlight the disclaimer for external links you may add this to your style sheet and modify it depending to your needs:

```css
div.adr {border-radius: 0.2rem; border: 0.1rem solid #F2C11E; padding:0.3rem; margin:1rem 0;background-color:#f7f7f7;display:inline-block;font-size:0.8em;}
span.adr {font-size: 1.1em; color:#094A7A;font-weight:bold;display:inline-block;min-width:1.8em;}
```



## Developer

[Norbert Simon](https://nosi.de/)



