<?php
defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\Component\Content\Site\Helper\RouteHelper;

final class RojaPortalComments
{
    public static function render(object $article, object $app): string
    {
        $input = $app->getInput();
        if (!$app->isClient('site') || $input->getCmd('option') !== 'com_content'
            || $input->getCmd('view') !== 'article' || $input->getCmd('tmpl') === 'component'
            || $input->getInt('print', 0)) {
            return '';
        }

        $settings = $app->getTemplate(true)->params;
        $shortname = strtolower(trim((string) $settings->get('disqusShortname', '')));
        // A shortname is a single DNS label, never a URL or arbitrary script host.
        if (!$settings->get('commentsEnabled', 0)
            || !preg_match('/\A[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\z/D', $shortname)) {
            return '';
        }

        // Disqus threads are public. Never embed private, unpublished or expired articles.
        $now = gmdate('Y-m-d H:i:s');
        if ((int) ($article->id ?? 0) < 1 || (int) ($article->state ?? 0) !== 1
            || (int) ($article->access ?? 0) !== 1 || (int) ($article->category_access ?? 0) !== 1
            || empty($article->params) || !$article->params->get('access-view', false)
            || (!empty($article->publish_up) && $article->publish_up > $now)
            || (!empty($article->publish_down) && $article->publish_down !== '0000-00-00 00:00:00' && $article->publish_down < $now)) {
            return '';
        }

        $url = Route::link('site', RouteHelper::getArticleRoute(
            (int) $article->id . ':' . (string) ($article->alias ?? ''),
            (int) $article->catid,
            (string) ($article->language ?? '*')
        ), false, Route::TLS_IGNORE, true);
        $escape = static fn ($text): string => htmlspecialchars((string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $defaultHeading = Text::_('TPL_ROJA_COMMENTS_HEADING');
        $heading = trim((string) $settings->get('commentsHeading', $defaultHeading)) ?: $defaultHeading;
        $app->getDocument()->getWebAssetManager()->registerAndUseScript(
            'roja.comments', 'media/templates/site/roja_portal/js/comments.js',
            ['version' => 'auto'], ['defer' => true]
        );

        return '<section id="rp-comments" class="rp-comments" aria-labelledby="rp-comments-title"'
            . ' data-shortname="' . $escape($shortname) . '"'
            . ' data-identifier="joomla-article-' . (int) $article->id . '"'
            . ' data-url="' . $escape($url) . '" data-title="' . $escape($article->title) . '">'
            . '<h2 id="rp-comments-title">' . $escape($heading) . '</h2>'
            . '<p class="rp-comments-intro">' . $escape(Text::_('TPL_ROJA_COMMENTS_INTRO')) . '</p>'
            . '<button type="button" class="rp-button rp-comments-load" aria-controls="disqus_thread">' . $escape(Text::_('TPL_ROJA_SHOW_COMMENTS')) . '</button>'
            . '<p class="rp-comments-status" role="status" aria-live="polite"></p>'
            . '<div id="disqus_thread"></div>'
            . '<noscript>' . $escape(Text::_('TPL_ROJA_COMMENTS_NOSCRIPT')) . '</noscript>'
            . '</section>';
    }
}
