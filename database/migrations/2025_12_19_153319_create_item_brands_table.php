<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Item Name
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('item_brand_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign(['item_brand_id']);
            $table->dropColumn('item_brand_id');
        });
        Schema::dropIfExists('item_brands');
    }
};
