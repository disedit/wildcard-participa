<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use App\Edition;
use App\Voter;
use App\User;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        Parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fetches_the_ballot()
    {
        $response = $this->json('GET', '/api/ballot');

        $response->assertSuccessful()
                 ->assertJson([
                     'id' => true,
                     'name' => true,
                     'questions' => true,
                 ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_verifies_voter_information()
    {

        $response = $this->json('POST', '/api/precheck', [
            'SID' => 'Invalid SID'
        ]);
        $response->assertStatus(422);

        $validSID = Voter::first()->SID;
        $response = $this->json('POST', '/api/precheck', [
            'SID' => $validSID
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requests_an_sms_code()
    {
        /*
        $response = $this->json('POST', '/api/requestSms', [
            'SID' => '53362671A',
            'country_code' => 34,
            'phone' => '649143505',
            'ballot' => $this->fakeBallot(),
            '' => '',
        ]);

        $response->assertSuccessful();
        */
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_casts_a_ballot_as_online_voter()
    {

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_casts_a_ballot_as_offline_voter()
    {

    }

    public function test_it_fails_when_ID_does_not_exist()
    {

    }

    public function test_it_fails_when_ballot_is_invalid()
    {

    }

    public function test_it_fails_when_SMS_code_is_invalid()
    {

    }

    private function fakeValidBallot()
    {

    }

    private function fakeInvalidBallot()
    {

    }

}
