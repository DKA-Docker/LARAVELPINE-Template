<?php

namespace Database\Factories\Apps\Deliveries\Histories;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\app\Models\Apps\Deliveries\Histories>
 */
class AppsDeliveriesHistoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accounts = Accounts::inRandomOrder()->first();
        $task = AppsDeliveriesTasks::inRandomOrder()->first();
        $arrayHistory = ['on_delivery', 'delivered', 'failed', 'done','todo'];
        return [
            'id' => (String) Str::uuid(),
            'account' => $accounts,
            'task' => $task->id,
            'to_status' => $arrayHistory[rand(0,3)],
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'name' =>  $this->faker->name()
        ];
    }
}
