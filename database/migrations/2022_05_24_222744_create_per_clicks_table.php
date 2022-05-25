<?php

use App\Models\ShortLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ShortLink::class)->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            /** more detail soon */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_clicks');
    }
};
