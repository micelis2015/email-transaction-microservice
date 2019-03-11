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
                'mpid' => 2,
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
                'mpid' => 2,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testPutMail()
    {
        $this->json('PUT', '/user/1/mail')
             ->seeJson([
                'mpid' => 2,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testPutMailWithMid()
    {
        $this->json('PUT', '/user/1/mail/1')
             ->seeJson([
                'mpid' => 2,
             ]);
    }
    
    /**
     * Test a DELETE for a specific UserMail
     *
     * @return void
     */
    public function testDeleteSpecificMail()
    {
        $this->json('DELETE', '/user/1/mail/1')
             ->seeJson([
                'results' => 1,
             ]);
    }
    
    /**
     * Test DELETE for all mail for a user
     *
     * @return void
     */
    public function testDeleteAllMail()
    {
        $this->json('DELETE', '/user/1/mail')
             ->seeJson([
                'results' => 1,
             ]);
    }
    
    /**
     * Test a POST for a user without specific mid
     *
     * @return void
     */
    public function testDeleteSpecificInvalidMail()
    {
        $this->json('DELETE', '/user/1/mail/3')
             ->seeJson([
                'results' => 0,
             ]);
    }
}
