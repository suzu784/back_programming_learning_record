<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Record;
use App\Models\Comment;
use App\Models\Template;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * データベースに初期データを挿入
     *
     * @return void
     */
    public function run()
    {
        Record::factory(5)->create();
        Tag::factory()->create();
        Template::factory()->create();
        Comment::factory()->create();
    }
}
