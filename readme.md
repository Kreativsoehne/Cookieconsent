# Kreativsoehne - Cookieconsent

Cookie optin with [brainsum/cookieconsent](https://github.com/brainsum/cookieconsent) as a two-layer overlay and ways to block cookies and external resources from loading if a user does not optin.

**Note**:
Version 4 has significant breaking changes and is not compatible with older version. However, if you find bugs or issues within v3 kindly open a [issue](https://github.com/Kreativsoehne/Cookieconsent/issues) with us and we'll see about updating and fixing v3 if necessary.

## Install

Install through contao-manager or with `composer require kreativsoehne/cookieconsent`.
The latter might require a manual `cache:clear` and `contao:migrate` afterwards.
The database migrations will insert a few common cookie categories and services.

## Usage

This package offers these parts:

* Two [Backend](#backend) areas for creating and managing the cookie categories and services
* A [Frontend-Module](#frontend-modules) for rendering the entire cookieconsent in frontend
* A [Content-Element](#content-elements) for rendering a link to manually open the cookieconsent 2nd layer

#### Backend

The two new backend areas `Categories` and `Services / Cookies` allow you to create and manage cookie categories and services, respectively.
A few common categories and cookies/services will have been created on first install automatically.

##### Categories

These are used to split the cookies/services into chunks within the 2nd layer, where these can be allowed or not by the users.
They have only few settings and can be translated into multiple languages.

<!-- **TODO** Settings table -->

By default you should have at least these three categories, depending on the services you use:

* Necessary cookies (alias: `necessary`, ie. PHPSESSID, Contao Token)
* Analytics (alias: `analytics`, ie. Google Analytics/Tag Manager)
* Presentation (alias `presentation`, ie. Youtube/Vimeo)

Their aliases are used to enable or disable specific features like auto-blocking later on.
If these don't exist, chances are it won't work.

##### Services / Cookies

Each of these will represent a single cookie or service (with multiple cookies) that is used on your website, fe. Contao Session or Google Analytics. They can be assigned to a category, have a few settings and can be translated into multiple languages.

<!-- **TODO** Settings table -->

###### Types

Each service may have a specific type. Based on the type, the cookieconsent tool will try to block the service (or its cookies) if their category was not allowed by the user:

| Name           | Description
| ---------------|-------------
| Dynamic script | These are javascript which will be added dynamically from within some other javascript (ie. google analytics)
| Local Cookie   | These are cookies set by your own domain, either through the site request or javascript (ie. PHPSESSID)
| Script-Tag     | These are javascript which are written as script tags within your site (ie. custom theme javascript files)

**Note**: The automatic blocking through any of these may not always work, as it greatly depends on the services or cookies and how these are set.
A few ways to block things manually through templating, PHP or Javascript can be found [here](#manual-blocking).

#### Frontend-Modules

##### Cookieconsent

Renders the entire cookieconsent overlay (both 1st and 2nd layer) into the frontend.
Contains a few basic text- and editor-fields for customizing the layer contents & description-texts. See the file `gdpr-texts.md` for some common texts.
It also offers two fields for selecting or linking the imprint & privacy policy pages.
These will be linked within the 1st layer and the cookieconsent will not automatically open on these pages (though it still runs in the background).

**Note**: While this is Frontend-Module and can be placed anywhere on your page, the cookieconsent will always be rendered into the Page-Head (`<head>`-tag).


#### Content-Elements

Name|Description|Settings
----|-----------|--------
*Cookieconsent Toggle*|Renders a link to open the cookieconsent 2nd layer again|No further settings


### Cookieconsent Layer Customization

See cookieconsent [documentation](https://github.com/brainsum/cookieconsent/blob/master/readme.md) for further information into specific settings.

#### Translations & Locales

Through the template file `cookieconsent_language` several of the frontend locales can be customized or additional ones added as required.
The format is a basic javascript object.

### Opening the settings layer manually

If you require a link/button to open the cookie settings (2nd layer), you can use the content element *Cookieconsent Toggle*.

It is also possible to just render its template:

```php
    <?= $this->insert('ce_ks_cookieconsent_toggle', [
        'iconClass' => 'fa fa-cookie-bite',
        'label' => 'Cookie Settings',
    ]) ?>
```

The options are:

Name|Description|Default
----|-----------|-------
iconClass|Optional list of icon classes (ie. Fontawesome).<br>Leave empty to not render an icon.|`fa fa-cookie-bite`
label|The label of the button|`$GLOBALS['TL_LANG']['MCS']['cookieconsent_togglebutton_label']`

### Auto blocked content & templates

A few common templates are auto blocked, when their category was not allowed by the user.
If something is blocked that way and Contao' debug mode is enabled, the cookieconsent will output a html-comment noting the block.
Within that comment you can find the content/template name and category alias

Approx. template|Wanted category
---|---
analytics_xyz|analytics
youtube\|vimeo|persentation
gmap\|googlemaps|persentation

If you have any template, frontend module or content element you'd like to be auto blocked also, kindly open a [issue](https://github.com/Kreativsoehne/Cookieconsent/issues) with us and we'll see about adding it.

### Manual blocking

If you require anything else to be blocked then these if-condition should help.
In these examples we check if the category `Analytics` was accepted by the user:

In templates:

```php
<?php if (true === Kreativsoehne\Cookieconsent\Model\Category::isCategoryWanted('analytics')): ?>
    // User allowed cookies of category "analytics"
    // Your template code here
<?php endif; ?>
```

In PHP:

```php
$allowedAnalyticsCookies = Kreativsoehne\Cookieconsent\Model\Category::isCategoryWanted('analytics');
// [...]

if (true === $allowedAnalyticsCookies) {
    // User allowed cookies of category "analytics"
    // Your php code here
}
```

In Javascript:

```js
var ccChoices = document.cookie.match(new RegExp('(^| )cconsent=([^;]+)'));
if (ccChoices !== null) {
    try {
        ccChoices = JSON.parse(ccChoices[2]);
    } catch (e) {
        ccChoices = null;
    }
}
if (ccChoices !== null && typeof ccChoices === 'object' && typeof ccChoices.categories.analytics === 'object' && ccChoices.categories.analytics.wanted === true) {
    // User allowed cookies of category "analytics"
    // Your js code here
}
```

## Copyright

Copyright 2022 Kreativ&Söhne GmbH ([https://www.kreativundsoehne.de](https://www.kreativundsoehne.de))

See LICENSE for more information.
See [here](https://github.com/brainsum/cookieconsent/blob/master/LICENSE) for licensing information of `brainsum/cookieconsent`.
