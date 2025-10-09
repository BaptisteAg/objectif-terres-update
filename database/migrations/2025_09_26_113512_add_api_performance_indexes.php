<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiPerformanceIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add index for ads synchronization queries
        Schema::table('ads', function (Blueprint $table) {
            $table->index(['updated_at', 'is_draft', 'deleted_at'], 'idx_ads_sync');
            $table->index(['created_at', 'is_draft'], 'idx_ads_created');
        });

        // Add index for attribution_ads synchronization
        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->index(['ad_id', 'ad_status_id', 'updated_at'], 'idx_attribution_ads_sync');
            $table->index(['published_on', 'ad_status_id'], 'idx_ads_published');
            $table->index(['archived_at', 'ad_status_id'], 'idx_ads_archived');
        });

        // Add composite index for locationable_ads for better join performance
        if (Schema::hasTable('locationable_ads')) {
            Schema::table('locationable_ads', function (Blueprint $table) {
                $table->index(['ad_id', 'locationable_ad_type', 'locationable_ad_id'], 'idx_locationable_ads_composite');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropIndex('idx_ads_sync');
            $table->dropIndex('idx_ads_created');
        });

        Schema::table('attribution_ads', function (Blueprint $table) {
            $table->dropIndex('idx_attribution_ads_sync');
            $table->dropIndex('idx_ads_published');
            $table->dropIndex('idx_ads_archived');
        });

        if (Schema::hasTable('locationable_ads')) {
            Schema::table('locationable_ads', function (Blueprint $table) {
                $table->dropIndex('idx_locationable_ads_composite');
            });
        }
    }
}
