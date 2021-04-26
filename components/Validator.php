<?php

namespace components;

use rules\RuleInterface;

class Validator
{
    protected array $rules;

    protected array $errorMessages;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
        $this->errorMessages = [];
    }

    public function validate(): bool
    {
        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                if (! $rule instanceof RuleInterface) {
                    throw new \RuntimeException('Undefined rule is provided.');
                }

                if ($rule->handle())
                {
                    $this->errorMessages[] = $rule->message($attribute);
                }
            }
        }

        return ! $this->errorMessages;
    }


    public function errors(): array
    {
        return $this->errorMessages;
    }
}