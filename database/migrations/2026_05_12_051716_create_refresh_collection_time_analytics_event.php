<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET GLOBAL event_scheduler = ON');

        // Drop existing event if present
        DB::unprepared('DROP EVENT IF EXISTS refresh_collection_time_analytics');

        // Create MySQL event
        DB::unprepared("
            CREATE EVENT refresh_collection_time_analytics
            ON SCHEDULE EVERY 1 DAY
            STARTS TIMESTAMP(CURRENT_DATE, '23:59:00')
            DO
            BEGIN
                -- Delete analytics for today and yesterday
                DELETE FROM collection_time_analytics
                WHERE analytics_date IN (
                    CURDATE(),
                    DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                );

                -- Rebuild analytics
                INSERT INTO collection_time_analytics (
                    user_id,
                    analytics_date,
                    slot_start_hour,
                    total_collections,
                    total_amount,
                    last_refreshed_at,
                    created_at,
                    updated_at
                )
                SELECT
                    collected_by AS user_id,
                    DATE(collected_at) AS analytics_date,
                    FLOOR(HOUR(collected_at) / 2) * 2 AS slot_start_hour,
                    COUNT(*) AS total_collections,
                    SUM(amount_paid) AS total_amount,
                    NOW() AS last_refreshed_at,
                    NOW() AS created_at,
                    NOW() AS updated_at
                FROM collections
                WHERE DATE(collected_at) IN (
                    CURDATE(),
                    DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                )
                GROUP BY
                    collected_by,
                    DATE(collected_at),
                    FLOOR(HOUR(collected_at) / 2) * 2;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::unprepared('DROP EVENT IF EXISTS refresh_collection_time_analytics');
    }
};
