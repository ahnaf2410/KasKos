public function up(): void
{
    Schema::create('personal_payments', function (Blueprint $table) {
        $table->id();

        $table->integer('user_id');

        $table->string('title');

        $table->decimal('amount', 15, 2);

        $table->date('due_date');

        $table->enum('status', [
            'unpaid',
            'pending_verification',
            'paid'
        ])->default('unpaid');

        $table->string('payment_slip')->nullable();

        $table->date('payment_date')->nullable();

        $table->integer('verified_by')->nullable();

        $table->text('notes')->nullable();

        $table->timestamps();

        $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete();

        $table->foreign('verified_by')
            ->references('id')
            ->on('users')
            ->nullOnDelete();
    });
}