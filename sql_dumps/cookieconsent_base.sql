-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookieconsent_dev`
--

--
-- Dumping data for table `tl_ks_cc_category`
--

INSERT INTO `tl_ks_cc_category` (`id`, `tstamp`, `sorting`, `pid`, `alias`, `needed`, `wanted`, `checked`, `published`) VALUES
(1, 1614777969, 0, 0, 'necessary', '1', '1', '1', '1'),
(2, 1614777939, 0, 0, 'analytics', '', '', '', '1'),
(4, 1614777824, 128, 0, 'external', '', '', '', '1'),
(6, 1614777877, 64, 0, 'measurement', '', '', '', '1'),
(7, 1614777909, 0, 0, 'advertising', '', '', '', '1'),
(8, 1614345924, 80, 0, 'recommendations', '', '', '', ''),
(9, 1614777851, 96, 0, 'security', '', '', '', '1');

--
-- Dumping data for table `tl_ks_cc_category_language`
--

INSERT INTO `tl_ks_cc_category_language` (`id`, `tstamp`, `pid`, `language`, `name`, `description`) VALUES
(1, 1614420534, 1, 'de', 'Technisch notwendige Cookies', '<p>Technisch notwendige Cookies helfen dabei, eine Webseite nutzbar zu machen. Die Webseite kann ohne diese Cookies nicht richtig funktionieren.</p>'),
(2, 1614777612, 1, 'en', 'Technically required cookies', '<p>Technically necessary cookies help make a website usable. The website cannot function properly without these cookies.</p>'),
(3, 1614419489, 2, 'de', 'Statistische Analyse', '<p>Statistische Analyse ist die Verarbeitung und Darstellung von Daten über Nutzeraktionen und -interaktionen auf Websites und Apps (z.B. Anzahl der Seitenbesuche, Anzahl der eindeutigen Besucher, Anzahl der wiederkehrenden Besucher, Einstiegs- und Ausstiegsseiten, Verweildauer, Absprungrate, Betätigung von Schaltflächen) und ggf. die Einteilung von Nutzern in Gruppen aufgrund technischer Daten über die verwendeten Softwareeinstellungen (z.B. Browsertyp, Betriebssystem, Spracheinstellung, Bildschirmauflösung).</p>'),
(5, 1614173830, 4, 'de', 'Darstellung', '<p>Cookies, um Funktionalitäten zu verbessern und Personalisierungen zu ermöglichen, beispielsweise für die Einbindung von Videos und die Verwendung von sozialen Medien.</p>'),
(9, 1614174110, 6, 'de', 'Reichweitenmessung', '<p>Reichweitenmessung ist die Besuchsaktionsauswertung durch Analyse des Nutzungsverhaltens in Bezug auf die Feststellung bestimmter Nutzeraktionen und Messung der Effektivität von Online-Werbung. Gemessen wird die Anzahl der Besucher, die z.B. durch das Anklicken von Werbeanzeigen auf Websites oder Apps gelangt sind. Darüber hinaus kann die Rate der Nutzer gemessen werden, die eine bestimmte Aktion ausführen (z.B. Registrierung für den Newsletter, Bestellung von Waren).</p>'),
(10, 1614174261, 7, 'de', 'Individualisierte Werbung', '<p>Bestimmte Funktionen von Websites und Apps dienen dazu, Nutzern personalisierte Werbemittel (Anzeigen oder Werbespots) in anderen Zusammenhängen, beispielsweise auf anderen Websites, Plattformen oder Apps anzuzeigen. Dafür werden aus demografischen Angaben, verwendeten Suchbegriffen, kontextbezogenen Inhalten, Nutzerverhaltensweisen auf Websites und in Apps oder aus dem Standort von Nutzern Rückschlüsse über die Interessen der Nutzer gezogen. Auf der Grundlage dieser Interessen werden künftig Werbemittel ausgewählt und bei anderen Anbietern von Online-Inhalten angezeigt.</p>'),
(11, 1614174336, 8, 'de', 'Individuelle Produktempfehlungen', '<p>Bestimmte Funktionen von Websites und Apps dienen dazu, den Nutzern Produktalternativen aufzuzeigen oder Kaufanreize zu steigern. Mit sog. Empfehlungen werden dem Kunden über das gesuchte Produkt hinaus Alternativen auf unterschiedlichste Weise angeboten. Dabei wird das Verhalten des Nutzers sowie der Warenkorb analysiert und in Echtzeit prognostiziert, welches Produkt dem Website-Besucher gefallen könnte. Zudem besteht die Möglichkeit, Produktempfehlungen aufgrund von Ähnlichkeiten des Produkts in einer Kategorie anzuzeigen oder manuell zugeordnete Empfehlungen, wie Zubehörartikel oder Bundle-Produkte, einzubinden.</p>'),
(12, 1614175506, 9, 'de', 'Sicherheit', '<p>Diese Dienste werden für Grundfunktionen und für eine höhere Sicherheit bei der Nutzung der Webseite benötigt.</p>'),
(13, 1614777751, 9, 'en', 'Security', '<p>These services are required for basic functions and for greater security in the use of the website.</p>'),
(14, 1614777650, 2, 'en', 'Statistical analysis', '<p>Statistical analysis is the processing and display of data related to user actions and interactions on websites and apps (e.g. number of page visits, number of unique visitors, number of returning visitors, entry and exit pages, duration of visit, bounce rate, button presses) and, where applicable, the classification of users into groups based on technical data about the software settings being used (e.g. browser types, operating systems, language settings, screen resolutions).</p>'),
(15, 1614777682, 7, 'en', 'Individualised advertising', '<p>Certain features of websites and apps are used to display personalised advertising (ads or commercials) to users in other contexts, such as on other websites, platforms or apps. For this purpose, conclusions about the interests of users are drawn from demographic data, search terms used, contextual content, user behaviour on websites and in apps, or from the location of users. Based on these interests, advertising media will be selected in the future and displayed on the websites of other online content providers.</p>'),
(16, 1614777733, 6, 'en', 'Reach metrics', '<p>Reach metrics refers to the evaluation of user actions by analysing user behaviour in order to identify specific actions taken by users and measure the effectiveness of online advertising. The number of visitors who have accessed websites or apps by clicking on advertisements, for example, is measured. In addition, the proportion of users who perform a certain action can be measured (e.g. registration for the newsletter, ordering goods).</p>'),
(17, 1614777778, 4, 'en', 'Display', '<p>Cookies to improve functionalities and enable personalisation, for example for the integration of videos and the use of social media.</p>'),
(18, 1614174336, 8, 'en', 'Individual recommendations', '<p>Certain functions of websites and apps serve to show users product alternatives or to increase purchasing incentives. With so-called recommendations, the customer is offered a wide variety of alternatives in addition to the product he is looking for. The behavior of the user and the shopping cart are analyzed and a forecast is made in real time which product the website visitor might like. It is also possible to display product recommendations based on product similarities in a category or to include manually assigned recommendations, such as accessories or bundled products.</p>');

--
-- Dumping data for table `tl_ks_cc_service`
--

INSERT INTO `tl_ks_cc_service` (`id`, `tstamp`, `sorting`, `pid`, `alias`, `category`, `type`, `cookies`, `keywords`, `duration`, `published`) VALUES
(2, 1614778243, 32, 0, 'phpsessid', '1', 'localcookie', 'PHPSESSID', '', '', '1'),
(4, 1614778278, 64, 0, 'csrf_https', '1', 'localcookie', 'csrf_https-contao_csrf_token', '', '', '1'),
(5, 1614778854, 1024, 0, 'vimeo', '4', 'localcookie', 'vuid', 'vimeo', '', '1'),
(6, 1614778197, 160, 0, 'cconsent', '1', 'localcookie', '', '', '', '1'),
(7, 1614778697, 640, 0, 'grecaptcha', '9', 'script-tag', '_GRECAPTCHA', 'recaptcha,captcha', '', '1'),
(11, 1614778445, 256, 0, 'google-analytics', '2', 'dynamic-script', '_gid,/^_ga/,/^_dc_gtm/,IDE', 'analytics,gtag,googletagmanager,gtm,bing', '', '1'),
(12, 1614778543, 384, 0, 'google-ads', '7', 'dynamic-script', 'IDE', 'adservices,remarketing', '', '1'),
(14, 1614778626, 512, 0, 'google-conversion', '6', 'dynamic-script', '/^_gcl/', 'adwords,conversion', '', '1'),
(15, 1614778811, 896, 0, 'youtube', '4', 'localcookie', 'NID', '', '', '1'),
(16, 1614778766, 768, 0, 'google-maps', '4', 'dynamic-script', '', 'gmap', '', '1');

--
-- Dumping data for table `tl_ks_cc_service_language`
--

INSERT INTO `tl_ks_cc_service_language` (`id`, `tstamp`, `pid`, `language`, `name`, `description`) VALUES
(1, 1614345793, 2, 'de', 'PHP Sessions', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>PHPSESSID</strong></em></td>\n<td>Domain</td>\n<td>Ein Session Cookie speichert Informationen, die Aktivitäten einer einzelnen Browser-Sitzung zuordnen. Der Session Cookie wird in der Regel beim Schließen des Browsers entfernt.</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
(5, 1614345838, 4, 'de', 'Contao CSRF Protection', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>csrf_https-contao_csrf_token</strong></em></td>\n<td>Domain</td>\n<td>Ein Contao System Cookie. Das Contao CSRF-Cookie verhindert CSRF-Attacken.</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
(8, 1614345900, 6, 'de', 'Cookie Consent', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>cconsent</strong></em></td>\n<td>Domain</td>\n<td>Speichert die Einstellungen des Cookie Consent Tools.</td>\n<td>1 Jahr</td>\n</tr>\n</tbody>\n</table>'),
(10, 1614348541, 7, 'de', 'Google ReCaptcha', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>_GRECAPTCHA</strong></em></td>\n<td>Domain</td>\n<td>Dies ist ein Dienst, der prüft, ob eingegebene Daten von einem Menschen oder von einem automatisierten Programm auf der Webseite eingegeben werden.</td>\n<td>6 Monate</td>\n</tr>\n</tbody>\n</table>'),
(16, 1614345467, 5, 'de', 'Vimeo', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>vuid</strong></em></td>\n<td>player.vimeo.com</td>\n<td>Wird verwendet, um Vimeo-Inhalte zu entsperren.</td>\n<td>2 Jahre</td>\n</tr>\n</tbody>\n</table>'),
(19, 1614180486, 11, 'de', 'Google Analytics', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>_ga</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google Analytics wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>2 Jahre</td>\n</tr>\n<tr>\n<td><em><strong>_gid</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google Analytics wiederkehrende User auf dieser Website wiedererkennen und die Daten von früheren Besuchen zusammenführen.</td>\n<td>24 Stunden</td>\n</tr>\n<tr>\n<td><em><strong>_gat</strong></em></td>\n<td>Domain</td>\n<td>Bestimmte Daten werden nur maximal einmal pro Minute an Google Analytics gesendet. Das Cookie hat eine Lebensdauer von einer Minute. Solange es gesetzt ist, werden bestimmte Datenübertragungen unterbunden.</td>\n<td>1 Minute</td>\n</tr>\n<tr>\n<td><em><strong>_dc_gtm_xxx</strong></em></td>\n<td>Domain</td>\n<td>Bestimmte Daten werden nur maximal einmal pro Minute an Google Analytics gesendet. Das Cookie hat eine Lebensdauer von einer Minute. Solange es gesetzt ist, werden bestimmte Datenübertragungen unterbunden.</td>\n<td>1 Minute</td>\n</tr>\n<tr>\n<td><em><strong>_gat_gtag_xxx</strong></em></td>\n<td>Domain</td>\n<td>Bestimmte Daten werden nur maximal einmal pro Minute an Google Analytics gesendet. Das Cookie hat eine Lebensdauer von einer Minute. Solange es gesetzt ist, werden bestimmte Datenübertragungen unterbunden.</td>\n<td>1 Minute</td>\n</tr>\n<tr>\n<td><em><strong>_gac_xxx</strong></em></td>\n<td>Domain</td>\n<td>Dieses Cookie wird gesetzt, wenn ein User über einen Klick auf eine Google Werbeanzeige auf die Website gelangt. Es enthält Informationen darüber, welche Werbeanzeige geklickt wurde, sodass erzielte Erfolge wie z.B. Bestellungen oder Kontaktanfragen der Anzeige zugewiesen werden können.</td>\n<td>90 Tage</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google den User über verschiedene Websites domainübergreifend wiedererkennen und personalisierte Werbung ausspielen.</td>\n<td>1 Jahr</td>\n</tr>\n</tbody>\n</table>'),
(20, 1614343734, 12, 'de', 'Google Ads &#40;Remarketing und Conversion Tracking&#41;', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>test_cookie</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Wird testweise gesetzt, um zu prüfen, ob der Browser das Setzen von Cookies erlaubt. Enthält keine Identifikationsmerkmale.</td>\n<td>15 Minuten</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Enthält eine zufallsgenerierte User-ID. Anhand dieser ID kann Google den User über verschiedene Websites domainübergreifend wiedererkennen und personalisierte Werbung ausspielen.</td>\n<td>1 Jahr</td>\n</tr>\n</tbody>\n</table>'),
(21, 1614343921, 14, 'de', 'Google Ads Conversion', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>_gcl_au</strong></em></td>\n<td>Domain</td>\n<td>Enthält eine zufallsgenerierte User-ID.</td>\n<td>90 Tage</td>\n</tr>\n<tr>\n<td><em><strong>_gcl_aw</strong></em></td>\n<td>Domain</td>\n<td>Dieses Cookie wird gesetzt, wenn ein User über einen Klick auf eine Google Werbeanzeige auf die Website gelangt. Es enthält Informationen darüber, welche Werbeanzeige geklickt wurde, sodass erzielte Erfolge wie z.B. Bestellungen oder Kontaktanfragen der Anzeige zugewiesen werden können.</td>\n<td>90 Tage</td>\n</tr>\n</tbody>\n</table>'),
(22, 1614345407, 15, 'de', 'YouTube', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>google.com</td>\n<td>Wird verwendet, um YouTube-Inhalte zu entsperren.</td>\n<td>6 Monate</td>\n</tr>\n</tbody>\n</table>'),
(23, 1614345571, 16, 'de', 'Google Maps', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Geltungsbereich</th>\n<th>Zweck</th>\n<th>Speicherdauer</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>google.com</td>\n<td>Wird zum Entsperren von Google Maps-Inhalten verwendet.</td>\n<td>6 Monate</td>\n</tr>\n</tbody>\n</table>'),
(24, 1614778222, 2, 'en', 'PHP Sessions', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>PHPSESSID</strong></em></td>\n<td>Domain</td>\n<td>A session cookie stores information associated with the activities of a single browser session. Session cookies are usually deleted when closing the browser</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
(28, 1614778253, 4, 'en', 'Contao CSRF Protection', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>csrf_https-contao_csrf_token</strong></em></td>\n<td>Domain</td>\n<td>A Contao system cookie. The Contao CSRF cookie prevents CSRF attacks.</td>\n<td>Session</td>\n</tr>\n</tbody>\n</table>'),
(31, 1614778178, 6, 'en', 'Cookie Consent', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Lenghth of storage</th>\n</tr>\n<tr>\n<td><em><strong>cconsent</strong></em></td>\n<td>Domain</td>\n<td>Saves the settings of the Cookie consent tool.</td>\n<td>1 year</td>\n</tr>\n</tbody>\n</table>'),
(34, 1614778424, 11, 'en', 'Google Analytics', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>_ga</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Google Analytics can recognise returning users of this website and merge the data with previous visits.</td>\n<td>2 years</td>\n</tr>\n<tr>\n<td><em><strong>_gid</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID. Based on this ID, Google Analytics can recognise returning users of this website and merge the data with previous visits.</td>\n<td>24 hours</td>\n</tr>\n<tr>\n<td><em><strong>_gat</strong></em></td>\n<td>Domain</td>\n<td>Certain data is only sent to Google Analytics a maximum of once per minute. The cookie has a lifetime of one minute. As long as it is set, specific data transmissions are prevented.</td>\n<td>1 minute</td>\n</tr>\n<tr>\n<td><em><strong>_dc_gtm_xxx</strong></em></td>\n<td>Domain</td>\n<td>Certain data is only sent to Google Analytics a maximum of once per minute. The cookie has a lifetime of one minute. As long as it is set, specific data transmissions are prevented.</td>\n<td>1 minute</td>\n</tr>\n<tr>\n<td><em><strong>_gat_gtag_xxx</strong></em></td>\n<td>Domain</td>\n<td>Certain data is only sent to Google Analytics a maximum of once per minute. The cookie has a lifetime of one minute. As long as it is set, specific data transmissions are prevented.</td>\n<td>1 minute</td>\n</tr>\n<tr>\n<td><em><strong>_gac_xxx</strong></em></td>\n<td>Domain</td>\n<td>This cookie is set when a user arrives on the website by clicking on a Google ad. It contains information about which ad was subsequently clicked on so that successful outcomes such as orders or contact requests can be attributed to the ad.</td>\n<td>90 days</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Contains a randomly generated user ID. Using this ID, Google can recognise the user across different websites and display personalised advertising.</td>\n<td>1 year</td>\n</tr>\n</tbody>\n</table>'),
(37, 1614778520, 12, 'en', 'Google Ads &#40;Remarketing and Conversion Tracking&#41;', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>test_cookie</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Is set as a test in order to check whether the browser allows cookies to be set. Does not contain any identification features.</td>\n<td>15 minutes</td>\n</tr>\n<tr>\n<td><em><strong>IDE</strong></em></td>\n<td>doubleclick.net<br>(3rd Party)</td>\n<td>Contains a randomly generated user ID. Using this ID, Google can recognise the user across different websites and display personalised advertising.</td>\n<td>1 year</td>\n</tr>\n</tbody>\n</table>'),
(40, 1614778604, 14, 'en', 'Google Ads Conversion', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>_gcl_au</strong></em></td>\n<td>Domain</td>\n<td>Contains a randomly generated user ID.</td>\n<td>90 days</td>\n</tr>\n<tr>\n<td><em><strong>_gcl_aw</strong></em></td>\n<td>Domain</td>\n<td>This cookie is set when a user accesses the website by clicking on a Google ad. It contains information about which ad has been clicked on so that successes such as orders or contact requests can be assigned to the ad.</td>\n<td>90 days</td>\n</tr>\n</tbody>\n</table>'),
(43, 1614778675, 7, 'en', 'Google ReCaptcha', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>_GRECAPTCHA</strong></em></td>\n<td>Domain</td>\n<td>This is a service that checks whether data entered on the website is entered by a human or by an automated programme.</td>\n<td>6 months</td>\n</tr>\n</tbody>\n</table>'),
(46, 1614778748, 16, 'en', 'Google Maps', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>google.com</td>\n<td>Used to unlock Google Maps content.</td>\n<td>6 months</td>\n</tr>\n</tbody>\n</table>'),
(49, 1614778792, 15, 'en', 'YouTube', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>google.com</td>\n<td>Used to unlock YouTube content.</td>\n<td>6 months</td>\n</tr>\n</tbody>\n</table>'),
(52, 1614778837, 5, 'en', 'Vimeo', '<table>\n<tbody>\n<tr>\n<th>Cookie</th>\n<th>Scope</th>\n<th>Purpose</th>\n<th>Length of storage</th>\n</tr>\n<tr>\n<td><em><strong>NID</strong></em></td>\n<td>google.com</td>\n<td>Used to unlock Vimeo content.</td>\n<td>2 years</td>\n</tr>\n</tbody>\n</table>');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
