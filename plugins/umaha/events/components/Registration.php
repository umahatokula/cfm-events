<?php namespace Umaha\Events\Components;

use Cms\Classes\ComponentBase;
use Flash;
use Redirect;
use Mail;
use Input;
use Umaha\Events\Models\Registration as RegistrationComp;
use Umaha\Events\Models\Event as EventModel;
use Umaha\Centres\Models\Centre as CentreModel;
use Validator;
use ValidationException;
use Event;
use Auth;

class Registration extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Registration Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
          'event' => [
               'title'             => 'Event',
               'description'       => 'Select an event',
               'default'           => 1,
               'type'              => 'dropdown'
          ],
            'title' => [
                 'title'             => 'Title',
                 'description'       => 'Display the title field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'gender' => [
                 'title'             => 'Gender',
                 'description'       => 'Display the gender field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'marital_status' => [
                 'title'             => 'Marital Status',
                 'description'       => 'Display the marital status field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'is_partner' => [
                 'title'             => 'Are you a partner?',
                 'description'       => 'Display the Are you a partner field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'email' => [
                 'title'             => 'Email',
                 'description'       => 'Display the email field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'occupation' => [
                 'title'             => 'Occupation',
                 'description'       => 'Display the occupation field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'location' => [
                 'title'             => 'Location',
                 'description'       => 'Display the location field or not',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
            'address' => [
                 'title'             => 'Address',
                 'description'       => 'Display the address field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'church_name' => [
                 'title'             => 'Church name',
                 'description'       => 'Display the church name field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'pastor_name' => [
                 'title'             => 'Pastor Name',
                 'description'       => 'Display the pastor name field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'spouse' => [
                 'title'             => 'Spouse',
                 'description'       => 'Display the spouse field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'children' => [
                 'title'             => 'Children',
                 'description'       => 'Display the children field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'children_no' => [
                 'title'             => 'Number of children',
                 'description'       => 'Display the number of children field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'accommodation' => [
                 'title'             => 'Accommodation',
                 'description'       => 'Display the accommodation field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'accommodation' => [
                 'title'             => 'Accommodation',
                 'description'       => 'Display the accommodation field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'feeding' => [
                 'title'             => 'Feeding',
                 'description'       => 'Display the feeding field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'transportation' => [
                 'title'             => 'Transportation',
                 'description'       => 'Display the transportation field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'coming_with_car' => [
                 'title'             => 'Are you coming with a car?',
                 'description'       => 'Displays if he/she will be coming to the event with a car',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
            'assist_with_car' => [
                 'title'             => 'Are you willing to use your car to transport people to and fro the event venue?',
                 'description'       => 'Displays if he/she is willing to use car to help transport people to and fro event venue',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
            'arrival_date' => [
                 'title'             => 'Arrival date',
                 'description'       => 'Display the arrival date field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'departure_date' => [
                 'title'             => 'Departure date',
                 'description'       => 'Display the departure date field or not',
                 'default'           => 1,
                 'type'              => 'checkbox'
            ],
            'cfc_center' => [
                 'title'             => 'CFC Center',
                 'description'       => 'Display the CFC Center field or not',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
            'service_team' => [
                 'title'             => 'Service Team',
                 'description'       => 'Display the Service Team field or not',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
            'position_held' => [
                 'title'             => 'Position Held',
                 'description'       => 'Display the Position Held field or not',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
            'attendance_mode' => [
                 'title'             => 'Will attendee attend onsite or online',
                 'description'       => 'Will attendee attend onsite or online',
                 'default'           => 0,
                 'type'              => 'checkbox'
            ],
        ];
    }

    public function onRegister() {
     //     dd(post());
        try {

            $data = post();

            $rules = [
               // 'title'            => 'required',
               'name'            => 'required',
               // 'email'           => 'email',
               // 'phone'           => 'required',
               // 'location'        => 'required',
               // 'marital_status'  => 'required',
               // 'phone'           => 'required',
               // 'gender'          => 'required',
               // 'is_partner'      => 'required',
               // 'occupation'      => 'required',
               // 'address'         => 'required',
               // 'church_name'     => 'required',
               // 'cfc_center'     => 'required',
               // 'pastor_name'     => 'required',
               // 'spouse'          => 'required',
               // 'children'        => 'required',
               // 'children_no'     => 'required',
               // 'children_ages'   => 'required',
               'attendance_mode'  => 'required',
               // 'arrival_date'    => 'required_if:attendance_mode,Onsite',
               // 'departure_date'  => 'required_if:attendance_mode,Onsite',
               // 'accommodation'   => 'required',
               // 'feeding'         => 'required',
               // 'transportation'  => 'required',
               // 'coming_with_car' => 'required',
               // 'assist_with_car' => 'required',
               ];

               $validator = Validator::make($data, $rules);

               if ($validator->fails()) {
                    throw new ValidationException($validator);

               }

            $eventId = $this->property('event');;
            $event = EventModel::where('id', $eventId)->first();

            $alreadyRegistered = RegistrationComp::where([
                'name'           => post('name'),
                'gender'         => post('gender'),
                'marital_status' => post('marital_status'),
                'phone'          => post('phone'),
                'email'          => post('email'),
                'occupation'     => post('occupation'),
                'event_slug'     => $event->slug,
                ])->first();

            if (!is_null($alreadyRegistered)) {
                Flash::warning('It seems you have already registered. Kindly check your mail');
                return Redirect::back()->withInput();
            }

            $lastRegistrationNumber = RegistrationComp::where('event_slug', $event->slug)->orderBy('created_at', 'desc')->first();
            if($lastRegistrationNumber) {
                $event_registration_number = $lastRegistrationNumber->event_registration_number;
            } else {
                $event_registration_number = 0;
            }

            $reg = new RegistrationComp;
            $reg->event_registration_number = $event_registration_number + 1;
            $reg->title                     = post('title');
            $reg->name                      = post('name');
            $reg->gender                    = post('gender');
            $reg->marital_status            = post('marital_status');
            $reg->phone                     = post('phone');
            $reg->email                     = post('email');
            $reg->is_partner                = post('is_partner');
            $reg->occupation                = post('occupation');
            $reg->address                   = post('address');
            $reg->church_name               = post('church_name');
            $reg->pastor_name               = post('pastor_name');
            $reg->spouse                    = post('spouse');
            $reg->children                  = post('children');
            $reg->children_no               = post('children_no');
            $reg->children_ages             = post('children_ages');
            $reg->arrival_date              = post('arrival_date');
            $reg->departure_date            = post('departure_date');
            $reg->accommodation             = post('accommodation');
            $reg->feeding                   = post('feeding');
            $reg->transportation            = post('transportation');
            $reg->coming_with_car           = post('coming_with_car');
            $reg->assist_with_car           = post('assist_with_car');
            $reg->attendance_mode           = post('attendance_mode');
            $reg->event_slug                = $event->slug;
            $reg->save();

          // Fire registered event
          //   if($reg) {
          //       Event::fire('umaha.events.registration', [$reg, $event]);
          //   }

          // Send mail after delay of 5 seconds
          if (post('email')) {
               $vars = ['user' => $reg, 'event' => $event];

               Mail::queue('umaha.events::mail.fa2021', $vars, function($message) use ($event) {

                    $message->to((array)post('email'), post('name'));
                    $message->subject($event->name);

               });
          }

          Flash::success('Registration successful');
          // return redirect()->back();
          // return Redirect::to('thanks-registering');

        } catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }

    }

    public function onRender() {
        $this->page['centres'] = CentreModel::all();
    }

    public function getEventOptions()
    {
        return EventModel::lists('name', 'id');
    }

    public function onRegForm() {
         
          return ['.modal-body' => $this->renderPartial('@default.htm', [
               'centers' => CentreModel::all()
          ])];

    }
}
