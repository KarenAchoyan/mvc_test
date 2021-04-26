<?php

namespace rules;

interface RuleInterface
{
    public function handle(): bool;

    public function message(string $attribute): string;
}