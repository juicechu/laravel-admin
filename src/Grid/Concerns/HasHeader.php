<?php

namespace Encore\Admin\Grid\Concerns;

use Closure;
use Encore\Admin\Grid\Tools\Header;

trait HasHeader
{
    /**
     * @var Closure
     */
    protected $header;
    /**
     * @var array
     */
    protected $style = [];

    /**
     * Set grid header.
     *
     * @param Closure|null $closure
     *
     * @return $this|Closure
     */
    public function header(Closure $closure = null, $style = [])
    {
        if (!$closure) {
            return $this->header;
        }

        $this->header = $closure;
        $this->setStyle($style);

        return $this;
    }

    /**
     * Set table style.
     *
     * @param array $style
     *
     * @return $this
     */
    public function setStyle($style = [])
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return string
     */
    public function renderHeader()
    {
        if (!$this->header) {
            return '';
        }

        return (new Header($this, $this->style))->render();
    }
}
