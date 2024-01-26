<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence(5); // maxLength: 100
        $slug = Str::slug($title, '-'); // Tạo slug từ title
        $user = User::factory()->create(); // Tạo người dùng giả lập

        return [
            'user_id' => $user->id, // Lấy user_id của người dùng
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->optional()->text(200), // maxLength: 200, mặc định null
            'content' => $this->faker->text,
            'thumbnail' => $this->faker->imageUrl(),
        ];
    }
}
