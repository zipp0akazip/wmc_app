<?php

namespace App\Models\Parsers\Telegram;

class StylesCollection
{
    private array $styles = [];

    public function fillByString(string $styles): void
    {
        $styles = str_ireplace(['style:', 'style'], '', $styles);
        $styles = trim($styles);
        $styles = explode('#', $styles);
        $styles = array_map(fn($value) => str_replace([','], '', $value), $styles);
        $styles = array_map('trim', $styles);
        $styles = array_filter($styles, fn($value) => !is_null($value) && $value !== '');

        foreach ($styles as $style) {
            $styleModel = resolve(Style::class);
            $styleModel->setName($style);

            $this->add($styleModel);
        }
    }

    public function add(Style $style): void
    {
        $this->styles[] = $style;
    }

    public function getStyles(): array
    {
        return $this->styles;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->styles as $style) {
            $result[] = $style->toArray();
        }

        return $result;
    }
}
