<?php
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
/** @var Joomla\CMS\Document\HtmlDocument $this */
$wa = $this->getWebAssetManager();
$wa->registerAndUseStyle('roja.portal', 'media/templates/site/roja_portal/css/template.css', ['version' => 'auto']);
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
?>
<!doctype html><html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"><head><jdoc:include type="metas" /><jdoc:include type="styles" /><jdoc:include type="scripts" /></head><body class="rp-component"><main class="rp-shell rp-main"><jdoc:include type="message" /><jdoc:include type="component" /></main></body></html>
