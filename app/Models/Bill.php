<?php

namespace App\Models;

use App\AddressTrait;
use App\HistoryTrait;
use App\RemarkTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory, HistoryTrait, RemarkTrait, AddressTrait;

    /**
     * The Job's statuses.
     *
     * @var array
     */
    public $statuses = [
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
    ];

    /**
     * The accessors to append to the Client's array form.
     *
     * @var array
     */
    protected $appends = [
        'address',
        'job',
        'client',
        'remark',
        'get_date',
    ];

    public function getGetDateAttribute()
    {
        return $this->date ? date('Y-m-d', strtotime($this->date)) : '';
    }

    public function getClientAttribute()
    {
        return Client::find($this->client_id) ?? 'client not found';
    }

    public function getJobAttribute()
    {
        return Job::find($this->job_id) ?? 'job not found';
    }
}
