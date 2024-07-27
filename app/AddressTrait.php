<?php

namespace App;

use App\Models\Address;

trait AddressTrait
{
    /**
     * Get the Model's address.
     */
    public function latest_address()
    {
        return $this->morphOne(Address::class, 'addressable')->latestOfMany();
    }

    /**
     * Get all of the Model's addresses.
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return $this->latest_address?->name ?? '';
    }

    /**
     * Set the Model's address.
     *
     * @param  string  $value
     * @return void
     */
    public function setOpeningAttribute($value)
    {
        if ($this->address == '' && ! empty($value)) {
            $this->addresses()->save(new Address([
                'name' => $value,
            ]));
        } elseif ($value != $this->address) {
            $this->latest_address->update(['note' => $value]);
        }
    }
}
