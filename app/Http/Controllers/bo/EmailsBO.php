<?php

namespace App\Http\Controllers\bo;

use App\Http\Controllers\bo\LogsBO;
use Exception;
use Log;

class EmailsBO {

    protected $logsBO;

    public function __construct (LogsBO $logsBO) {
        $this->logsBO = $logsBO;
    }

    public function send ($parameters, $template) {

        try {
            \Mail::send('emails.'.$template, $parameters, function ($m) use ($parameters) {
                $m->from($parameters['fromMail'], $parameters['fromName']);
                $m->to($parameters['toMail'], $parameters['toName'])->subject($parameters['subject']);
            });
        } catch (Exception $e) {
            $dataInput = 'DADOS: '.implode(', ', $parameters).' | TEMPLATE: '.$template.' | ';
            $log = $this->logsBO->store(['action' => 'error_send_email.'.$template, 'data' => $dataInput.$e]);
            Log::debug($e);
        }
    }

    public function passwordReset ($password, $user) {

        $p = [
            'password' => $password,
            'fromMail' => env('MAIL_FROM'),
            'fromName' => env('MAIL_NAME'),
            'toName' => $user->name,
            'toMail' => $user->email,
            'subject' => '🔑 Updated password'
        ];

        EmailsBO::send($p, 'password-reset');
    }

    public function passwordRequest ($token, $user) {
        
        $p = [
            'token' => $token,
            'fromMail' => env('MAIL_FROM'),
            'fromName' => env('MAIL_NAME'),
            'toName' => $user->name,
            'toMail' => $user->email,
            'subject' => '🔑 Password change request'
        ];

        EmailsBO::send($p, 'password-request');
    }

    public function userCreate ($password, $user) {

        $p = [
            'password' => $password,
            'fromMail' => env('MAIL_FROM'),
            'fromName' => env('MAIL_NAME'),
            'toName' => $user->name,
            'toMail' => $user->email,
            'subject' => '🤜🤛 Welcome! '
        ];

        EmailsBO::send($p, 'user-create');
    }

    public function guestInvite ($token, $guest) {

        $p = [
            'token' => $token,
            'fromMail' => env('MAIL_FROM'),
            'fromName' => env('MAIL_NAME'),
            'toName' => $guest->name,
            'toMail' => $guest->email,
            'event_id' => $guest->event_id,
            'event_name' => $guest->event_name,
            'event_date' => $guest->event_date,
            'event_place' => $guest->event_place,
            'subject' => '🎅 🎄 Invitation: '.$guest->event_name
        ];

        EmailsBO::send($p, 'guest-invite');
    }
    
    public function guestConfirm ($token, $guest) {

        $p = [
            'token' => $token,
            'fromMail' => env('MAIL_FROM'),
            'fromName' => env('MAIL_NAME'),
            'toName' => $guest->name,
            'toMail' => $guest->email,
            'event_id' => $guest->event_id,
            'event_name' => $guest->event_name,
            'event_date' => $guest->event_date,
            'event_place' => $guest->event_place,
            'subject' => '🎅 🎄 Confirmed invitation: '.$guest->event_name,
            'guest' => $guest
        ];

        EmailsBO::send($p, 'guest-confirm');
    }
}
