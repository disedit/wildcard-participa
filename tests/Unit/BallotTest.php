<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Ballot;

class BallotTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_can_encrypt_and_decrypt_a_ballot()
    {
        $fakeBallot =  [
            [
                'id' => 1,
                'options' => [
                    ['id' => 3]
                ]
            ],
            [
                'id' => 2,
                'options' => [
                    ['id' => 4]
                ]
            ]
        ];

        $ballot = new Ballot();
        $encryptedBallot = $ballot->createBallot($fakeBallot);
        $ballot->ballot = $encryptedBallot;
        $decryptedBallot = $ballot->decrypt();

        $this->assertEquals($decryptedBallot[1][3], 1.0);
    }

    public function test_it_can_create_ballot_refs()
    {
        $ballot = new Ballot();
        $ref = $ballot->createRef();
        $refLength = (strlen($ref) == 10);

        $this->assertDatabaseMissing('ballots', ['ref' => $ref])
             ->assertTrue($refLength);
    }

    public function test_it_can_sign_and_check_a_ballot()
    {
        $ballot = new Ballot();
    }

    public function test_it_can_cast_a_ballot()
    {

    }
}
