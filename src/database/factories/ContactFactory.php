<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Category;

class ContactFactory extends Factory
{
    protected $model=Contact::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender'=> $this->faker->numberBetween(1,3),
            'email'=> $this->faker->safeEmail(),
            'tel'=> $this->faker->phoneNumber(),
            'address' => $this->faker->address,
            'category_id'=>  Category::inRandomOrder()->first()->id,
            'detail'=> $this->faker->text(120),
            'created_at'=> $this->faker->date,

        ];
    }
}
