<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoadHomeViewTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_load_home_screen()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_load_information_from_api()
    {
        $response = $this->getJson('/api/guest');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_user_for_notification()
    {
        $response = $this->postJson('/api/guest/notify',
            [
                'email' => 'example@gmail.com',
                'pair' => 'BTCUSD',
                'price' => 20000.12
            ]);

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_user_for_notification_failure_on_email()
    {
        $response = $this->postJson('/api/guest/notify',
            [
                'email' => 'example',
                'pair' => 'BTCUSD',
                'price' => 20000.12
            ]);

        $response->assertStatus(422)->assertJson([
            'message' => 'The email must be a valid email address.',
            'errors' => [
                'email' => [
                    0 => 'The email must be a valid email address.'
                ]
            ]
        ]);
    }
}
