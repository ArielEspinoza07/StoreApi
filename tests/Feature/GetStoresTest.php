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
    public function testUnAuthorized()
    {
        //Arrange
        $statusCode =   401;

        //Act
        $response = $this->json('GET','/api/v1/services/stores');

        //Assert
        $response->assertStatus($statusCode);
    }

    public function testGetSuccessStores()
    {
        //Arrange
        $statusCode =   200;

        //Act
        $headers    =   array(
            'Authorization'    => 'Basic ' . base64_encode('my_user,my_password'),
            'PHP_AUTH_USER'         => 'my_user',
            'PHP_AUTH_PW'           => 'my_password'
        );
        $response   = $this->json('GET','/api/v1/services/stores',[],$headers);

        //Assert
        $response->assertStatus($statusCode);
    }

    public function testGetBadRequestStores()
    {
        //Arrange
        $statusCode =   400;

        //Act
        $headers    =   array(
            'Authorization'    => 'Basic ' . base64_encode('my_user,my_password'),
            'PHP_AUTH_USER'         => 'my_user',
            'PHP_AUTH_PW'           => 'my_password'
        );
        $data       =   array(
            'city'  =>  'El Coyol'
        );
        $response   = $this->json('GET','/api/v1/services/stores',$data,$headers);

        //Assert
        $response->assertStatus($statusCode);
    }

    public function testGetNotFoundStoresArticles()
    {
        //Arrange
        $statusCode =   404;

        //Act
        $headers    =   array(
            'Authorization'    => 'Basic ' . base64_encode('my_user,my_password'),
            'PHP_AUTH_USER'         => 'my_user',
            'PHP_AUTH_PW'           => 'my_password'
        );
        $data       =   array();
        $response   = $this->json('GET','/api/v1/services/stores/2/articles',$data,$headers);

        //Assert
        $response->assertStatus($statusCode);
    }
}
