<?php

namespace Database\Factories;

use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paid = $this->faker->boolean();
        $total = $this->faker->randomFloat(2, 200000, 2000000);
        $tax = $total * 10 / 100;
        $outlet = Outlet::inRandomOrder()->first();

        if ($paid) { // if status paid
            $pay = $total + $this->faker->randomFloat(2, 10000, 100000);
            $change = $pay - $total;
            $status = 'Paid';
            $paymentType = $this->faker->randomElement(['Cash','Credit Card','Virtual Account','Bank Transfer']);
        } else {
            $pay = 0;
            $change = 0;
            $status = 'Not Paid';
            $paymentType = null;
        }

        return [
            'id' => Uuid::uuid4()->toString(),
            'merchant_id' => $outlet->merchant_id,
            'outlet_id' => $outlet->id,
            'transaction_time' => $this->faker->dateTime(),
            'staff' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'pay_amount' => $pay,
            'payment_type' => $paymentType,
            'customer_name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'tax' => $tax,
            'change_amount' => $change,
            'total_amount' => $total,
            'payment_status' => $status
        ];
    }
}
