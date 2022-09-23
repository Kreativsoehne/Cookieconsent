<?php

namespace Kreativsoehne\Cookieconsent\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ContentElement(ToogleCookieconsentController::TYPE, category="miscellaneous", template="ce_ks_cookieconsent_toggle")
 */
class ToogleCookieconsentController extends AbstractContentElementController
{
    /** @var string */
    public const TYPE = 'kreativsoehne_cookieconsent';

    /** @inheritDoc */
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        return $template->getResponse();
    }
}
