<?php

$path = 'system/modules/kreativsoehne_cookieconsent';

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Kreativsoehne\Cookieconsent',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'Kreativsoehne\Cookieconsent\TemplateListener' => $path . '/src/Kreativsoehne/Cookieconsent/TemplateListener.php',
));

/*
 * Register the templates
 */
TemplateLoader::addFiles([
    'kreativsoehne_cookieconsent' => $path . '/templates',
]);
