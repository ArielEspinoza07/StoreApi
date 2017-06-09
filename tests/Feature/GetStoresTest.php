<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetStoresTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //Arrange
        $statusCode =   200;

        //Act
        $response = $this->json('GET','/api/v1/services/stores');

        //Assert
        $response->assertStatus($statusCode);
    }
}
