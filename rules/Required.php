<?php

namespace rules;

class Required implements RuleInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function handle(): bool
    {
        return $this->value === '';
    }

    public function message(string $attribute): string
    {
        return "The Attribute $attribute is required.";
    }
}