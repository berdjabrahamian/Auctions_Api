<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuctionTest extends TestCase
{

    public function testDBHasAuctions() {

    }

    public function testPassGetAllAuctions()
    {
        $response = $this->get('/api/v1/auctions');


    }

    public function testFailGetAllAuctions()
    {
        $response = $this->get('/api/v1/auctions');
        $response->assertStatus(403);

    }

}
