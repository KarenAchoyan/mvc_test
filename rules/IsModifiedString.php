<?php

namespace rules;

class IsModifiedString implements RuleInterface
{
    private string $arg1;
    private string $arg2;

    public function __construct(string $arg1, string $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }

    public function handle(): bool
    {
        return $this->arg1 !== $this->arg2;
    }

    public function message(string $attribute): string
    {
        return "The attribute $attribute can't be modified.";
    }
}