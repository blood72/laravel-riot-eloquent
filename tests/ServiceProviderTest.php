<?php

namespace Blood72\Riot\Tests;

use Blood72\Riot\RiotEloquentServiceProvider;

class APIServiceProviderTest extends TestCase
{
    /** @test */
    public function it_is_impossible_to_defer_a_provider()
    {
        /** @var \Illuminate\Support\ServiceProvider $provider */
        $provider = $this->getMockBuilder(RiotEloquentServiceProvider::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['isDeferred'])
            ->getMock();

        $actual = $provider->isDeferred();

        $this->assertFalse($actual);
    }
}
