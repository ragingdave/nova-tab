<?php

namespace Arsenaltech\NovaTab;

use Illuminate\Http\Resources\MergeValue;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Panel;

class NovaTab extends MergeValue implements \JsonSerializable
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-tab';

    /**
     * The name of the panel.
     *
     * @var string
     */
    public $name;

    /**
     * The panel fields.
     *
     * @var array
     */
    public $data;

    public $panel;

    /**
     * Create a new panel instance.
     *
     * @param  string  $name
     * @param  \Closure|array  $fields
     * @return void
     */
    public function __construct($name, $fields = [])
    {
        $this->name = $name;

        parent::__construct($this->prepareFields($fields));
    }

    /**
     * Prepare the panel for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'component' => 'nova-tab',
            'name' => $this->name,
            'prefixComponent' => true,
            'panel' => $this->panel,
            'indexName' => $this->name
        ];
    }

    /**
     * Prepare the given fields.
     *
     * @param  \Closure|array  $fields
     * @return array
     */
    protected function prepareFields($fields)
    {
        return collect(is_callable($fields) ? $fields() : $fields)->each(function ($field) {
            if($field instanceof Field) {
                $field->withMeta(['tab' => $this->name]);
            }
        })->all();
    }
}
