<?php

namespace DsWeb\ViewModel;

use DsWeb\Config;
use Zend\View\Model\ViewModel;

class AbstractVM extends ViewModel
{
    const TEMPLATE_DIR = 'view';

    public function setView(string $template)
    {
        $viewDir = $this->getConfig()->getBaseDir() . '/' . self::TEMPLATE_DIR;
        $template = "${viewDir}/${template}.phtml";
        $this->setTemplate($template);
    }

    public function getConfig () : Config
    {
        return Config::getInstance();
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return $this->captureMarkup();
    }

    public function render()
    {
        if (file_exists($this->template) && !is_dir($this->template)){
            include ($this->getTemplate());
        }
    }

    public function captureMarkup()
    {
        ob_start();
        $this->render();
        $vm = ob_get_contents();
        ob_end_clean();
        return $vm;
    }
}