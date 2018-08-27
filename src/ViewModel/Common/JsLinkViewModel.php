<?php

namespace DsWeb\ViewModel\Common;

class JsLinkViewModel extends AbstractAssetViewModel
{
    public function __construct(string $link, bool $local = true, $type = 'text/javascript')
    {
        parent::__construct($link, 'js', $local);

        $this->type = $type;

        $this->setView('common/js-link');
    }
}