<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Browser\Pages\Booth;
use App\Voter;
use App\User;

class BoothTest extends DuskTestCase
{

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_a_voter_can_cast_a_ballot_online()
    {
        // Get a voter that hasn't voted yet
        $voter = Voter::where('ballot_cast', 0)->first();

        $this->browse(function (Browser $browser) use ($voter) {
            $browser->visit(new Booth)
                    ->waitFor('.booth')
                    ->fillOutBallot()
                    ->type('identification', $voter->SID) // Voter SID
                    ->press('@vote')
                    ->waitFor('.ballot-verify')
                    ->type('phone', rand(600000000, 799999999)) // Random Spanish phone
                    ->click('@smsRequest')
                    ->waitFor('@cast');

            $smsCode = Voter::find($voter->id)->SMS_token;

            $browser->type('sms_code', $smsCode)
                    ->click('@cast')
                    ->waitFor('.ballot-confirmation')
                    ->assertVisible('.receipt'); // Change to CSS selector
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_a_voter_can_cast_a_ballot_in_person()
    {
        $admin = User::find(1);

        // Get voter with ballot_cast = 0
        $voter = Voter::where('ballot_cast', 0)->first();

        $this->browse(function (Browser $browser) use ($voter, $admin) {
            $browser->loginAs($admin)
                    ->visit('/')
                    ->waitFor('.booth')
                    ->click('.custom-checkbox')
                    ->type('identification', $voter->SID) // Voter SID
                    ->press('@vote')
                    ->waitFor('.verify-in-person')
                    ->click('@cast')
                    ->waitFor('.ballot-confirmation')
                    ->assertVisible('.receipt');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_an_invalid_ID_displays_an_error()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_a_single_ID_cannot_vote_more_than_once()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_an_invalid_ballot_cannot_be_cast()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_an_invalid_phone_displays_an_error()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_a_single_phone_cannot_vote_more_than_once()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_a_voter_cannot_bypass_sms_safeguards_online()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_a_single_ip_cannot_vote_more_than_three_times()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_booth_is_hidden_after_voting_closes()
    {

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_booth_is_hidden_before_voting_opens()
    {

    }
}
