<?php /** @noinspection PhpMissingParentConstructorInspection */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OtpModel extends Model
{
    use Notifiable;

    protected $tel;
    protected $otpValue;

    /**
     * OtpModel constructor.
     * @param $otp
     * @param $tel
     */
    public function __construct($otp, $tel)
    {
        $this->otpValue = $otp;
        $this->tel = $tel;
    }

    public function routeNotificationForNexmo($notification)
    {
        return $this->tel;
    }
}
