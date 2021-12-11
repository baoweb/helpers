<?php

namespace Baoweb\Helpers\Traits;

trait AllowsCzechNumbers
{
    protected function getCzechNumericFields(): array
    {
        if (property_exists($this, 'czech_numeric_fields')) {
            return $this->czech_numeric_fields;
        }

        return [];
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getCzechNumericFields(), true)) {
            $value = str_replace(',', '.', $value);

            $value = (float) $value;
        }

        return parent::setAttribute($key, $value);
    }

}
