<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedBy()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $record = Record::factory()->create();

        $record->likes()->attach($user);

        $this->assertTrue($record->isLikedBy($user));
        $this->assertFalse($record->isLikedBy(null));
        $this->assertFalse($record->isLikedBy($other_user));
    }

    public function testCountLikes()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $record = Record::factory()->create();
        $like_count = 2;

        $record->likes()->attach($user);
        $record->likes()->attach($other_user);
        $result = $record->countLikes();

        $this->assertEquals($like_count, $result);
    }
}
