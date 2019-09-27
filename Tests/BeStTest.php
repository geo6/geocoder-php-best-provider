<?php

declare(strict_types=1);

/*
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Geocoder\Provider\BeSt\Tests;

use Geocoder\IntegrationTest\BaseTestCase;
use Geocoder\Provider\BeSt\BeSt;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

class BeStTest extends BaseTestCase
{
    protected function getCacheDir()
    {
        return __DIR__ . '/.cached_responses';
    }

    /**
     * @expectedException \Geocoder\Exception\UnsupportedOperation
     * @expectedExceptionMessage The best provider does not support IP addresses, only street addresses.
     */
    public function testGeocodeWithLocalhostIPv4()
    {
        $provider = new BeSt($this->getMockedHttpClient());
        $provider->geocodeQuery(GeocodeQuery::create('127.0.0.1'));
    }

    /**
     * @expectedException \Geocoder\Exception\UnsupportedOperation
     * @expectedExceptionMessage The best provider does not support IP addresses, only street addresses.
     */
    public function testGeocodeWithLocalhostIPv6()
    {
        $provider = new BeSt($this->getMockedHttpClient());
        $provider->geocodeQuery(GeocodeQuery::create('::1'));
    }

    /**
     * @expectedException \Geocoder\Exception\UnsupportedOperation
     * @expectedExceptionMessage The best provider does not support IP addresses, only street addresses.
     */
    public function testGeocodeWithRealIPv6()
    {
        $provider = new BeSt($this->getMockedHttpClient());
        $provider->geocodeQuery(GeocodeQuery::create('::ffff:88.188.221.14'));
    }

    public function testReverseQuery()
    {
        $provider = new BeSt($this->getHttpClient());

        $query = ReverseQuery::fromCoordinates(50.841973, 4.362288)
            ->withLocale('fr');

        $results = $provider->reverseQuery($query);

        $this->assertInstanceOf('Geocoder\Model\AddressCollection', $results);
        $this->assertCount(5, $results);

        /** @var \Geocoder\Model\Address $result */
        $result = $results->first();
        $this->assertInstanceOf('\Geocoder\Model\Address', $result);
        $this->assertEquals(50.841973, $result->getCoordinates()->getLatitude(), '', 0.00001);
        $this->assertEquals(4.362288, $result->getCoordinates()->getLongitude(), '', 0.00001);
        // $this->assertEquals('Bruxelles', $result->getLocality());
        $this->assertEquals('Belgium', $result->getCountry()->getName());
        $this->assertEquals('BEL', $result->getCountry()->getCode());
    }

    public function testGeocodeQueryCRABLocaleNL()
    {
        $provider = new BeSt($this->getHttpClient());

        $query = GeocodeQuery::create('28 Motstraat, 2800 Mechelen')
            ->withLocale('nl');

        $results = $provider->geocodeQuery($query);

        $this->assertInstanceOf('Geocoder\Model\AddressCollection', $results);
        $this->assertCount(1, $results);

        /** @var \Geocoder\Model\Address $result */
        $result = $results->first();
        $this->assertInstanceOf('\Geocoder\Model\Address', $result);
        $this->assertEquals(51.012946, $result->getCoordinates()->getLatitude(), '', 0.00001);
        $this->assertEquals(4.488223, $result->getCoordinates()->getLongitude(), '', 0.00001);
        $this->assertEquals('28', $result->getStreetNumber());
        $this->assertEquals('Motstraat', $result->getStreetName());
        $this->assertEquals('2800', $result->getPostalCode());
        $this->assertEquals('Mechelen', $result->getLocality());
        $this->assertEquals('Belgium', $result->getCountry()->getName());
        $this->assertEquals('BEL', $result->getCountry()->getCode());
    }

    public function testGeocodeQueryICARLocaleDE()
    {
        $provider = new BeSt($this->getHttpClient());

        $query = GeocodeQuery::create('33 Aachener Straße, 4731 Raeren')
            ->withLocale('de');

        $results = $provider->geocodeQuery($query);

        $this->assertInstanceOf('Geocoder\Model\AddressCollection', $results);
        $this->assertCount(2, $results);

        /** @var \Geocoder\Model\Address $result */
        $result = $results->first();
        $this->assertInstanceOf('\Geocoder\Model\Address', $result);
        $this->assertEquals(50.6948082, $result->getCoordinates()->getLatitude(), '', 0.00001);
        $this->assertEquals(6.0833746, $result->getCoordinates()->getLongitude(), '', 0.00001);
        $this->assertEquals('33', $result->getStreetNumber());
        $this->assertEquals('Aachener Straße', $result->getStreetName());
        // $this->assertEquals('4731', $result->getPostalCode());
        $this->assertEquals('Raeren', $result->getLocality());
        $this->assertEquals('Belgium', $result->getCountry()->getName());
        $this->assertEquals('BEL', $result->getCountry()->getCode());
    }

    public function testGeocodeQueryUrbISLocaleFR()
    {
        $provider = new BeSt($this->getHttpClient());

        $query = GeocodeQuery::create('1 Place des Palais 1000 Bruxelles')
            ->withLocale('fr');

        $results = $provider->geocodeQuery($query);

        $this->assertInstanceOf('Geocoder\Model\AddressCollection', $results);
        $this->assertCount(2, $results);

        /** @var \Geocoder\Model\Address $result */
        $result = $results->first();
        $this->assertInstanceOf('\Geocoder\Model\Address', $result);
        $this->assertEquals(50.841973, $result->getCoordinates()->getLatitude(), '', 0.00001);
        $this->assertEquals(4.362288, $result->getCoordinates()->getLongitude(), '', 0.00001);
        $this->assertEquals('1', $result->getStreetNumber());
        $this->assertEquals('Place Des Palais', $result->getStreetName());
        $this->assertEquals('1000', $result->getPostalCode());
        // $this->assertEquals('Bruxelles', $result->getLocality());
        $this->assertEquals('Belgium', $result->getCountry()->getName());
        $this->assertEquals('BEL', $result->getCountry()->getCode());
    }
}
