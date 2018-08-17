<?php

namespace DsWeb\ViewModel\Common;

class JsLinkViewModel extends AbstractAssetViewModel
{
    public function __construct(string $link, bool $local = true)
    {
        parent::__construct($link, 'js', $local);

        $this->setView('common/js-link');
    }
}