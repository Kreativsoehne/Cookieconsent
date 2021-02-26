# Kreativsoehne - Cookieconsent

Cookie optin with [brainsum/cookieconsent](https://github.com/brainsum/cookieconsent) as the overlay and ways to block cookies and external resources.

**Note**:
Version 3 has significant breaking changes and is not compatible with older version. However, if you find bugs or issues within v2 kindly open a [issue](https://github.com/Kreativsoehne/Cookieconsent/issues) with us and we'll see about updating v2 if necessary.

**Note2**:
Version 3 is currently in development and may contain bugs and issues. Use at your own discretion. The documentation may also not reflect all changes yet.

## Install

Install through contao-manager or with `composer require kreativsoehne/cookieconsent`.

Run a database update.

## Usage

Several of the basic settings will be available through the root page. In addition it adds a new Backend module allowing you to edit categories and services/cookies as you require.

### Cookieconsent Customization

See cookieconsent [documentation](https://github.com/brainsum/cookieconsent/blob/master/readme.md) for further information into specific settings.

#### Default categories & services

You can download a database dump ~~here~~ (not yet avaiable) which contains a list of categories, services and general configurations which we found to be GDPR compliant (so far).
It only contains german translations for the most part, but we'll update it with new languages once we have translations for them (if you'd like to help, kindly open a [issue](https://github.com/Kreativsoehne/Cookieconsent/issues) with us and we'll update the database dump with your translation).
You can import it through phpmyadmin and similar.
**Note**: Use at your own discretion. Do not import anything into a Live system without testing first!

#### Languages

Through the template file `cookieconsent_language` several of the frontend languages settings can be customized or additional ones added as required.
The format is a basic javascript object.

#### Opening the settings layer

If you require a link to open the cookie settings (2nd layer):

```html
<a href="#" onclick="document.querySelector('#cconsent-modal').classList.add('ccm--visible'); return false;">Cookie settings</a>
```

### Categories

Within the Backend module `Category` you can edit the list of categories within the 2nd layer.
By default you should have at least these three categories, depending on the services you use:

* Necessary cookies (alias: `necessary`, ie. PHPSESSID, Contao Token)
* Analytics (alias: `analytics`, ie. Google Analytics/Tag Manager)
* External (alias `external`, ie. Youtube/Vimeo)

Their aliases are used to enable or disable specific features later on.

### Services

Within the Backend module `Services/Cookies` you can edit the list of services or single cookies within each category.

#### Types

Each service may have a specific type. Based on the type, the cookieconsent tool will try to block the service (or its cookies) if their superordinate category was not allowed by the user.

| Name           | Description
| ---------------|-------------
| Dynamic script | These are javascript which will be added dynamically from within some other javascript (ie. google analytics)
| Local Cookie   | These are cookies set by your own domain, either through the site request or javascript (ie. PHPSESSID)
| Script-Tag     | These are javascript which are written as script tags within your site (ie. custom theme javascript files)

**Note**: The automatic blocking through any of these may not always work, as it greatly depends on the services or cookies and how these are set. Therefore below are several way to force block services and or cookies manually:

### Blocking analytics

This is for Contao 4.9 and above.
If you wish to block analytics and similar. Extend the template `analytics_google.html5` and replace this line:

```diff
+ $ccChoices = json_decode(html_entity_decode(\Input::cookie('cconsent')));
+ $allowedAnalyticsCookies = $ccChoices !== null && is_object($ccChoices->categories) && is_object($ccChoices->categories->analytics) && $ccChoices->categories->analytics->wanted === true;
+
- if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser()): ?>
+ if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser() && $allowedAnalyticsCookies == true): ?>
```

This way the analytics and any other code there won't be rendered unless the analytics category was accepted by the user beforehand.

#### For Contao 4.4

Unfortunately Contao 4.4 has a different caching scheme in comparison to 4.9 and the above if-condition won't work in 4.4 (and perhaps any other versions below 4.9).
Instead the condition has to be checked within the Javascript code, therefore the template `analytics_google.html5` needs to look like:

```php
<?php

/**
 * To use this script, please fill in your Google Analytics ID below
 */
$GoogleAnalyticsId = 'UA-XXXXX-X';


/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING!
 */
if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser()): ?>

<script>
var ccChoices = document.cookie.match(new RegExp('(^| )cconsent=([^;]+)'));
if (ccChoices !== null) {
    try {
        ccChoices = JSON.parse(ccChoices[2]);
    } catch (e) {
        ccChoices = null;
    }
}
if (ccChoices !== null && typeof ccChoices === 'object' && typeof ccChoices.categories.analytics === 'object' && ccChoices.categories.analytics.wanted === true) {

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', '<?= $GoogleAnalyticsId ?>', 'auto');
  <?php if (Config::get('privacyAnonymizeGA')): ?>
    ga('set', 'anonymizeIp', true);
  <?php endif; ?>
  ga('send', 'pageview');

}
</script>

<?php endif; ?>
```

### Blocking Youtube & Vimeo

The content elements for Youtube and Vimeo will be blocked automatically if the user did not accept cookies for measurement usage. You can edit the block message through the template `cookieconsent_blocknotice.html5` and its text through the `TL_LANG` variables.

### Blocking anything else

If you require anything else to be blocked then these if-condition should help.
In these examples we check if `Analytics` services/cookies were accepted by user:

In PHP:

```php
<?php
$ccChoices = json_decode(html_entity_decode(\Input::cookie('cconsent')));
$allowedAnalyticsCookies = $ccChoices !== null && is_object($ccChoices->categories) && is_object($ccChoices->categories->analytics) &&
$ccChoices->categories->analytics->wanted === true;

if ($allowedAnalyticsCookies === true) {
    // User allowed cookies of category "analytics"
    // Your php code here
}
?>
```

In templates (**Note**: This will only work in 4.9 and above):

```php
<?php
$ccChoices = json_decode(html_entity_decode(\Input::cookie('cconsent')));
$allowedAnalyticsCookies = $ccChoices !== null && is_object($ccChoices->categories) && is_object($ccChoices->categories->analytics) &&
$ccChoices->categories->analytics->wanted === true;
?>

<?php if ($allowedAnalyticsCookies === true): ?>
    // User allowed cookies of category "analytics"
    // Your template code here
<?php endif; ?>
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

Copyright 2021 Kreativ&Söhne GmbH ([https://www.kreativundsoehne.de](https://www.kreativundsoehne.de))

See LICENSE for more information.
See [here](https://github.com/brainsum/cookieconsent/blob/master/LICENSE) for licensing information of `brainsum/cookieconsent`.
