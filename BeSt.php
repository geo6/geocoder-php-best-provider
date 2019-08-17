<?php

declare(strict_types=1);

/*
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Geocoder\Provider\BeSt;

use Geocoder\Provider\Provider;
use Geocoder\Provider\Pelias\Pelias;
use Http\Client\HttpClient;

/**
 * @author Jonathan Beliën <jbe@geo6.be>
 */
final class BeSt extends Pelias implements Provider
{
    /**
     * @param HttpClient $client an HTTP adapter
     */
    public function __construct(HttpClient $client)
    {
        parent::__construct($client, 'https://best.osoc.be/', 1);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'best';
    }
}
