<?php

namespace Tests;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Utils\OpensslUtils;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function check_status_http_of_invalid_parameters_create_user()
    {
        $this->post('/user', ['email' => 'aa'])->assertResponseStatus(422);
    }

    /** @test */
    public function check_status_http_of_create_user()
    {
        $user = User::factory()->make()->getAttributes();
        $this->json('POST', '/user', $user)->assertResponseStatus(201);
    }

    /** @test */
    public function check_email_and_cpf_cnpj_unique_of_create_user()
    {
        $user = User::factory()->make()->getAttributes();
        $this->json('POST', '/user', $user);
        $this->json('POST', '/user', $user)->seeJsonEquals([
            "email" => [ "emailalready registered."],
            "cpf_cnpj" => ["cpf_cnpj already registered."]
        ]);
    }

    /** @test */
    public function check_data_of_user_in_database()
    {
        $user = User::factory()->make()->getAttributes();
        $encryptEncrypt = OpensslUtils::encrypt($user['email']);
        $this->json('POST', '/user', $user);

        $this->seeInDatabase('users', ['email' => $encryptEncrypt]);

    }

    /** @test */
    public function check_status_http_in_update_of_user()
    {
        $user = User::factory()->create();
        $userEdit = User::factory()->make()->getAttributes();
        unset($userEdit['password']);
        $this->json('PUT', "/user/$user->id", $userEdit)->assertResponseOk();

    }

    /** @test */
    public function check_update_of_user_in_database()
    {
        $user = User::factory()->create();
        $userEdit = User::factory()->make()->getAttributes();

        $cpfCnpjEncrypt = OpensslUtils::encrypt($userEdit['cpf_cnpj']);

        $this->json('PUT', "/user/$user->id", ['cpf_cnpj' => $userEdit['cpf_cnpj']]);

        $this->seeInDatabase('users', ['cpf_cnpj' => $cpfCnpjEncrypt]);

    }

    /** @test */
    public function check_status_http_to_show_of_user()
    {
        $user = User::factory()->create();

        $this->get("/user/$user->id")
        ->assertResponseOk();
    }

    /** @test */
    public function check_response_data_in_show_of_user()
    {
        $user = User::factory()->create();

        unset($user['password']);
        unset($user['created_at']);
        unset($user['updated_at']);

        $this->get("/user/$user->id")
        ->seeJson($user->getAttributes());
    }

    /** @test */
    public function check_response_data_in_delete_of_user()
    {
        $user = User::factory()->create();

        $this->delete("/user/$user->id")
        ->assertResponseOk();
    }
}
