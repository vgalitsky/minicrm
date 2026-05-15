<?php

namespace Mtr\MiniCrm\Repositories\Customer;

use Mtr\MiniCrm\Exceptions\CustomerConflictException;
use Mtr\MiniCrm\Models\Customer;

class CustomerRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Customer>
     */
    public function findByEmailOrPhone(string $email, string $phone): \Illuminate\Database\Eloquent\Collection
    {
        return Customer::where('email', $email)
            ->orWhere('phone', $phone)
            ->lockForUpdate()
            ->get();
    }

    /**
     * @param  array $data
     *
     * @throws CustomerConflictException
     */
    public function resolveCustomer(array $data): Customer
    {
        $matches = $this->findByEmailOrPhone($data['email'], $data['phone']);

        if ($matches->isEmpty()) {
            $customer = Customer::create($data);
            $customer->created = true;

            return $customer;
            // return [
            //     'customer' => Customer::create($data),
            //     'created'  => true,
            // ];
        }

        if ($matches->count() > 1) {
            throw new CustomerConflictException(
                'The provided email and phone belong to different customers.'
            );
        }

        $customer = $matches->first();

        if ($customer->email !== $data['email'] || $customer->phone !== $data['phone']) {
            throw new CustomerConflictException(
                'Incorrect combination of email and phone provided'
            );
        }

        if ($customer->name !== $data['name']) {
            $customer->update(['name' => $data['name']]);
        }

        $customer->created = false;

        return $customer;
    }
}
