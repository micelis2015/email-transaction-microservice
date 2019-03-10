<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserMailTest extends TestCase
{
     /**
     * Test a GET for a user without specific mid
     *
     * @return void
     */
    public function testGetAll()
    {
        $this->json('GET', '/user/1/mail')
             ->seeJson([
                'mcid' => 2,
             ]);
    }
    
    /**
     * Test a GET for a user without specific mid
     *
     * @return void
     */
    public function testGetSpecificMail()
    {
        $this->json('GET', '/user/1/mail/2')
             ->seeJson([
                'mcid' => 2,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testPutMail()
    {
        $this->json('GET', '/user/1/mail')
             ->seeJson([
                'mcid' => 2,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testPutMailWithMid()
    {
        $this->json('GET', '/user/1/mail/1')
             ->seeJson([
                'mcid' => 2,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testDeleteAllMail()
    {
        $this->json('DELETE', '/user/1/mail')
             ->seeJson([
                'mcid' => 2,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testDeleteSpecificMail()
    {
        $this->json('DELETE', '/user/1/mail/1')
             ->seeJson([
                'mcid' => 2,
             ]);
    }
}
