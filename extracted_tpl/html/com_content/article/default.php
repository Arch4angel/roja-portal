<?php
/**
 * ROJA Portal: render article details without the inherited menu page heading.
 * Delegate to Joomla's installed layout so core content features stay current.
 */
defined('_JEXEC') or die;

/** @var \Joomla\Component\Content\Site\View\Article\HtmlView $this */
$rojaOriginalViewParams = $this->params;
$this->params = clone $rojaOriginalViewParams;
$this->params->set('show_page_heading', 0);

try {
    require JPATH_SITE . '/components/com_content/tmpl/article/default.php';
} finally {
    // Do not change the shared menu/component parameters for other renderers.
    $this->params = $rojaOriginalViewParams;
}

require_once __DIR__ . '/roja_comments.php';
echo RojaPortalComments::render($this->item, \Joomla\CMS\Factory::getApplication());
