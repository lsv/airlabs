<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Serializer;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @infection-ignore-all
 */
class Serializer
{
    public static function create(): SerializerInterface
    {
        $reflectionExtractor = new ReflectionExtractor();

        $propertyTypeExtractor = new PropertyInfoExtractor(
            [$reflectionExtractor],
            [$reflectionExtractor],
            [],
            [$reflectionExtractor],
            [$reflectionExtractor]
        );

        $objectNormalizer = new ObjectNormalizer(
            nameConverter: new CamelCaseToSnakeCaseNameConverter(),
            propertyTypeExtractor: $propertyTypeExtractor,
        );

        $normalizers = [
            new IntToBoolNormalizer($objectNormalizer),
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            $objectNormalizer,
        ];

        $encoders = [
            new JsonEncoder(),
        ];

        return new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);
    }
}
