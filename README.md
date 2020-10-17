# Yellow Extention Adr

Version 1.1.3

> Tested with core version 0.8.23

## Application

Creation of well formated adresses.


## Install

1. Download and install [Datenstrom Yellow CMS](https://github.com/datenstrom/yellow/).
2. Download [adr extention](https://github.com/BsNoSi/yellow-extension-adr/archive/master.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy the `adr-master.zip` into the `system/extensions` folder.

To uninstall simply delete the [extention files](https://github.com/BsNoSi/yellow-extension-adr/blob/master/extension.ini).

## Prequisits:

- You need a header entry `adr` on pages where you want to use this extension.<br/>This refuses loading useless code on all other pages.

```
---
title: …
…
adr: (what ever you want, the entry as such is relevant)
…
---
```

## Usage

`[adr name1 street city phone website e-mail-adress name2 fax mobile]`

Parameters should be self explaining.

[adr] without any parameter shows the parameter setup bold in preview (or saved). If not bold, you should check if adr is installed correctly.

All given parts are displayed in a structured form. You can leave out what you want. The order follows (descending my) typical availability and need of information details.

The output is in different order, only available (given) information is displayed. To skip parts use a hyphen. A result may look like this:

![sample-display](sample-display.png)

> All external links open in a new tab/window (depending to browser settings of the user).

There is no check if

- the address has a meaningful display in google maps
- any of the given addresses are valid

### Additional Files

- Translation files for German, English and French are included. You may change the texts to you needs.
- The css to achieve the displayed result above is included. You may change it to your theme style.


## History

2020-10-17: API changes applied, prequisit of header flag added

2020-10-13: Revision and tested for Yellow 0.815

2019-05-05: Initial Release (for GitHub)


## Developer

[Norbert Simon](https://nosi.de/)


