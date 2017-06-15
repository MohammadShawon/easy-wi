<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GlobalAdminTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Update non existing admin
     *
     * @return void
     */
    public function testMissingAdminUpdateTest()
    {
        $response = $this->json('PUT', '/api/v1/global/admins/501', [
            'name' => 'Test2',
            'first_name' => 'Absd',
            'last_name' => 'asd',
            'email' => 'test2@easy-wi.com',
            'locked' => true
        ]);

        $response->assertStatus(404);
    }

    /**
     * Get non existing admin
     *
     * @return void
     */
    public function testGetMissingAdminTest()
    {
        $response = $this->get('/api/v1/global/admins/501');

        $response->assertStatus(404);
    }

    /**
     * Create an admin with invalid.
     *
     * @return void
     */
    public function testCreateAdminInvalidDataTest()
    {
        $response = $this->json('POST', '/api/v1/global/admins', [
            'name' => 'Test',
            'first_name' => '',
            'lastName' => '',
            'email' => 'test@',
            'locked' => 'String',
            'password' => 'password123'
        ]);

        $response->assertStatus(422)->assertExactJson([
            'errors' => [
                'email' => ['The email must be a valid email address.'],
                'locked' => ['The locked field must be true or false.'],
                'password' => ['The password format is invalid.']
            ]
        ]);
    }

    /**
     * Create an admin.
     *
     * @return void
     */
    public function testCreateAdminTest()
    {
        $response = $this->json('POST', '/api/v1/global/admins', [
            'name' => 'Test',
            'first_name' => '',
            'lastName' => '',
            'email' => 'test@easy-wi.com',
            'locked' => false,
            'password' => 'Password123'
        ]);

        $response->assertStatus(201)->assertHeader('Location', '/api/v1/global/admins/51');
    }

    /**
     * Get all admins
     *
     * @return void
     */
    public function testGetAdminsTest()
    {
        $response = $this->get('/api/v1/global/admins');

        $response->assertStatus(200)->assertJsonStructure([
            'current_page',
            'from',
            'last_page',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'data' => [
                [
                    'id',
                    'email',
                    'first_name',
                    'last_name',
                    'locked',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * Get the admin
     *
     * @return void
     */
    public function testGetAdminTest()
    {
        $response = $this->get('/api/v1/global/admins/1');

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'email',
            'first_name',
            'last_name',
            'locked',
            'name',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * Update the admin
     *
     * @return void
     */
    public function testUpdateAdminTest()
    {
        $response = $this->json('PUT', '/api/v1/global/admins/1', [
            'name' => 'Test2',
            'first_name' => 'Absd',
            'last_name' => 'asd',
            'email' => 'test2@easy-wi.com',
            'locked' => true
        ]);

        $response->assertStatus(204);
    }

    /**
     * Update the admin's password
     *
     * @return void
     */
    public function testUpdateAdminPasswordTest()
    {
        $response = $this->json('PUT', '/api/v1/global/admins/1/password', [
            'password' => 'Testing123'
        ]);

        $response->assertStatus(204);
    }

    /**
     * Create an admin with invalid.
     *
     * @return void
     */
    public function testUpdateAdminInvalidPasswordTest()
    {
        $response = $this->json('PUT', '/api/v1/global/admins/1/password', [
            'password' => 'password123'
        ]);

        $response->assertStatus(422)->assertExactJson([
            'errors' => [
                'password' => ['The password format is invalid.']
            ]
        ]);
    }

    /**
     * Delete the admin
     *
     * @return void
     */
    public function testDeleteAdminTest()
    {
        $response = $this->delete('/api/v1/global/admins/1');

        $response->assertStatus(204);
    }
}
