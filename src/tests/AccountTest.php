<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function check_status_http_of_invalid_user_in_the_create_account()
    {
        $this->post('/account', ['user_id' => rand(0, 9)])->assertResponseStatus(404);

    }

    /** @test */
    public function check_status_http_of_valid_user_in_the_create_account()
    {
        $user = User::factory()->create();
        $this->post('/account', ['user_id' => $user->id])->assertResponseStatus(201);
    }
}
