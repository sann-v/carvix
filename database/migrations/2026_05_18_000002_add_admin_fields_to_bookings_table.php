<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('handled_by')->nullable()->after('specialist');   // nama karyawan
            $table->text('admin_notes')->nullable()->after('handled_by');    // catatan servis
            $table->datetime('estimated_finish')->nullable()->after('admin_notes'); // estimasi selesai
            $table->decimal('service_cost', 12, 2)->nullable()->after('estimated_finish'); // biaya
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['handled_by', 'admin_notes', 'estimated_finish', 'service_cost']);
        });
    }
};