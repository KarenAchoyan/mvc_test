<?php

namespace rules;

class Email implements RuleInterface
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle(): bool
    {
        return ! filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function message(string $attribute): string
    {
        return "The attribute $attribute is invalid";
    }
}