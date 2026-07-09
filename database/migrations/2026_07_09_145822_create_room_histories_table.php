public function up(): void
{
    Schema::create('room_histories', function (Blueprint $table) {
        $table->id();

        $table->integer('room_id');
        $table->integer('user_id');

        $table->date('start_date');
        $table->date('end_date')->nullable();

        $table->enum('status', [
            'active',
            'moved',
            'left'
        ])->default('active');

        $table->timestamps();

        $table->foreign('room_id')
            ->references('id')
            ->on('rooms')
            ->cascadeOnDelete();

        $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete();
    });
}