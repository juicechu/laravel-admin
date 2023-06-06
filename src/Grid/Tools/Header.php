<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Grid;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Query\Builder;

class Header extends AbstractTool
{
    /**
     * @var Builder
     */
    protected $queryBuilder;
    /**
     * @var array
     */
    protected $style = [];

    /**
     * Header constructor.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid, $style = [])
    {
        $this->grid = $grid;
        $this->setStyle($style);
    }

    /**
     * Get model query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function queryBuilder()
    {
        if (!$this->queryBuilder) {
            $this->queryBuilder = $this->grid->model()->getQueryBuilder();
        }

        return $this->queryBuilder;
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
     * {@inheritdoc}
     */
    public function render()
    {
        $content = call_user_func($this->grid->header(), $this->queryBuilder());

        if (empty($content)) {
            return '';
        }

        if ($content instanceof Renderable) {
            $content = $content->render();
        }

        if ($content instanceof Htmlable) {
            $content = $content->toHtml();
        }

        $class = implode(' ', $this->style);
        return <<<HTML
    <div class="box-header with-border clearfix {$class}">
        {$content}
    </div>
HTML;
    }
}
