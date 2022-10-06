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

class CategoryMigration extends AbstractMigration
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
        return 'Cookieconsent migration for inserting common categories';
    }

    /** @inheritDoc */
    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        // Only run if the table exist
        if (
            false === $schemaManager->tablesExist(['tl_ks_cc_category']) &&
            false === $schemaManager->tablesExist(['tl_ks_cc_category_language'])
        ) {
            return false;
        }

        // Only run if the table is empty
        $id = $this->connection->fetchOne('SELECT id FROM tl_ks_cc_category');
        if (false === empty($id)) {
            return false;
        }

        // Only run if the table is empty
        $id = $this->connection->fetchOne('SELECT id FROM tl_ks_cc_category_language');
        if (false === empty($id)) {
            return false;
        }

        return true;
    }

    /** @inheritDoc */
    public function run(): MigrationResult
    {
        $resultCategory = $this->runCategoryMigration();
        $resultCategoryLanguage = $this->runCategoryLanguageMigration();

        return $this->createResult(
            $resultCategory && $resultCategoryLanguage,
            'Created categories with en & de translations.'
        );
    }

    /**
     * Run category migration.
     * @return bool
     */
    protected function runCategoryMigration(): bool
    {
        $categoryStatement = $this->connection->prepare("
            INSERT INTO `tl_ks_cc_category` (`id`, `tstamp`, `sorting`, `pid`, `alias`, `needed`, `wanted`, `checked`, `published`) VALUES
            (1, 1614777969, 0, 0, 'necessary', '1', '1', '1', '1'),
            (2, 1614777939, 0, 0, 'analytics', '', '', '', '1'),
            (4, 1614777824, 128, 0, 'presentation', '', '', '', '1'),
            (6, 1614777877, 64, 0, 'measurement', '', '', '', '1'),
            (7, 1614777909, 0, 0, 'advertising', '', '', '', '1'),
            (8, 1614345924, 80, 0, 'recommendations', '', '', '', ''),
            (9, 1614777851, 96, 0, 'security', '', '', '', '1');
        ");

        $result = $categoryStatement->execute();
        return $result->rowCount() > 0;
    }

    /**
     * Run category language migration.
     * @return bool
     */
    protected function runCategoryLanguageMigration(): bool
    {
        $categoryLanguageStatement = $this->connection->prepare("
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
            (17, 1614777778, 4, 'en', 'Presentation', '<p>Cookies to improve functionalities and enable personalisation, for example for the integration of videos and the use of social media.</p>'),
            (18, 1614174336, 8, 'en', 'Individual recommendations', '<p>Certain functions of websites and apps serve to show users product alternatives or to increase purchasing incentives. With so-called recommendations, the customer is offered a wide variety of alternatives in addition to the product he is looking for. The behavior of the user and the shopping cart are analyzed and a forecast is made in real time which product the website visitor might like. It is also possible to display product recommendations based on product similarities in a category or to include manually assigned recommendations, such as accessories or bundled products.</p>');
        ");

        $result = $categoryLanguageStatement->execute();
        return $result->rowCount() > 0;
    }
}
