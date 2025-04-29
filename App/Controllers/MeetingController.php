<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\Meeting;
use function App\Helpers\clean;
class MeetingController extends BaseController
{
    private Meeting $meeting;

    public function __construct()
    {
        $this->meeting = new Meeting();

        $this->layout = new Layout(
            new Navbar([
                'brand' => 'IET_Meetings',
                'items' => [
                    ['label' => 'Logout', 'href' => '#'],
                    ['label' => 'Profile', 'href' => '#']
                ]
            ]),
            new Sidebar([
                'items' => [
                    ['label' => 'Schedule Meeting', 'href' => route('ietmeeting.create')],
                    ['label' => 'My Meetings', 'href' => route('ietmeeting.my')],
                    ['label' => 'Posts', 'href' => route('ietpost.all')],
                ]
            ])
        );
    }

    /**
     * Show form to create a new meeting
     */
    public function createForm(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }

        echo $this->render('meetings/create', [
            'title' => 'Schedule New Meeting',
        ]);
    }

    /**
     * Store meeting in DB
     */
    public function store(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }
        
        $title       = clean('default', $_POST['title'] ?? '');
        $room_code   = clean('default', $_POST['room_code'] ?? '');
        $scheduled_at = clean('datetime', $_POST['scheduled_at'] ?? '');
        $password  = clean('default', $_POST['password'] ?? '');
        $isInstant = isset($_POST['is_instant']) && $_POST['is_instant'] === '1';

        $this->meeting->is_instant = $isInstant;
        $this->meeting->host_id      = (int)$_SESSION['user_id'];
        $this->meeting->title        = $title;
        $this->meeting->room_code    = $room_code;
        $this->meeting->scheduled_at = $scheduled_at;
        $this->meeting->password = $password;
        if ($this->meeting->store()) {
            if ($isInstant) {
                $meeting = $this->meeting->fetchByRoomCode($room_code);
                redirect(route('ietmeeting.show', ['id' => $meeting->id]));
            } else {
                $_SESSION['success'] = '✅ Meeting scheduled successfully.';
                redirect(route('ietmeeting.my'));
            }
        } else {
            $_SESSION['errors']['store'] = '❌ Failed to schedule meeting.';
            redirect(route('ietmeeting.create'));
        }
    }

    public function join(int $id): void
{
    if (!$this->isLoggedIn()) {
        redirect(route('auth.login'));
    }

    $meeting = $this->meeting->fetchById($id);

    if (!$meeting) {
        $_SESSION['errors']['not_found'] = 'Meeting not found.';
        redirect(route('ietmeeting.my'));
    }

    echo $this->render('meetings/room', [
        'title' => 'Join Meeting',
        'roomCode' => $meeting->room_code
    ]);
}


    /**
     * Display all meetings for the logged-in host
     */
    public function myMeetings(): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }

        $meetings = $this->meeting->fetchByHost((int)$_SESSION['user_id']);

        echo $this->render('meetings/my_meetings', [
            'title' => 'My Scheduled Meetings',
            'meetings' => $meetings,
        ]);
    }

    /**
     * Show meeting details by ID
     */
    public function show(int $id): void
    {
        if (!$this->isLoggedIn()) {
            redirect(route('auth.login'));
        }

        $meeting = $this->meeting->fetchById($id);

        if (!$meeting) {
            $_SESSION['errors']['not_found'] = 'Meeting not found.';
            redirect(route('meeting.my'));
        }

        echo $this->render('meetings/show', [
            'title' => 'Meeting Details',
            'meeting' => $meeting,
        ]);
    }
}
