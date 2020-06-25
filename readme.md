# Kreativsoehne - Cookieconsent

Cookie optin banner blocking major cookies through [cookieconsent](https://www.osano.com/cookieconsent)


## Install

Move module into `system/modules/kreativsoehne_cookieconsent`.

Run a cache warmup through console or contao-manager.

Run a database update.


## Usage

The settings will be available through the root page. Activating the cookieconsent
shows further options to customize the banner.

If you wish to block analytics and similar. Extend the template `analytics_google.html5` and
replace this line:

```php
- <?php if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser()): ?>
+ <?php if ($GoogleAnalyticsId != 'UA-XXXXX-X' && !BE_USER_LOGGED_IN && !$this->hasAuthenticatedBackendUser() && \Input::cookie('cookieconsent_status') === 'allow'): ?>
```

This way the analytics and any other code there won't be rendered unless the
cookie and its necessary value were accepted & set by the user.
