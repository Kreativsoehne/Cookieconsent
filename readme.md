# Kreativsoehne - Cookieconsent

Cookie optin with [cookieconsent](https://www.osano.com/cookieconsent) as the banner and ways to block cookies and external resources.

## Install

Install through contao-manager or with `composer require kreativsoehne/cookieconsent`.

Run a database update.

## Usage

The settings will be available through the root page. Activating the cookieconsent displays further options to customize the banner content.

### Blocking analytics

If you wish to block analytics and similar. Extend the template `analytics_google.html5` and replace this line:

```diff
- if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser()): ?>
+ if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser() && \Input::cookie('cookieconsent_status') === 'allow'): ?>
```

This way the analytics and any other code there won't be rendered unless the cookie and its necessary value were accepted & set by the user beforehand.

#### For Contao 4.4

Unfortunately Contao 4.4 has a different caching scheme in comparison to 4.9 and the above if condition won't work in 4.4 (and perhaps any other versions below 4.9).
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
var cookieMatch = document.cookie.match(new RegExp('(^| )cookieconsent_status=([^;]+)'));
if (cookieMatch !== null && cookieMatch[2] === 'allow') {

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

The content elements for Youtube and Vimeo will be blocked automatically if the user did not accept all cookies. You can edit the block message through the template `cookieblocknotice.html5` and its text through the `TL_LANG` variables.

### Blocking anything else

If you require anything else to be blocked then these basic if condition should help:

In PHP:

```php
<?php
if (\Input::cookie('cookieconsent_status') === 'allow') {
    // Your php code here
}
?>
```

In templates (**Note**: This will only work in 4.9 and above):

```php
<?php if (\Input::cookie('cookieconsent_status') === 'allow'): ?>
    // Your template code here
<?php endif; ?>
```

In Javascript:

```js
var cookieMatch = document.cookie.match(new RegExp('(^| )cookieconsent_status=([^;]+)'));
if (cookieMatch !== null && cookieMatch[2] === 'allow') {
    // You js code here
}
```

## Copyright

Copyright 2020 Kreativ&Söhne GmbH ([https://www.kreativundsoehne.de](https://www.kreativundsoehne.de))

See LICENSE for more information.
