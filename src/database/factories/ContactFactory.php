<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'first_name' => mb_substr($this->faker->firstName(), 0, 8),
            'last_name' => mb_substr($this->faker->lastName(), 0, 8),
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->safeEmail(),
            'tel' => $this->faker->numerify(str_repeat('#', rand(10, 11))),
            'address' => $this->faker->address(),
            'building' => $this->faker->optional(0.7)->secondaryAddress(),
            'detail' => $this->faker->realText(120),

        ];
    }
}
