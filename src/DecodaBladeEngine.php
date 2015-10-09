<?php
namespace Mandark\BBCode;

use Decoda\Engine\AbstractEngine;

class DecodaBladeEngine extends AbstractEngine
{
    /**
     * Renders a BBcode-tag using a laravel blade template.
     *
     * @param array $tag
     * @param string $content
     * @return string
     */
    public function render(array $tag, $content)
    {
        $setup = $this->getFilter()->getTag($tag['tag']);

        $attributes = $tag['attributes'];
        $attributes['content'] = $content;

        return view('laravel-decoda::'.$setup['template'])->with($attributes)->render();
    }
}