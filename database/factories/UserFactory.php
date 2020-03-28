<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Order;
use App\Product;
use App\Project;
use App\Supplier;
use App\Task;
use App\User;
use App\UserProfile;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(UserProfile::class, function (Faker $faker) {

    return [
        'user_id' => $faker->name,
        'phone' => $faker->phoneNumber,
        'birth_date' => $faker->dateTimeThisCentury(),
    ];
});

$factory->define(Category::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
    ];
});

$factory->define(Supplier::class, function (Faker $faker) {

    return [
        'company_name' => $faker->company,
        'country' => $faker->country,
        'city' => $faker->city,
        'state' => $faker->state,
        'postcode' => $faker->postcode,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    $categories = Category::all()->pluck('id');
    $products = Supplier::all()->pluck('id');

    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'barcode' => Str::random(10),
        'category_id' => rand($categories->first(), $categories->last()),
        'supplier_id' => rand($products->first(), $products->last()),
        'unit_price' => rand(5, 9999.99),
        'in_stock' => rand(0, 100)
    ];
});

//$factory->define(Order::class, function (Faker $faker) {
//    $users = User::all()->pluck('id');
//
//    return [
//        'user_id' => rand($users->first(), $users->last()),
//        'status' => $faker->word,
//        'method' => $faker->text,
//    ];
//});
