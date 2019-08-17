<?php

/*
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Geocoder\Provider\BeStPOI\Tests;

use Geocoder\IntegrationTest\ProviderIntegrationTest;
use Geocoder\Provider\BeSt\BeSt;
use Http\Client\HttpClient;

class IntegrationTest extends ProviderIntegrationTest
{
    protected $testAddress = true;

    protected $testReverse = true;

    protected $testIpv4 = false;

    protected $testIpv6 = false;

    protected $skippedTests = [
        'testGeocodeQuery' => 'BeSt covers Belgium only.'
    ];

    protected function createProvider(HttpClient $httpClient)
    {
        return new BeSt($httpClient);
    }

    protected function getCacheDir()
    {
        return __DIR__ . '/.cached_responses';
    }

    protected function getApiKey()
    {
        return null;
    }
}
