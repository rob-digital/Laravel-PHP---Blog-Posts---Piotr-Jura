<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     // name of the function MUST start with test...
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Welcome to Laravel Blog Post');
    }

     // name of the function MUST start with test...
    public function testContactPageIsWorkingCorrectly()
    {
       $response = $this->get('/contact');
       $response->assertSeeText('contact');
    }
}
