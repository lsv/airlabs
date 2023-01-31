<?php

declare(strict_types=1);

namespace Lsv\Airlabs;

use Symfony\Component\OptionsResolver\OptionsResolver;

trait DefaultOptionsTrait
{
    /**
     * @param array<string, callable|null> $options
     */
    private function setDefinedOptions(OptionsResolver $resolver, array $options): void
    {
        $resolver->setDefined(array_keys($options));
        foreach ($options as $key => $value) {
            if (is_callable($value)) {
                $resolver->setAllowedValues($key, $value);
            }
        }
    }

    private static function validateIso2CountryCode(): callable
    {
        return function (?string $value) {
            if (null === $value) {
                return true;
            }

            if (2 !== strlen($value)) {
                return false;
            }

            return true;
        };
    }

    private static function validateHexInput(): callable
    {
        return function (?string $value) {
            if (null === $value) {
                return true;
            }

            if (6 !== strlen($value)) {
                return false;
            }

            return ctype_xdigit($value);
        };
    }
}
