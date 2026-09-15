<?php
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
$app = Factory::getApplication();
?>
<!doctype html><html lang="<?php echo $this->language; ?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8'); ?></title><link rel="stylesheet" href="<?php echo $this->baseurl; ?>/media/templates/site/roja_portal/css/template.css"></head><body class="rp-error"><main class="rp-error-card"><div class="rp-wordmark">ROJA PORTAL</div><h1>Situs sedang dalam pemeliharaan</h1><p><?php echo htmlspecialchars((string) $app->get('offline_message'), ENT_QUOTES, 'UTF-8'); ?></p></main></body></html>
