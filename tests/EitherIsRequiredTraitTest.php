<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests;

use Lsv\Airlabs\EitherIsRequiredTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EitherIsRequired
{
    use EitherIsRequiredTrait;

    public function required(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['iata', 'icao']);
        $this->eitherIsRequiredButNotBoth($resolver, 'iata', 'icao');
    }

    public function notRequiredButNotBoth(OptionsResolver $resolver): void
    {
        $resolver->setDefined(['iata', 'icao']);
        $this->eitherCanBeNullButNotBothCanHaveValue($resolver, 'iata', 'icao');
    }
}

class EitherIsRequiredTraitTest extends TestCase
{
    public function testOneMustBeSet(): void
    {
        $this->expectException(InvalidOptionsException::class);
        $this->expectExceptionMessage('Both fields (iata, icao) can not be null');

        $resolver = new OptionsResolver();

        $obj = new EitherIsRequired();
        $obj->required($resolver);

        $resolver->resolve(['iata' => null, 'icao' => null]);
    }

    public function testBothCanNotBeSet(): void
    {
        $this->expectException(InvalidOptionsException::class);
        $this->expectExceptionMessage('Both fields (iata, icao) can not have a value');

        $resolver = new OptionsResolver();

        $obj = new EitherIsRequired();
        $obj->required($resolver);

        $resolver->resolve(['iata' => 'iata', 'icao' => 'icao']);
    }

    public function testIataCanBeSet(): void
    {
        $this->expectNotToPerformAssertions();

        $resolver = new OptionsResolver();

        $obj = new EitherIsRequired();
        $obj->required($resolver);

        $resolver->resolve(['iata' => 'iata', 'icao' => null]);
    }

    public function testIcaoCanBeSet(): void
    {
        $this->expectNotToPerformAssertions();

        $resolver = new OptionsResolver();

        $obj = new EitherIsRequired();
        $obj->required($resolver);

        $resolver->resolve(['iata' => null, 'icao' => 'icao']);
    }

    public function testBothCanBeNull(): void
    {
        $this->expectNotToPerformAssertions();

        $resolver = new OptionsResolver();

        $obj = new EitherIsRequired();
        $obj->notRequiredButNotBoth($resolver);

        $resolver->resolve(['iata' => null, 'icao' => null]);
    }

    public function testBothCanNotBeSetAtTheSameTime(): void
    {
        $this->expectException(InvalidOptionsException::class);
        $this->expectExceptionMessage('Both fields (iata, icao) can not have a value');

        $resolver = new OptionsResolver();

        $obj = new EitherIsRequired();
        $obj->notRequiredButNotBoth($resolver);

        $resolver->resolve(['iata' => 'iata', 'icao' => 'icao']);
    }
}
