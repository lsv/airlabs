<?php

declare(strict_types=1);

namespace Lsv\Airlabs;

use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait EitherIsRequiredTrait
{
    private function eitherIsRequiredButNotBoth(OptionsResolver $resolver, string $fieldOne, string $fieldTwo): void
    {
        $resolver->setNormalizer($fieldOne, function (Options $options, mixed $data) use ($fieldOne, $fieldTwo): mixed {
            if (null === $options[$fieldTwo] && null === $data) {
                throw new InvalidOptionsException(sprintf('Both fields (%s, %s) can not be null', $fieldOne, $fieldTwo));
            }

            if (null !== $options[$fieldTwo] && null !== $data) {
                throw new InvalidOptionsException(sprintf('Both fields (%s, %s) can not have a value', $fieldOne, $fieldTwo));
            }

            return $data;
        });
    }

    private function eitherCanBeNullButNotBothCanHaveValue(OptionsResolver $resolver, string $fieldOne, string $fieldTwo): void
    {
        $resolver->setNormalizer($fieldOne, function (Options $options, mixed $data) use ($fieldOne, $fieldTwo): mixed {
            if (null !== $options[$fieldTwo] && null !== $data) {
                throw new InvalidOptionsException(sprintf('Both fields (%s, %s) can not have a value', $fieldOne, $fieldTwo));
            }

            return $data;
        });
    }
}
