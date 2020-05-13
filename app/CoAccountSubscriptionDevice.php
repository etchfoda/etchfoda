<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class CoAccountSubscriptionDevice
 * @package App
 * @property int id
 * @property int subscription_id
 * @property string device_id
 * @property string device_name
 * @property string token
 * @property array|null ips
 * @property Carbon last_activity
 */
class CoAccountSubscriptionDevice extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use SoftDeletes, Auditable;

    protected $excludedAttributes = ['last_activity', 'ips', 'token'];

    protected $fillable = [ 'subscription_id', 'device_id', 'device_name', 'token', 'ips', 'last_activity' ];

    protected $casts = [
        'ips' => 'array',
        'last_activity' => 'datetime',
    ];

    public function subscription(){
        return $this->belongsTo(CoAccountSubscription::class, 'subscription_id');
    }
}
