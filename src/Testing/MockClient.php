<?php

namespace Spawnia\Sailor\Testing;

use Spawnia\Sailor\Client;
use Spawnia\Sailor\Testing\MockRequest;
use Spawnia\Sailor\Response;

class MockClient implements Client
{
    /**
     * @var callable[]
     */
    public $responseMocks = [];

    /**
     * @var MockRequest[]
     */
    public $storedRequests = [];

    public function request(string $query, \stdClass $variables = null): Response
    {
        $request = new MockRequest($query, $variables);

        $this->storedRequests []= $request;

        $responseMock = array_shift($this->responseMocks);

        if(!$responseMock) {
            throw new \Exception('No mock left to handle the request.');
        }

        return $responseMock($query, $variables);
    }
}
