<?php

declare(strict_types=1);

namespace Lsv\AirlabsTests;

use Lsv\Airlabs\DefaultOptionsTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefaultOptions
{
    use DefaultOptionsTrait;

    public function test(OptionsResolver $resolver): void
    {
        $this->setDefinedOptions($resolver, [
            'country_code' => self::validateIso2CountryCode(),
            'hex' => self::validateHexInput(),
        ]);
    }
}

class DefaultOptionsTraitTest extends TestCase
{
    /**
     * @return iterable<array-key, array{string, bool}>
     */
    public function countryCodeProvider(): iterable
    {
        yield 'DK' => ['DK', false];
        yield 'D' => ['D', true];
        yield 'USA' => ['USA', true];
        yield 'denmark' => ['denmark', true];
    }

    /**
     * @dataProvider countryCodeProvider
     */
    public function testCountryCode(?string $value, bool $failed): void
    {
        if ($failed && $value) {
            $this->expectException(InvalidOptionsException::class);
            $this->expectExceptionMessage('The option "country_code" with value "'.$value.'" is invalid.');
        } else {
            $this->expectNotToPerformAssertions();
        }

        $resolver = new OptionsResolver();
        $object = new DefaultOptions();
        $object->test($resolver);
        $resolver->resolve(['country_code' => $value]);
    }

    /**
     * @return iterable<array-key, array{string, bool}>
     */
    public function hexInputProvider(): iterable
    {
        yield 'ABCDE' => ['ABCDE', true];
        yield 'ABCDEF' => ['ABCDEF', false];
        yield 'ABCDEI' => ['ABCDEI', true];
        yield 'QWERTY' => ['QWERTY', true];
    }

    /**
     * @dataProvider hexInputProvider
     */
    public function testHexInput(?string $value, bool $failed): void
    {
        if ($failed && $value) {
            $this->expectException(InvalidOptionsException::class);
            $this->expectExceptionMessage('The option "hex" with value "'.$value.'" is invalid.');
        } else {
            $this->expectNotToPerformAssertions();
        }

        $resolver = new OptionsResolver();
        $object = new DefaultOptions();
        $object->test($resolver);
        $resolver->resolve(['hex' => $value]);
    }
}
