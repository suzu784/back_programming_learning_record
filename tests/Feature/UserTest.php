<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testMyDrafts()
    {
        $user = User::factory()->create();
        $draft_record = Record::factory()->create([
            'user_id' => $user->id,
            'is_draft' => true,
        ]);
        $not_draft_record = Record::factory()->create([
            'user_id' => $user->id,
            'is_draft' => false,
        ]);

        $results = $user->myDrafts()->get();
        $this->assertTrue($results->contains($draft_record));
        $this->assertFalse($results->contains($not_draft_record));
    }
}
