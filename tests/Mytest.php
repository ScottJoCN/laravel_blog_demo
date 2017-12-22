<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Mytest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function setUp(){
    	parent::setUp();
    }
    public function testIndex(){
    	$this->call('GET','/');
    	$this->assertResponseOK();
    	$this->see('articles');
    	$this->see('tags');
    }
    public function testNotFound(){
    	$this->call('GET','test');
    	$this->assertResponseStatus(404);
    }
}
