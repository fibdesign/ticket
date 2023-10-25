<?php

use App\Models\User;
use Fibdesign\Ticket\enums\PrioritiesEnums;
use Fibdesign\Ticket\enums\StatusEnums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('subject');

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->string('priority', 25)->default(PrioritiesEnums::NORMAL);
            $table->string('status',25)->default(StatusEnums::OPEN);

            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('seen_at')->nullable();
            $table->timestamp('admin_seen_at')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
