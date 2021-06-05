<?php

namespace Tests;

use App\Models\Account;
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
        $account = Account::factory()->make()->getAttributes();
        $this->post('/account', $account)->assertResponseStatus(201);
    }

    /** @test */
    public function check_balance_of_account_created_in_database()
    {
        $account = Account::factory()->create();
        $this->seeInDatabase('accounts', [
            'id' => $account->id,
            'balance' => 0
        ]);
    }

    /** @test */
    public function add_balance_in_account_created()
    {
        $account = Account::factory()->create();

        $value = round(1, 100);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->seeInDatabase('accounts', [
            'id' => $account->id,
            'balance' => $value
        ]);
    }

    /** @test */
    public function check_status_http_in_the_balance_of_account_created()
    {
        $account = Account::factory()->create();

        $value = round(1, 100);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ])->seeStatusCode(200);
    }

    /** @test */
    public function check_status_http_in_the_add_invalid_balance_of_account_created()
    {
        $account = Account::factory()->create();

        $value = round(-1, -100);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ])->seeStatusCode(422);
    }

    /** @test */
    public function check_status_http_in_account_invalid()
    {
        $accountId = round(100, 1000);

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $accountId,
            'value' => $value
        ])->seeStatusCode(404);
    }

    /** @test */
    public function check_status_http_to_withdraw_invalid()
    {
        $account = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'withdraw', [
            'account_id' => $account->id,
            'value' => $value
        ])->seeStatusCode(401);
    }

    /** @test */
    public function check_status_http_to_withdraw_valid()
    {
        $account = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $valueWithdraw = $value/2;

        $this->json('POST', 'withdraw', [
            'account_id' => $account->id,
            'value' => $valueWithdraw
        ])->seeStatusCode(200);
    }

    /** @test */
    public function check_balance_in_database_to_withdraw_valid()
    {
        $account = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $valueWithdraw = $value/2;

        $this->json('POST', 'withdraw', [
            'account_id' => $account->id,
            'value' => $valueWithdraw
        ]);

        $this->seeInDatabase('accounts', [
            'id' => $account->id,
            'balance' => $valueWithdraw
        ]);
    }

    /** @test */
    public function check_value_in_transactions_to_deposit_in_database()
    {
        $account = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->seeInDatabase('transactions', [
            'account_id' => $account->id,
            'value' => $value
        ]);
    }

    /** @test */
    public function check_value_in_transactions_to_withdraw_in_database()
    {
        $account = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $valueWithdraw = $value/2;

        $this->json('POST', 'withdraw', [
            'account_id' => $account->id,
            'value' => $valueWithdraw
        ]);

        $this->seeInDatabase('transactions', [
            'account_id' => $account->id,
            'value' => -$valueWithdraw
        ]);
    }

    /** @test */
    public function check_transfer_valid_in_database()
    {
        $account = Account::factory()->create();
        $account02 = Account::factory()->create();

        $value = round(1, 1000);


        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->json('POST', 'transfer', [
            'account' => $account->id,
            'account_to' => $account02->id,
            'value' => $value
        ]);

        $this->seeInDatabase('accounts', [
            'id' => $account02->id,
            'balance' => $value
        ]);
    }

    /** @test */
    public function check_status_http_to_transfer()
    {
        $account = Account::factory()->create();
        $account02 = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->json('POST', 'transfer', [
            'account' => $account->id,
            'account_to' => $account02->id,
            'value' => $value
        ])->assertResponseOk();
    }

    /** @test */
    public function check_status_http_to_accountTo_invalid()
    {
        $account = Account::factory()->create();
        $account02Id =  round(100, 1000);


        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->json('POST', 'transfer', [
            'account' => $account->id,
            'account_to' => $account02Id,
            'value' => $value
        ])->seeStatusCode(404);
    }

    /** @test */
    public function check_status_http_to_same_account()
    {
        $account = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->json('POST', 'transfer', [
            'account' => $account->id,
            'account_to' => $account->id,
            'value' => $value
        ])->seeStatusCode(401);
    }

    /** @test */
    public function check_transactions_in_database_to_transfer()
    {
        $account = Account::factory()->create();
        $account02 = Account::factory()->create();

        $value = round(1, 1000);

        $this->json('POST', 'deposit', [
            'account_id' => $account->id,
            'value' => $value
        ]);

        $this->json('POST', 'transfer', [
            'account' => $account->id,
            'account_to' => $account02->id,
            'value' => $value
        ]);

        $this->seeInDatabase('transactions', [
            'account_id' => $account->id,
            'account_to' => $account02->id,
            'value' => $value
        ]);
    }
}
