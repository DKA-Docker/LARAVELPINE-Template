<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Attachments;

use App\Models\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachments;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachments>
 */
class AppsDeliveriesTasksAttachmentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppsDeliveriesTasksAttachments::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'task' => AppsDeliveriesTasks::query()->inRandomOrder()->first()->id,
            'file_name' => $this->faker->word . '.jpg',
            'file_hash' => hash('sha256', $this->faker->randomAscii),
            'storage_key' => 'uploads/' . date('Y/m') . '/' . $this->faker->uuid . '.jpg',
            'file_path' => $this->faker->imageUrl(),
            'file_type' => 'image/jpeg',
            'file_size' => $this->faker->numberBetween(1024, 1048576), // 1KB to 1MB
        ];
    }
}
