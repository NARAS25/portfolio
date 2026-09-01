<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('tagline')->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('tagline');
            $table->string('github_url')->nullable()->after('bio');
            $table->string('linkedin_url')->nullable()->after('github_url');
            $table->string('instagram_url')->nullable()->after('linkedin_url');
            $table->string('cv_url')->nullable()->after('instagram_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'tagline', 'bio', 'github_url', 'linkedin_url', 'instagram_url', 'cv_url']);
        });
    }
};
