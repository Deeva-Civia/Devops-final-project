<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE `students` MODIFY `religion` ENUM(
                'Islam',
                'Kristen',
                'Kristen Katolik',
                'Katolik',
                'Hindu',
                'Buddha',
                'Konghucu',
                'Kristen Advent'
            ) NOT NULL");
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("UPDATE `students` SET `religion` = 'Kristen Katolik' WHERE `religion` = 'Katolik'");

            DB::statement("ALTER TABLE `students` MODIFY `religion` ENUM(
                'Islam',
                'Kristen',
                'Kristen Katolik',
                'Hindu',
                'Buddha',
                'Konghucu',
                'Kristen Advent'
            ) NOT NULL");
        }
    }
};