<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\Migration\Version4;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class ServiceMigration extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    /** @inheritDoc */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /** @inheritDoc */
    public function getName(): string
    {
        return 'Cookieconsent migration for inserting common cookies/services';
    }

    /** @inheritDoc */
    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        // Only run if the table exist
        if (
            false === $schemaManager->tablesExist(['tl_ks_cc_service']) &&
            false === $schemaManager->tablesExist(['tl_ks_cc_service_language'])
        ) {
            return false;
        }

        // Only run if the table is empty
        $id = $this->connection->fetchOne('SELECT id FROM tl_ks_cc_service');
        if (false === empty($id)) {
            return false;
        }

        // Only run if the table is empty
        $id = $this->connection->fetchOne('SELECT id FROM tl_ks_cc_service_language');
        if (false === empty($id)) {
            return false;
        }

        return true;
    }

    /** @inheritDoc */
    public function run(): MigrationResult
    {
        $resultService = $this->runServiceMigration();
        $resultServiceLanguage = $this->runServiceLanguageMigration();

        return $this->createResult(
            $resultService && $resultServiceLanguage,
            'Created services with en & de translations.'
        );
    }

    /**
     * Run service migration.
     * @return bool
     */
    protected function runServiceMigration(): bool
    {
        $serviceStatement = $this->connection->prepare("
            INSERT INTO `tl_ks_cc_service` (`id`, `tstamp`, `alias`, `category`, `type`, `duration`, `cookies`, `keywords`, `published`, `sorting`, `pid`) VALUES
            (2, 1638525841, 'phpsessid', '1', 'localcookie', '', 'PHPSESSID', '', '1', 32, 0),
            (4, 1614778278, 'csrf_https', '1', 'localcookie', '', 'csrf_https-contao_csrf_token', '', '1', 64, 0),
            (5, 1666265618, 'vimeo', '4', 'localcookie', '', 'vuid,__cf_bm,/Optanon/', 'vimeo', '1', 1024, 0),
            (6, 1614778197, 'cconsent', '1', 'localcookie', '', '', '', '1', 160, 0),
            (7, 1614778697, 'grecaptcha', '9', 'script-tag', '', '_GRECAPTCHA', 'recaptcha,captcha', '1', 640, 0),
            (11, 1666265175, 'google-analytics', '2', 'dynamic-script', '', '/^_g/,IDE', 'analytics,gtag,googletagmanager,gtm,tagmanger', '1', 256, 0),
            (12, 1666265276, 'google-ads', '7', 'dynamic-script', '', 'IDE,test_cookie', 'adservices,remarketing', '1', 320, 0),
            (14, 1666265299, 'google-conversion', '6', 'dynamic-script', '', '/^_gcl/', 'adwords,conversion', '1', 512, 0),
            (15, 1666265574, 'youtube', '4', 'localcookie', '', 'NID,ANID,IDE,YSC,PREF,VISITOR_INFO1_LIVE,GPS,CONSENT', 'youtube', '1', 896, 0),
            (16, 1666265030, 'google-maps', '4', 'dynamic-script', '', 'SIDCC,NID,ANID,IDE,CONSENT', 'gmap', '1', 768, 0),
            (17, 1666265250, 'bing', '2', 'dynamic-script', '', '/_cl[s|c]k/,CLID,MUID,/_uet[v|s]id/', 'bing,microsoft,clarity', '1', 288, 0);
        ");

        $result = $serviceStatement->execute();
        return $result->rowCount() > 0;
    }

    /**
     * Run service language migration.
     * @return bool
     */
    protected function runServiceLanguageMigration(): bool
    {
        $serviceLanguageStatement = $this->connection->prepare("
            INSERT INTO `tl_ks_cc_service_language` (`id`, `tstamp`, `pid`, `language`, `name`, `description`) VALUES
            (1, 1629717720, 2, 'de', 'PHP Sessions', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>PHPSESSID</strong></em></td>\n<td>Domain</td>\n<td>Ein Session Cookie speichert Informationen, die Aktivitäten einer einzelnen Browser-Sitzung zuordnen. Der Session Cookie wird in der Regel beim Schließen des Browsers entfernt.</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
            (5, 1614345838, 4, 'de', 'Contao CSRF Protection', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>csrf_[-]https-contao[-]_csrf_[-]token</strong></em></td>\n<td>Domain</td>\n<td>Ein Contao System Cookie. Das Contao CSRF-Cookie verhindert CSRF-Attacken.</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
            (8, 1614345900, 6, 'de', 'Cookie Consent', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>cconsent</strong></em></td>\n<td>Domain</td>\n<td>Speichert die Einstellungen des Cookie Consent Tools.</td>\n<td>1 Jahr</td>\n</tr>\n</tbody>\n</table>'),
            (10, 1614348541, 7, 'de', 'Google ReCaptcha', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>_GRE[-]CAPTCHA</strong></em></td>\n<td>Domain</td>\n<td>Dies ist ein Dienst, der prüft, ob eingegebene Daten von einem Menschen oder von einem automatisierten Programm auf der Webseite eingegeben werden.</td>\n<td>6 Monate</td>\n</tr>\n</tbody>\n</table>'),
            (16, 1666265609, 5, 'de', 'Vimeo', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>vuid</strong></em></td>\n<td>.vimeo.com</td>\n<td>Wird verwendet, um Vimeo-Inhalte zu entsperren.</td>\n<td>1 Jahr</td>\n</tr>\n<tr>\n<td><em><strong>__cf_bm</strong></em></td>\n<td>.vimeo.com</td>\n<td>Wird verwendet, um automatische Anfragen von Bots zu erkennen und zu filtern.</td>\n<td>30 Minuten</td>\n</tr>\n<tr>\n<td><em><strong>Optanon[-]Consent</strong></em></td>\n<td>.vimeo.com</td>\n<td>Wird von Vimeo zur Einwilligungs[-]verwaltung (OneTrust) verwendet .</td>\n<td>9 Monate</td>\n</tr>\n<tr>\n<td><em><strong>Optanon[-]AlertBox[-]Closed</strong></em></td>\n<td>.vimeo.com</td>\n<td>Wird von Vimeo zur Einwilligungs[-]verwaltung (OneTrust) verwendet .</td>\n<td>9 Monate</td>\n</tr>\n</tbody>\n</table>'),
            (19, 1666265151, 11, 'de', 'Google Analytics', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>_g</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google Analytics wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>2 Jahre</td>\n</tr>\n<tr>\n<td><em><strong>_ga</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google Analytics wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>2 Jahre</td>\n</tr>\n<tr>\n<td><em><strong>_ga_*</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google Analytics wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>2 Jahre</td>\n</tr>\n<tr>\n<td><em><strong>_gid</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google Analytics wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>24 Stunden</td>\n</tr>\n<tr>\n<td><em><strong>_gat</strong></em></td>\n<td>Domain</td>\n<td>Bestimmte Daten werden nur maximal einmal pro Minute an Google Analytics gesendet. Das Cookie hat eine Lebensdauer von einer Minute. Solange es gesetzt ist, werden bestimmte Datenübertragungen unterbunden.</td>\n<td>1 Minute</td>\n</tr>\n<tr>\n<td><em><strong>_gat_UA-*</strong></em></td>\n<td>Domain</td>\n<td>Wird für technisches Monitoring verwendet.</td>\n<td>Session</td>\n</tr>\n<tr>\n<td><em><strong>_gat_gtag_*</strong></em></td>\n<td>Domain</td>\n<td>Bestimmte Daten werden nur maximal einmal pro Minute an Google Analytics gesendet. Das Cookie hat eine Lebensdauer von einer Minute. Solange es gesetzt ist, werden bestimmte Datenübertragungen unterbunden.</td>\n<td>1 Minute</td>\n</tr>\n<tr>\n<td><em><strong>_gac_UA-*</strong></em></td>\n<td>Domain</td>\n<td>Wird verwendet, zum speichern und zählen von Seitenaufrufen.</td>\n<td>90 Tage</td>\n</tr>\n<tr>\n<td><em><strong>_gac_*</strong></em></td>\n<td>Domain</td>\n<td>Wird verwendet, zum speichern und tracken von Zielgruppen Reichweite.</td>\n<td>90 Tage</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google den User über verschiedene Websites domainübergreifend wiedererkennen und personalisierte Werbung ausspielen.</td>\n<td>1 Jahr</td>\n</tr>\n</tbody>\n</table>'),
            (20, 1614343734, 12, 'de', 'Google Ads &#40;Remarketing und Conversion Tracking&#41;', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>test_[-]cookie</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Wird testweise gesetzt, um zu prüfen, ob der Browser das Setzen von Cookies erlaubt. Enthält keine Identifikationsmerkmale.</td>\n<td>15 Minuten</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google den User über verschiedene Websites domainübergreifend wiedererkennen und personalisierte Werbung ausspielen.</td>\n<td>1 Jahr</td>\n</tr>\n</tbody>\n</table>'),
            (21, 1614343921, 14, 'de', 'Google Ads Conversion', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>_gcl_au</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID.</td>\n<td>90 Tage</td>\n</tr>\n<tr>\n<td><em><strong>_gcl_aw</strong></em></td>\n<td>Domain</td>\n<td>Dieses Cookie wird gesetzt, wenn ein User über einen Klick auf eine Google Werbeanzeige auf die Website gelangt. Es enthält Informationen darüber, welche Werbeanzeige geklickt wurde, sodass erzielte Erfolge wie z.B. Bestellungen oder Kontaktanfragen der Anzeige zugewiesen werden können.</td>\n<td>90 Tage</td>\n</tr>\n</tbody>\n</table>'),
            (22, 1666265539, 15, 'de', 'YouTube', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>.google.com</td>\n<td>Wird für die Personalisierung der Youtube-Inhalte verwendet.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>ANID</strong></em></td>\n<td>.google.com</td>\n<td>Wird für die Personalisierung der Youtube-Inhalte verwendet.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>.doubleclick.net</td>\n<td>Wird für die Personalisierung der Youtube-Inhalte verwendet.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>YSC</strong></em></td>\n<td>.youtube.com</td>\n<td>Wird verwendet um die Historie der Interaktionen zu speichern.</td>\n<td>Session</td>\n</tr>\n<tr>\n<td><em><strong>PREF</strong></em></td>\n<td>.youtube.com</td>\n<td>Wird verwendet um Einstellungen (z.B. Zeitzone) zu speichern.</td>\n<td>1 Jahr</td>\n</tr>\n<tr>\n<td><em><strong>VISITOR_[-]INFO1_[-]LIVE</strong></em></td>\n<td>.youtube.com</td>\n<td>Wird von Youtube verwendet um die Bandbreite der Internet[-]verbindung zu schätzen.</td>\n<td>7 Tage</td>\n</tr>\n<tr>\n<td><em><strong>GPS</strong></em></td>\n<td>.youtube.com</td>\n<td>Speichert die zuletzt bekannt Geolocation, sofern erlaubt.</td>\n<td>30 Minuten</td>\n</tr>\n<tr>\n<td><em><strong>CONSENT</strong></em></td>\n<td>.youtube.com</td>\n<td>Wird verwendet, um die Einwilligungen zu speichern.</td>\n<td>18 Monate</td>\n</tr>\n<tr>\n<td><em><strong>CONSENT</strong></em></td>\n<td>.google.com</td>\n<td>Wird verwendet, um die Einwilligungen zu speichern.</td>\n<td>18 Monate</td>\n</tr>\n</tbody>\n</table>'),
            (23, 1666265027, 16, 'de', 'Google Maps', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>.google.com</td>\n<td>Wird für die Personalisierung der Google Maps-Inhalte verwendet.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>ANID</strong></em></td>\n<td>.google.com</td>\n<td>Wird für die Personalisierung der Google Masp-Inhalte verwendet.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>.doubleclick.net</td>\n<td>Wird für die Personalisierung der Google Maps-Inhalte verwendet.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>SIDCC</strong></em></td>\n<td>.google.com</td>\n<td>Wird für die Identifizierung von gesicherten Web-Traffic verwendet.</td>\n<td>1 Jahr</td>\n</tr>\n<tr>\n<td><em><strong>CONSENT</strong></em></td>\n<td>.google.com</td>\n<td>Wird verwendet, um die Benutzer-Einwilligungen zu speichern.</td>\n<td>18 Monate</td>\n</tr>\n</tbody>\n</table>'),
            (24, 1614778222, 2, 'en', 'PHP Sessions', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>PHPSESSID</strong></em></td>\n<td>Domain</td>\n<td>A session cookie stores information associated with the activities of a single browser session. Session cookies are usually deleted when closing the browser</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
            (28, 1614778253, 4, 'en', 'Contao CSRF Protection', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>csrf_[-]https-contao[-]_csrf_[-]token</strong></em></td>\n<td>Domain</td>\n<td>A Contao system cookie. The Contao CSRF cookie prevents CSRF attacks.</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
            (31, 1614778178, 6, 'en', 'Cookie Consent', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Lenghth of storage</th>\n</tr>\n<tr>\n<td><em><strong>cconsent</strong></em></td>\n<td>Domain</td>\n<td>Saves the settings of the Cookie consent tool.</td>\n<td>1 year</td>\n</tr>\n</tbody>\n</table>'),
            (34, 1666265172, 11, 'en', 'Google Analytics', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>_g</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Google Analytics can recognise returning users of this website and merge the data with previous visits.</td>\n<td>2 years</td>\n</tr>\n<tr>\n<td><em><strong>_ga</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Google Analytics can recognise returning users of this website and merge the data with previous visits.</td>\n<td>2 years</td>\n</tr>\n<tr>\n<td><em><strong>_ga_*</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Google Analytics can recognise returning users of this website and merge the data with previous visits.</td>\n<td>2 years</td>\n</tr>\n<tr>\n<td><em><strong>_gid</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Google Analytics can recognise returning users of this website and merge the data with previous visits.</td>\n<td>24 hours</td>\n</tr>\n<tr>\n<td><em><strong>_gat</strong></em></td>\n<td>Domain</td>\n<td>Certain data is only sent to Google Analytics a maximum of once per minute. The cookie has a lifetime of one minute. As long as it is set, specific data transmissions are prevented.</td>\n<td>1 Minute</td>\n</tr>\n<tr>\n<td><em><strong>_gat_UA-*</strong></em></td>\n<td>Domain</td>\n<td>Used for technical monitoring.</td>\n<td>Session</td>\n</tr>\n<tr>\n<td><em><strong>_gat_gtag_*</strong></em></td>\n<td>Domain</td>\n<td>Certain data is only sent to Google Analytics a maximum of once per minute. The cookie has a lifetime of one minute. As long as it is set, specific data transmissions are prevented.</td>\n<td>1 minute</td>\n</tr>\n<tr>\n<td><em><strong>_gac_UA-*</strong></em></td>\n<td>Domain</td>\n<td>Used to store and count page views.</td>\n<td>90 days</td>\n</tr>\n<tr>\n<td><em><strong>_gac_*</strong></em></td>\n<td>Domain</td>\n<td>Used to store and track audience reach.</td>\n<td>90 days</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Contains a randomly generated user ID. Using this ID, Google can recognise the user across different websites and display personalised advertising.</td>\n<td>1 year</td>\n</tr>\n</tbody>\n</table>'),
            (37, 1614778520, 12, 'en', 'Google Ads &#40;Remarketing and Conversion Tracking&#41;', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>test_[-]cookie</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Is set as a test in order to check whether the browser allows cookies to be set. Does not contain any identification features.</td>\n<td>15 minutes</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Contains a randomly generated user ID. Using this ID, Google can recognise the user across different websites and display personalised advertising.</td>\n<td>1 year</td>\n</tr>\n</tbody>\n</table>'),
            (40, 1614778604, 14, 'en', 'Google Ads Conversion', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>_gcl_au</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID.</td>\n<td>90 days</td>\n</tr>\n<tr>\n<td><em><strong>_gcl_aw</strong></em></td>\n<td>Domain</td>\n<td>This cookie is set when a user accesses the website by clicking on a Google ad. It contains information about which ad has been clicked on so that successes such as orders or contact requests can be assigned to the ad.</td>\n<td>90 days</td>\n</tr>\n</tbody>\n</table>'),
            (43, 1614778675, 7, 'en', 'Google ReCaptcha', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>_GRE[-]CAPTCHA</strong></em></td>\n<td>Domain</td>\n<td>This is a service that checks whether data entered on the website is entered by a human or by an automated programme.</td>\n<td>6 months</td>\n</tr>\n</tbody>\n</table>'),
            (46, 1666002445, 16, 'en', 'Google Maps', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>.google.com</td>\n<td>Used for the personalization of Google Maps contents.</td>\n<td>6 months</td>\n</tr>\n<tr>\n<td><em><strong>ANID</strong></em></td>\n<td>.google.com</td>\n<td>Used for the personalization of Google Maps contents.</td>\n<td>6 months</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>.doubleclick.net</td>\n<td>Used for the personalization of Google Maps contents.</td>\n<td>6 months</td>\n</tr>\n<tr>\n<td><em><strong>SIDCC</strong></em></td>\n<td>.google.com</td>\n<td>Used for identification of trusted web-traffic.</td>\n<td>1 year</td>\n</tr>\n<tr>\n<td><em><strong>CONSENT</strong></em></td>\n<td>.google.com</td>\n<td>Used to save user consent.</td>\n<td>18 months</td>\n</tr>\n</tbody>\n</table>'),
            (49, 1666265571, 15, 'en', 'YouTube', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>.google.com</td>\n<td>Use for the personalization of youtube contents.</td>\n<td>6 months</td>\n</tr>\n<tr>\n<td><em><strong>ANID</strong></em></td>\n<td>.google.com</td>\n<td>Use for the personalization of youtube contents.</td>\n<td>6 months</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>.doubleclick.net</td>\n<td>Use for the personalization of youtube contents.</td>\n<td>6 months</td>\n</tr>\n<tr>\n<td><em><strong>YSC</strong></em></td>\n<td>.youtube.com</td>\n<td>Used to save a history of interactions.</td>\n<td>Session</td>\n</tr>\n<tr>\n<td><em><strong>PREF</strong></em></td>\n<td>.youtube.com</td>\n<td>Used to save preferences (ie. timezone).</td>\n<td>1 year</td>\n</tr>\n<tr>\n<td><em><strong>VISITOR_[-]INFO1_[-]LIVE</strong></em></td>\n<td>.youtube.com</td>\n<td>Used by Youtube to estimate connection bandwidth.</td>\n<td>7 days</td>\n</tr>\n<tr>\n<td><em><strong>GPS</strong></em></td>\n<td>.youtube.com</td>\n<td>Used to save the latest geolocation, if allowed</td>\n<td>30 minutes</td>\n</tr>\n<tr>\n<td><em><strong>CONSENT</strong></em></td>\n<td>.youtube.com</td>\n<td>Used to save user consent.</td>\n<td>2 years</td>\n</tr>\n<tr>\n<td><em><strong>CONSENT</strong></em></td>\n<td>.google.com</td>\n<td>Used to save user consent.</td>\n<td>2 years</td>\n</tr>\n</tbody>\n</table>'),
            (52, 1665998765, 5, 'en', 'Vimeo', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>vuid</strong></em></td>\n<td>.vimeo.com</td>\n<td>Used to unlock Vimeo content.</td>\n<td>1 year</td>\n</tr>\n<tr>\n<td><em><strong>__cf_bm</strong></em></td>\n<td>.vimeo.com</td>\n<td>Use to identify and filter automatich requests by bots.</td>\n<td>30 minutes</td>\n</tr>\n<tr>\n<td><em><strong>Optanon[-]Consent</strong></em></td>\n<td>.vimeo.com</td>\n<td>Used by vimeo for optin consent management (OneTrust).</td>\n<td>9 Monate</td>\n</tr>\n<tr>\n<td><em><strong>Optanon[-]AlertBox[-]Closed</strong></em></td>\n<td>.vimeo.com</td>\n<td>Used by vimeo for optin consent management (OneTrust).</td>\n<td>9 Monate</td>\n</tr>\n</tbody>\n</table>'),
            (53, 1666265229, 17, 'de', 'Microsoft Bing', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Bereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>MUID</strong></em></td>\n<td>.clarity.ms</td>\n<td>Wird verwendet zum speichern und tracken der Seitenaufruf.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>MUID</strong></em></td>\n<td>.bing.com</td>\n<td>Wird verwendet zum speichern und tracken der Seitenaufruf.</td>\n<td>6 Monate</td>\n</tr>\n<tr>\n<td><em><strong>CLID</strong></em></td>\n<td>.claritu.ms</td>\n<td>Wird verwendet zum speichern und tracken der Seitenaufruf.</td>\n<td>1 Jahr</td>\n</tr>\n<tr>\n<td><em><strong>_clsk</strong></em></td>\n<td>Domain</td>\n<td>Wird verwendet zum speichern der Seitenaufrufe eines Benutzer und das kombinieren dieser zu einer einzelne Session.</td>\n<td>1 Tag</td>\n</tr>\n<tr>\n<td><em><strong>_clck</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Microsoft wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>1 Jahr</td>\n</tr>\n<tr>\n<td><em><strong>_uetsid</strong></em></td>\n<td>Domain</td>\n<td>Wird verwendet zum speichern und tracken der Seitenaufruf.</td>\n<td>1 Tag</td>\n</tr>\n<tr>\n<td><em><strong>_uetvid</strong></em></td>\n<td>Domain</td>\n<td>Wird verwendet zum speichern und tracken der Seitenaufruf.</td>\n<td>14 Monate</td>\n</tr>\n</tbody>\n</table>'),
            (54, 1666265248, 17, 'en', 'Microsoft Bing', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>MUID</strong></em></td>\n<td>.clarity.ms</td>\n<td>Used to save and track pageviews.</td>\n<td>6 month</td>\n</tr>\n<tr>\n<td><em><strong>MUID</strong></em></td>\n<td>.bing.com</td>\n<td>Used to save and track pageviews.</td>\n<td>6 month</td>\n</tr>\n<tr>\n<td><em><strong>CLID</strong></em></td>\n<td>.claritu.ms</td>\n<td>Used to save and track pageviews.</td>\n<td>1 year</td>\n</tr>\n<tr>\n<td><em><strong>_clsk</strong></em></td>\n<td>Domain</td>\n<td>Used to save pageviews and combines these into a single user session.</td>\n<td>1 day</td>\n</tr>\n<tr>\n<td><em><strong>_clck</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Microsoft can recognise returning users of this website and merge the data with previous visits.</td>\n<td>1 year</td>\n</tr>\n<tr>\n<td><em><strong>_uetsid</strong></em></td>\n<td>Domain</td>\n<td>Used to save and track pageviews.</td>\n<td>1 day</td>\n</tr>\n<tr>\n<td><em><strong>_uetvid</strong></em></td>\n<td>Domain</td>\n<td>Used to save and track pageviews.</td>\n<td>14 months</td>\n</tr>\n</tbody>\n</table>');
        ");

        $result = $serviceLanguageStatement->execute();
        return $result->rowCount() > 0;
    }
}
