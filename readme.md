# Kreativsoehne - Cookieconsent

Cookie optin with [brainsum/cookieconsent](https://github.com/brainsum/cookieconsent) as the overlay and ways to block cookies and external resources.

## Install

Install through contao-manager or with `composer require kreativsoehne/cookieconsent`.

Run a database update.

## Usage

The settings will be available through the root page. Activating the cookieconsent displays further options to customize the overlay content.

### Customization

See cookieconsent [documentation](https://github.com/brainsum/cookieconsent/blob/master/readme.md) for further information into specific settings.

#### Languages

Through the template file `cookieconsent_language` the languages can be customized or additional ones added as required.

#### Categories

Through the template file `cookieconsent_categories` the services categories can be customized or additional ones added as required.
There are several basic categories set up, though each will only be rendered if a info text for the category had been entered in the settings.

#### Services

Through the template file `cookieconsent_services` the specific services (and their cookies and how the services are inserted) can be customized or additional ones added as required.

#### Opening the settings

If you require a link to open the cookie settings (2nd layer):

```html
<a href="#" onclick="document.querySelector('#cconsent-modal').classList.add('ccm--visible'); return false;">Cookie settings</a>
```

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

This way the analytics and any other code there won't be rendered unless the services were were accepted by the user beforehand.

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
if (ccChoices !== null && typeof ccChoices === 'object' && ccChoices.categories.analytics.wanted === true) {

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
**Note:** If you have used a previous version of this extension, the template file `cookieblocknotice.html5` has been renamed to `cookieconsent_blocknotice.html5`.

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

Copyright 2020 Kreativ&Söhne GmbH ([https://www.kreativundsoehne.de](https://www.kreativundsoehne.de))

See LICENSE for more information.
See [here](https://github.com/brainsum/cookieconsent/blob/master/LICENSE) for licensing information of `brainsum/cookieconsent`.
