<?php

namespace Mandark\BBCode;

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

class LaravelBBCode {

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
            config('bbcode.tags.b') ||
            config('bbcode.tags.i') ||
            config('bbcode.tags.u') ||
            config('bbcode.tags.s') ||
            config('bbcode.tags.sup') ||
            config('bbcode.tags.sub')
        ) {
            $code->addFilter(new DefaultFilter());
        }

        // Add filter for block-quotes, if enabled.
        if (config('bbcode.tags.quote')) {
            $code->addFilter(new QuoteFilter());
        }

        // Add filter for image-tags, if enabled.
        if (config('bbcode.tags.img') || config('bbcode.emoticons.enabled')) {
            $code->addFilter(new ImageFilter());
        }

        // Add filter for video-tags, if enabled.
        if (config('bbcode.tags.video')) {
            $code->addFilter(new VideoFilter());
        }

        // Add filter for url-tags, if enabled.
        if (config('bbcode.tags.url') || config('bbcode.auto_links')) {
            $code->addFilter(new UrlFilter());
        }

        // Add filter for list tags, if enabled.
        if (
            config('bbcode.tags.list') ||
            config('bbcode.tags.olist')
        ) {
            $code->addFilter(new ListFilter());
        }

        // Add filter for font tags, if enabled.
        if (
            config('bbcode.tags.font') ||
            config('bbcode.tags.size') ||
            config('bbcode.tags.color')
        ) {
            $code->addFilter(new TextFilter());
        }

        // Add filter for text-alignment.
        if (
            config('bbcode.tags.left') ||
            config('bbcode.tags.center') ||
            config('bbcode.tags.right')
        ) {
            $code->addFilter(new BlockFilter());
        }

        // Add filter for block-quotes, if enabled.
        if (config('bbcode.tags.code')) {
            $code->addFilter(new CodeFilter());
        }

        // Add filter for block-quotes, if enabled.
        if (config('bbcode.tags.table')) {
            $code->addFilter(new TableFilter());
        }

        // Add hook for emoticons, if enabled.
        if (config('bbcode.emoticons.enabled')) {
            $emoticonHook = new EmoticonHook(array('path' => config('bbcode.emoticons.path')));
            $emoticonHook->addLoader(new DecodaLaravelConfigLoader('bbcode.emoticons.list'));
            $code->addHook($emoticonHook);
        }

        // Add hook for censorship, if enabled.
        if (config('bbcode.censorship.enabled')) {
            $censorshipHook = new CensorHook();
            $censorshipHook->addLoader(new DecodaLaravelConfigLoader('bbcode.censorship.list'));
            $code->addHook($censorshipHook);
        }

        // Add hook to automatically convert URLs and emails (not wrapped in tags) into clickable links.
        if (config('bbcode.auto_links')) {
            $code->addFilter(new EmailFilter());
            $code->addHook(new ClickableHook());
        }

        $content = $code->parse();

        // Finally convert nl2br.
        $content = nl2br($content);

        return $content;
    }

    /**
     * Returns a full BBcode quote for the stated $name and $content.
     *
     * @param string $name
     * @param string $content
     * @return string
     */
    public static function quote($name='',$content='')
    {
        return '[quote='.$name.']'.$content.'[/quote]';
    }
}