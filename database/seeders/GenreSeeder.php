<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        DB::table('genres')->insert([
            [
                'name' => 'Action',
                'description' => 'High energy movies with physical feats, stunts, and fights. Fast-paced and exciting.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'name' => 'Adventure',
                'description' => 'Movies that involve epic journeys, exploration, and quests in exotic or dangerous locations.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'name' => 'Drama',
                'description' => 'Emotionally-driven stories that focus on character development, relationships, and conflicts.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'name' => 'Sci-Fi',
                'description' => 'Stories involving futuristic technology, space travel, time travel, or speculative scientific concepts.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'name' => 'Thriller',
                'description' => 'Suspenseful movies designed to keep the audience on edge with tension, mystery, or crime.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);

    }
}
