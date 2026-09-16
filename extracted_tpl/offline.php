<?php
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
$app = Factory::getApplication();
$sitename = htmlspecialchars((string) $app->get('sitename'), ENT_QUOTES, 'UTF-8');
$offlineMessage = htmlspecialchars((string) $app->get('offline_message'), ENT_QUOTES, 'UTF-8');
?>
<!doctype html><html lang="<?php echo $this->language; ?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo $sitename; ?></title><link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/templates/site/roja_portal/css/template.css"></head><body class="rp-error"><main class="rp-error-card"><div class="rp-wordmark"><?php echo $sitename ?: Text::_('TPL_ROJA_BRAND_NAME'); ?></div><h1><?php echo Text::_('TPL_ROJA_OFFLINE_TITLE'); ?></h1><p><?php echo $offlineMessage ?: Text::_('TPL_ROJA_OFFLINE_DEFAULT_MESSAGE'); ?></p></main></body></html>
