<?php
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
/** @var Joomla\CMS\Document\ErrorDocument $this */
$app = Factory::getApplication();
$code = (int) $this->error->getCode();
?>
<!doctype html><html lang="<?php echo $this->language; ?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo $code; ?> - <?php echo htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8'); ?></title><link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/templates/site/roja_portal/css/template.css"></head><body class="rp-error"><main class="rp-error-card"><div class="rp-error-code"><?php echo $code; ?></div><h1><?php echo Text::_('TPL_ROJA_ERROR_TITLE'); ?></h1><p><?php echo Text::_('TPL_ROJA_ERROR_MESSAGE'); ?></p><a class="rp-button" href="<?php echo $this->baseurl; ?>/"><?php echo Text::_('TPL_ROJA_HOME_LINK'); ?></a></main></body></html>
