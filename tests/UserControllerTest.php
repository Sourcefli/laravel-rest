<?php

namespace Sourcefli\LaravelRest\Tests;

use Sourcefli\LaravelRest\Tests\Models\User;

class UserControllerTest extends TestCase
{
    /** @test */
    public function it_gets_to_the_users_index_route()
    {
        $u = User::factory()->create();

        $response = $this->getJson('/api/foo');

        $response->assertOk();

//        $response->assertJson()
    }
}
