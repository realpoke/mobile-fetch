<?php

use App\Enums\ItemStatusEnum;
use App\Models\Fetch;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fetch::class)->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('status')->default(ItemStatusEnum::default()->value);
            $table->string('added_by');
            $table->string('fetched_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
