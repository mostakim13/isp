<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MInterface extends Model
{
    use HasFactory;

    protected $fillable = [
        'mid',
        'name',
        'default_name',
        'type',
        'mtu',
        'actual_mtu',
        'l2mtu',
        'max_l2mtu',
        'mac_address',
        'last_link_down_time',
        'last_link_up_time',
        'link_downs',
        'rx_byte',
        'tx_byte',
        'rx_packet',
        'tx_packet',
        'rx_drop',
        'tx_drop',
        'tx_queue_drop',
        'rx_error',
        'tx_error',
        'fp_rx_byte',
        'fp_tx_byte',
        'fp_rx_packet',
        'fp_tx_packet',
        'running',
        'disabled'
    ];



    /**
     * Get the interface Rx bytes.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return htmlspecialchars($value);
    }
    /**
     * Get the interface Rx bytes.
     *
     * @param  string  $value
     * @return string
     */
    public function getRxByteAttribute($value)
    {
        return format_bytes($value, 0);
    }

    /**
     * Get the interface Tx bytes.
     *
     * @param  string  $value
     * @return string
     */
    public function getTxByteAttribute($value)
    {
        return format_bytes($value, 0);
    }

    /**
     * Get the interface Tx bytes.
     *
     * @param  string  $value
     * @return string
     */
    public function getRxPacketAttribute($value)
    {
        return format_bytes($value, 0);
    }

    /**
     * Get the interface Tx bytes.
     *
     * @param  string  $value
     * @return string
     */
    public function getTxPacketAttribute($value)
    {
        return format_bytes($value, 0);
    }


    /**
     * Get the interface FpRxByte .
     *
     * @param  string  $value
     * @return string
     */
    public function getFpRxByteAttribute($value)
    {
        return format_bytes($value, 0);
    }

    /**
     * Get the interface FpRxByte .
     *
     * @param  string  $value
     * @return string
     */
    public function getFpTxByteAttribute($value)
    {
        return format_bytes($value, 0);
    }
}
