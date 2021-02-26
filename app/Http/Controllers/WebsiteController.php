<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Contacts;
use Response;
use Redirect;

use App\Http\Controllers\bo\GuestsBO;
use App\Http\Controllers\bo\GuestsHistoryBO;
use App\Http\Controllers\bo\EventsBO;
use App\Http\Controllers\bo\EmailsBO;

class WebsiteController extends Controller {
    private $guestsBO;
    private $guestsHistoryBO;
    private $eventsBO;
    private $emailsBO;

    public function __construct (GuestsBO $guestsBO, GuestsHistoryBO $guestsHistoryBO, EventsBO $eventsBO, EmailsBO $emailsBO) {
        $this->guestsBO = $guestsBO;
        $this->guestsHistoryBO = $guestsHistoryBO;
        $this->eventsBO = $eventsBO;
        $this->emailsBO = $emailsBO;
    }

    public function home () {
        return view('website.home');
    }

    public function confirm ($token) {
        // look for valid data for this token
        $lastHistory = $this->guestsBO->getGuestLastHistoryByToken($token);

        // update last status
        if ($lastHistory->status_id == 1) {

            $guests_history = $lastHistory;
            $guests_history->status_id = 2;
            $guests_history->guest_id = $lastHistory->id;

            $this->guestsHistoryBO->store($guests_history);
        }

        $event = $this->eventsBO->getEvent($lastHistory->event_id);

$waiver = '
Toyo Pumps is committed to ensuring that everyone has a safe and fun evening. However, we want to ensure that if anything were to happen that you will not take legal action against Toyo Pumps North America Corp.

I freely and voluntarily accept this release of liability, waiver of claims, assumption of risk and indemnity in connection with the social event being sponsored on Nov 22nd, 2019, by Toyo Pumps North America Corp . (“Toyo Pumps”) .  I agree and acknowledge that I am not obligated to attend the event .   I agree that my attendance at this event, and any consumption of alcoholic beverages at this event, is entirely voluntary and done solely at my own risk .  I also acknowledge that attendance at any such event brings with it the risk of injury, including without limitation, the risk of falling, tripping, slipping or being struck by other persons or falling equipment .   I acknowledge that Toyo Pumps previously recommended that I travel home after the event by taxicab, at Toyo Pumps’ expense, and that I not operate a motor vehicle after the event .   Knowing and accepting the risks set out herein, and in consideration of my attendance at this event, I hereby remise, release, indemnify, forever discharge and hold harmless Toyo Pumps, and its subsidiaries, affiliates, servants, agents, officers, directors, employees, assigns or anyone else acting for  or on their behalf(the “Releasees”), from and against any and all existing and future actions, costs, suits, demands, liability or claims of any kind, for loss, harm, damage, cost or expense, including but not limited to, costs, injuries, accidents, losses and damages related to personal injuries, death, damage to, loss or destruction of property, or from any and all claims of third parties without limitation, which I, my heirs, executors, administrators, personal representatives, successors or assigns, now have, or may hereafter have, arising out of the acts or omissions, or the condition of the property on which the event is conducted, including negligence of the Releasees .   The Releasees shall not be responsible for any of my actions or the actions of any others attending the event, and I hereby assume all risk of injury, illness, disease or death or other damage which may arise in connection therewith .   This Release and its application and interpretation will be governed exclusively by the laws of British Columbia applicable and the parties agree to the jurisdiction of the courts of the Province of British Columbia.

I HEREBY ACKNOWLEDGE HAVING READ THIS RELEASE and WAIVER and I UNDERSTAND and ACCEPT ITS TERMS .
';

        $foodTypes = $this->eventsBO->getFoodTypes();

        return view('website.confirm', compact('lastHistory', 'event', 'waiver', 'foodTypes'));
    }

    public function confirmPost ($token, Request $request) {
        // look for valid data for this token
        $lastHistory = $this->guestsBO->getGuestLastHistoryByToken($token);

        // update last status
        if ($lastHistory->status_id == 2) {

            $this->guestsBO->updateCompanion($lastHistory->id, $request);

            $guests_history = $lastHistory;
            $guests_history->status_id = 3;
            $guests_history->guest_id = $lastHistory->id;

            $this->guestsHistoryBO->store($guests_history);

            $event = $this->eventsBO->getEvent($lastHistory->event_id);

            $guests_history->event_id = $event->id;
            $guests_history->event_name = $event->name;
            $guests_history->event_date = $event->date;
            $guests_history->event_place = $event->place;

            $guestFood = $this->eventsBO->getFoodType($request->guest_food);
            $guests_history->guest_food = $guestFood->food_type;

            $guests_history->allergies = $request->allergies;
            $guests_history->companion = $request->companion;

            if ($request->companion == 1) {
                $companionFood = $this->eventsBO->getFoodType($request->companion_food);
                $guests_history->companion_food = $companionFood->food_type;

                $guests_history->companion_name = $request->companion_name;
            }

            $this->emailsBO->guestConfirm($token, $guests_history);
        }

        return redirect()->back();
    }
}