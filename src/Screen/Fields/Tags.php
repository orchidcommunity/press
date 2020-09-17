<?php

declare(strict_types=1);

namespace Orchid\Press\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Tags.
 *
 * @method Tags accept($value = true)
 * @method Tags accesskey($value = true)
 * @method Tags autocomplete($value = true)
 * @method Tags autofocus($value = true)
 * @method Tags checked($value = true)
 * @method Tags disabled($value = true)
 * @method Tags form($value = true)
 * @method Tags formaction($value = true)
 * @method Tags formenctype($value = true)
 * @method Tags formmethod($value = true)
 * @method Tags formnovalidate($value = true)
 * @method Tags formtarget($value = true)
 * @method Tags list($value = true)
 * @method Tags max(int $value)
 * @method Tags maxlength(int $value)
 * @method Tags min(int $value)
 * @method Tags multiple($value = true)
 * @method Tags name(string $value)
 * @method Tags pattern($value = true)
 * @method Tags placeholder(string $value = null)
 * @method Tags readonly($value = true)
 * @method Tags required(bool $value = true)
 * @method Tags size($value = true)
 * @method Tags src($value = true)
 * @method Tags step($value = true)
 * @method Tags tabindex($value = true)
 * @method Tags type($value = true)
 * @method Tags value($value = true)
 * @method Tags help(string $value = null)
 * @method Tags popover(string $value = null)
 */
class Tags extends Field
{
    /**
     * @var string
     */
    public $view = 'press::fields.tags';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'    => 'form-control',
        'multiple' => 'multiple',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accept',
        'accesskey',
        'autocomplete',
        'autofocus',
        'checked',
        'disabled',
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'list',
        'max',
        'maxlength',
        'min',
        'multiple',
        'name',
        'pattern',
        'placeholder',
        'readonly',
        'required',
        'size',
        'src',
        'step',
        'tabindex',
        'type',
        'value',
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * @param string|\Closure $name
     *
     * @return \Orchid\Screen\Field|void
     */
    public function modifyName()
    {
        $name = $this->get('name');
        if (substr($name, -1) !== '.') {
            $this->attributes['name'] = $name.'[]';
        }

        parent::modifyName();

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function modifyValue()
    {
        $value = $this->getOldValue() ?: $this->get('value');
        if (is_string($value)) {
            $this->attributes['value'] = explode(',', $value);
        }

        if ($value instanceof \Closure) {
            $this->attributes['value'] = $value($this->attributes);
        }

        if (is_null($value)) {
            $this->attributes['value'] = [];
        }

        return $this;
    }
}
