<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;
use App\Providers\GlobalVariablesServiceProvider as GlobalVariables;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = GlobalVariables::categories();
        $faker = FakerFactory::create('en_US');
        $faker_ar = FakerFactory::create('ar_SA');
        return [
            'scientific_name' => $faker->sentence(2),
            'scientific_name_ar' => $faker->sentence(2),
            'brand_name' => $faker->sentence(2),
            'brand_name_ar' => $faker->sentence(2),
            'category_id' => rand(1,7),   
            'manufacturer' => $faker->company(),
            'manufacturer_ar' => $faker_ar->company(),
            'stock' => $faker->numberBetween(1, 1000),
            'sales'=>$faker->numberBetween(1,100),
            'price' => $faker->randomFloat(2, 1, 100),
            'expiration_date' => $faker->dateTimeBetween('now','+3 years'),
            'description' => $faker->paragraph(),
            'description_ar' => $faker->paragraph(),
            'image' => null,
        ];
    }
}
