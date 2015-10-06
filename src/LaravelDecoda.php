<?php

namespace Mandark\Decoda;

use Decoda\Decoda;
use Decoda\Filter\BlockFilter;
use Decoda\Filter\CodeFilter;
use Decoda\Filter\DefaultFilter;
use Decoda\Filter\EmailFilter;
use Decoda\Filter\ImageFilter;
use Decoda\Filter\ListFilter;
use Decoda\Filter\QuoteFilter;
use Decoda\Filter\TableFilter;
use Decoda\Filter\TextFilter;
use Decoda\Filter\UrlFilter;
use Decoda\Filter\VideoFilter;
use Decoda\Hook\CensorHook;
use Decoda\Hook\ClickableHook;
use Decoda\Hook\EmoticonHook;

class LaravelDecoda {

    /**
     * Runs $content through Decoda
     * to decode BBcode, parse emoticons and links, or censor words.
     *
     * @param string $content
     * @return string
     */
    public static function decode($content='')
    {
        // First make sure, the content is HTML entities encoded.
        $content = e($content);

        // Instantiate the Decoda-object.
        // We use null as the configPath to keep Decoda from using
        // it's built in (emoticon- and censorship-configs),
        // since we load these from our own laravel-config.
        $code = new Decoda($content, ['configPath' => null]);
        $code->setEngine(new DecodaBladeEngine());
        $code->setStrict(false);

        // Add filter for default tags, if at least one is enabled.
        if (
            config('laravel-decoda.bbcode.tags.b') ||
            config('laravel-decoda.bbcode.tags.i') ||
            config('laravel-decoda.bbcode.tags.u') ||
            config('laravel-decoda.bbcode.tags.s') ||
            config('laravel-decoda.bbcode.tags.sup') ||
            config('laravel-decoda.bbcode.tags.sub')
        ) {
            $code->addFilter(new DefaultFilter());
        }

        // Add filter for block-quotes, if enabled.
        if (config('laravel-decoda.bbcode.tags.quote')) {
            $code->addFilter(new QuoteFilter());
        }

        // Add filter for image-tags, if enabled.
        if (config('laravel-decoda.bbcode.tags.img') || config('laravel-decoda.emoticons.enabled')) {
            $code->addFilter(new ImageFilter());
        }

        // Add filter for video-tags, if enabled.
        if (config('laravel-decoda.bbcode.tags.video')) {
            $code->addFilter(new VideoFilter());
        }

        // Add filter for url-tags, if enabled.
        if (config('laravel-decoda.bbcode.tags.url') || config('laravel-decoda.auto_links')) {
            $code->addFilter(new UrlFilter());
        }

        // Add filter for list tags, if enabled.
        if (
            config('laravel-decoda.bbcode.tags.list') ||
            config('laravel-decoda.bbcode.tags.olist')
        ) {
            $code->addFilter(new ListFilter());
        }

        // Add filter for font tags, if enabled.
        if (
            config('laravel-decoda.bbcode.tags.font') ||
            config('laravel-decoda.bbcode.tags.size') ||
            config('laravel-decoda.bbcode.tags.color')
        ) {
            $code->addFilter(new TextFilter());
        }

        // Add filter for text-alignment.
        if (
            config('laravel-decoda.bbcode.tags.left') ||
            config('laravel-decoda.bbcode.tags.center') ||
            config('laravel-decoda.bbcode.tags.right')
        ) {
            $code->addFilter(new BlockFilter());
        }

        // Add filter for block-quotes, if enabled.
        if (config('laravel-decoda.bbcode.tags.code')) {
            $code->addFilter(new CodeFilter());
        }

        // Add filter for block-quotes, if enabled.
        if (config('laravel-decoda.bbcode.tags.table')) {
            $code->addFilter(new TableFilter());
        }

        // Add hook for emoticons, if enabled.
        if (config('laravel-decoda.emoticons.enabled')) {
            $emoticonHook = new EmoticonHook(array('path' => config('laravel-decoda.emoticons.path')));
            $emoticonHook->addLoader(new DecodaLaravelConfigLoader('laravel-decoda.emoticons.list'));
            $code->addHook($emoticonHook);
        }

        // Add hook for censorship, if enabled.
        if (config('laravel-decoda.censorship.enabled')) {
            $censorshipHook = new CensorHook();
            $censorshipHook->addLoader(new DecodaLaravelConfigLoader('laravel-decoda.censorship.list'));
            $code->addHook($censorshipHook);
        }

        // Add hook to automatically convert URLs and emails (not wrapped in tags) into clickable links.
        if (config('laravel-decoda.auto_links')) {
            $code->addFilter(new EmailFilter());
            $code->addHook(new ClickableHook());
        }

        $content = $code->parse();

        // Finally convert nl2br.
        $content = nl2br($content);

        return $content;
    }

    /**
     * Returns a full BBcode quote for this post.
     *
     * @return string
     */
    public function getQuoteAttribute()
    {
        return '[quote='.$this->authorName.']'.$this->content.'[/quote]';
    }

    /**
     * Returns the route to a reply to the current post (for usage with "Quote Reply").
     *
     * @return mixed
     */
    public function getReplyRouteAttribute()
    {
        return $this->getRoute('forum.get.reply.thread');
    }
}