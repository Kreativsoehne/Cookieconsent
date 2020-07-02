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

### Blocking Youtube & Vimeo

The content elements for Youtube and Vimeo will be blocked if the user did not accept all cookies. You can edit the block message through the template `cookieblocknotice.html5` and its text through the `TL_LANG` variables.

## Copyright

Copyright 2020 Kreativ&Söhne GmbH ([https://www.kreativundsoehne.de](https://www.kreativundsoehne.de))
See LICENSE for more information.
