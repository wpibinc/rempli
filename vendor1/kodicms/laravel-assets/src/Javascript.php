<?php

namespace KodiCMS\Assets;

use Illuminate\Contracts\Support\Htmlable;
use KodiCMS\Assets\Contracts\AssetElementInterface;

class Javascript implements AssetElementInterface
{
    /**
     * @var string
     */
    protected $handle;

    /**
     * @var string
     */
    protected $src;

    /**
     * @var array
     */
    protected $dependency = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var bool
     */
    protected $footer = false;

    /**
     * Css constructor.
     *
     * @param string $handle
     * @param string $src
     * @param array  $dependency
     * @param bool   $footer
     * @param array  $attributes
     */
    public function __construct($handle, $src, $dependency = [], $footer = false, array $attributes = [])
    {
        if (!is_array($dependency)) {
            $dependency = [$dependency];
        }

        $this->handle = $handle;
        $this->src = $src;
        $this->dependency = array_unique($dependency);
        $this->footer = (bool) $footer;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return array
     */
    public function getDependency()
    {
        return $this->dependency;
    }

    /**
     * @param string|array $dependency
     *
     * @return array
     */
    public function hasDependency($dependency = null)
    {
        if (is_null($dependency)) {
            return !empty($this->dependency);
        }

        return in_array($dependency, $this->dependency);
    }

    /**
     * @param string $dependency
     *
     * @return array
     */
    public function removeDependency($dependency)
    {
        if (($key = array_search($dependency, $this->dependency)) !== false) {
            unset($this->dependency[$key]);
        }
    }

    public function includeDependency()
    {
        app('assets')->loadPackage($this->getDependency());
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function isFooter()
    {
        return $this->footer;
    }

    /**
     * @param bool $footer
     */
    public function setFooter($footer)
    {
        $this->footer = (bool) $footer;
    }

    /**
     * @return string
     */
    public function render()
    {
        return app('html')->script($this->getSrc(), $this->getAttributes());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = $this->render();

        if ($output instanceof Htmlable) {
            $output = $output->toHtml();
        }

        return $output;
    }
}
