Airlabs API
-----------

![Workflow](https://github.com/lsv/airlabs/actions/workflows/ci.yml/badge.svg)

PHP Wrapper for [Airlabs APIs](https://airlabs.co/)

## Install

```bash
composer require lsv/airlabs
```

## Usage

### Quick example

To get flight information
```php
require 'vendor/autoload.php';
$apikey = '<your api key>';
$factory = new \Lsv\Airlabs\RequestFactory($apikey);

$request = new \Lsv\Airlabs\Request\FlightInformationRequest(
    flightCode: new \Lsv\Airlabs\Utils\IcaoIataCode(null, 'AA6')
);
$response = $factory->call($request);
echo $response->depTime; // Would write departure time for this aircraft
```

### Factory

```php
require 'vendor/autoload.php';
$apikey = '<your api key>';
$factory = new \Lsv\Airlabs\RequestFactory($apikey);

$request = instance of \Lsv\Airlabs\RequestInterface::class;
// See below for requests available
$response = $factory->call($request);
```

### Requests

#### Airline Fleet
```php
$request = new \Lsv\Airlabs\Request\AirlineFleetRequest()
$optionalParameters = [
    'airlineCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'hex' => 'H12345', // ICAO24 Hex address
    'reg_number' => 'OY-123', // Aircraft registration number
    'msn' => '', // Manufacturer Serial Number
    'flag' => 'DK' // Country code
];
$request = new \Lsv\Airlabs\Request\AirlineFleetRequest(...$optionalParameters);

// Response
array of \Lsv\Airlabs\Response\AirlineFleetResponse()
// If using a free account
array of \Lsv\Airlabs\Response\AirlineFleetFreeResponse()
```

#### Airline
```php
$request = new \Lsv\Airlabs\Request\AirlineRequest()
$optionalParameters = [
    'airlineCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'iataPrefix' => '1', // IATA prefix number
    'iataAccounting' => '1', // IATA accounting number
    'callsign' => 'AMERICAN', // ICAO callsign
    'name' => 'American Airlines', // Airline name
    'countryCode' => 'DK' // Country code
];
$request = new \Lsv\Airlabs\Request\AirlineFleetRequest(...$optionalParameters);

// Response
array of \Lsv\Airlabs\Response\AirlineResponse()
// If using a free account
array of \Lsv\Airlabs\Response\AirlineFreeResponse()
```

#### Airline Route
```php
$requiredParameters = [
    'departureAirport' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'arrivalAirport' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'airlineCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
];
$request = new \Lsv\Airlabs\Request\AirlineRouteRequest(...$requiredParameters);

$optionalParameters = [
    'flightCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'flightNumber' => '1', // Flight number
];
$request = new \Lsv\Airlabs\Request\AirlineRouteRequest(...array_merge($requiredParameters, $optionalParameters));

array of \Lsv\Airlabs\Response\AirlineRouteResponse()
// If using a free account
array of \Lsv\Airlabs\Response\AirlineFreeResponse()
```

#### Flight Information
```php
$requiredParameters = [
    'flightCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
];
$request = new \Lsv\Airlabs\Request\FlightInformationRequest(...$requiredParameters);

instance of new \Lsv\Airlabs\Response\FlightInformationResponse()
```

#### Flight Schedule
```php
$requiredParameters = [
    'departureAirport' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'arrivalAirport' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'airlineCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
];
$request = new \Lsv\Airlabs\Request\FlightScheduleRequest(...$requiredParameters);

$optionalParameters = [
    'flightCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // only add either icao or iata code
    'flightNumber' => '1', // Flight number
];
$request = new \Lsv\Airlabs\Request\FlightScheduleRequest(...array_merge($requiredParameters, $optionalParameters));

array of \Lsv\Airlabs\Response\FlightScheduleResponse()
```

#### Flight Tracker
```php
$request = new \Lsv\Airlabs\Request\FlightTrackerRequest();

$optionalParameters = [
    'box' => new \Lsv\Airlabs\Utils\BoundaryBox($swLat, $swLng, $neLat, $neLng), // Boundary box from where you want data from
    'hex' => '1', // ICAO24 Hex address
    'registrationNumber' => '1', // Aircraft Registration number.
    'airlineCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // Airline code
    'flag' => 'DK', // Country code
    'flightCode' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // Flight code
    'flightNumber' => '1', // Flight number
    'departureAirport' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // Departure airport
    'arrivalAirport' => new \Lsv\Airlabs\Utils\IcaoIataCode('icao', 'iata'), // Arrival airport
];
$request = new \Lsv\Airlabs\Request\FlightTrackerRequest(...$optionalParameters);

array of \Lsv\Airlabs\Response\FlightTrackerResponse()
```

## License

MIT License

Copyright (c) 2023 Martin Aarhof

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.