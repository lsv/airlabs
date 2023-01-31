<?php

declare(strict_types=1);

namespace Lsv\Airlabs\Serializer;

use Lsv\Airlabs\Response\AirlineResponse;
use Lsv\Airlabs\Response\AirportResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @infection-ignore-all
 */
class IntToBoolNormalizer implements DenormalizerInterface
{
    /**
     * @var array<string, array<string>>
     */
    private static $fields = [
        AirlineResponse::class => [
            'iosa_registered',
            'is_scheduled',
            'is_passenger',
            'is_cargo',
            'is_international',
        ],
        AirportResponse::class => [
            'is_international',
            'is_major',
        ],
    ];

    public function __construct(
        private readonly DenormalizerInterface $denormalizer
    ) {
    }

    /**
     * @param array<mixed> $context Options available to the denormalizer
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        foreach (self::$fields[$type] as $field) {
            // @codeCoverageIgnoreStart
            if (!is_array($data)) {
                continue;
            }
            // @codeCoverageIgnoreEnd

            // @codeCoverageIgnoreStart
            if (!isset($data[$field])) {
                continue;
            }
            // @codeCoverageIgnoreEnd

            $data[$field] = (bool) $data[$field];
        }

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return array_key_exists($type, self::$fields);
    }
}
