<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('support_educatifs', function (Blueprint $table) {
            $table->boolean('prive')->default(0)->after('id_user');
        });
    }

    public function down(): void
    {
        Schema::table('support_educatifs', function (Blueprint $table) {
            $table->dropColumn('prive');
        });
    }
};
