<?php

namespace Orkester\UI;
/**
 * MScripts Class.
 * An auxiliary class to MPage to handle Javascript scripts.
 */

use Ds\Map;
use Orkester\Manager;

class MScripts
{
    private Map $onsubmit;
    /**
     * @var Map
     */
    private Map $onload;
    /**
     * @var Map
     */
    private Map $onerror;
    /**
     * @var Map
     */
    private Map $onunload;
    /**
     * @var Map
     */
    private Map $onfocus;
    /**
     * @var Map
     */
    private Map $jsCode;
    /**
     * @var Map
     */
    private Map $scripts;
    /**
     * @var Map
     */
    private Map $customScripts;
    /**
     * @var Map
     */
    private Map $events;

    public function __construct($id)
    {
        $this->onsubmit = new Map();
        $this->onload = new Map();
        $this->onerror = new Map();
        $this->onunload = new Map();
        $this->onfocus = new Map();
        $this->jsCode = new Map();
        $this->scripts = new Map();
        $this->customScripts = new Map();
        $this->events = new Map();
    }

    public function addScript(string $url)
    {
        $url = Manager::getAppURL("public/scripts/{$url}");
        $key = md5($url);
        if (!$this->scripts->hasKey($key)) {
            $this->scripts->put($key, $url);
        }
    }

    public function addScriptURL(string $url)
    {
        $key = md5($url);
        if (!$this->scripts->hasKey($key)) {
            $this->scripts->put($key, $url);
        }
    }

    public function insertScript($url)
    {
        $url = Manager::getBaseURL() . 'html/scripts/' . $url;
        $key = md5($url);
        $this->scripts->put($key, $url);
    }

    public function addOnSubmit(string $idForm, string $jsCode)
    {
        $key = $idForm;
        $this->onsubmit->put($key, $jsCode);
    }

    public function addJsCode(string $jsCode)
    {
        $key = md5($jsCode);
        $this->jsCode->put($key, $jsCode);
    }

    public function addOnLoad(string $jsCode)
    {
        $key = md5($jsCode);
        $this->onload->put($key, $jsCode);
    }

    public function getScripts(): object
    {
        if (count($this->events) > 0) {
            $events = json_encode($this->events);
            $this->addOnload("manager.registerEvents(" . $events . ");");
        }

        $scripts = new \StdClass;
        $scripts->scripts = $scripts->code = $scripts->onload = $scripts->onsubmit = '';

        foreach ($this->scripts as $key => $url) {
            $scripts->scripts .= "\n manager.loader.load('{$url}');";
        }

        foreach ($this->jsCode as $key => $code) {
            $scripts->code .= "\n {$code}";
        }

        foreach ($this->onload as $key => $code) {
            $scripts->onload .= "\n {$code}";
        }

        $onsubmit = '';
        foreach ($this->onsubmit as $idForm => $list) {
            $onsubmit .= "manager.onSubmit[\"{$idForm}\"] = function() { return {$list}; }";
        }
        $scripts->onsubmit = $onsubmit;
        return $scripts;
    }

    public static function tag($content): string
    {
        return "<script type=\"text/javascript\">{$content}</script>\n";
    }

}
