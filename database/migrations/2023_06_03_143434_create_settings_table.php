<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('site_id')->nullable()->index();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('key')->index();
            $table->integer('type')->index()->default(Setting::TYPE_STRING);
            $table->string('value_when_string')->nullable();
            $table->longText('value_when_long_text')->nullable();
            $table->longText('value_when_rich_text')->nullable();
            $table->json('value_when_json')->nullable();
            $table->boolean('value_when_boolean')->nullable();
            $table->string('value_when_number')->nullable();
            $table->boolean('active')->index()->default(true);
            $table->boolean('can_be_deleted')->index()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
