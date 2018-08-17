<?php

namespace DsWeb\ViewModel\Common;

class CssLinkViewModel extends AbstractAssetViewModel
{
    public function __construct(string $link, bool $local = true)
    {
        parent::__construct($link, 'css', $local);

        $this->setView('common/css-link');
    }
}