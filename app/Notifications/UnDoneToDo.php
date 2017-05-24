<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class UnDoneToDo extends Notification
{
    use Queueable;

    protected $todo;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($td,$ur)
    {
        $this->todo = $td;
        $this->user = $ur;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
//    public function via($notifiable)
//    {
//        return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];
//    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You Have UnDone Task named '.$this->todo->name)
            ->action('Notification Action', 'http://localhost:8000/todo/info/'.$this->todo->id)
            ->line('Thank you for using our application!');
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', 'https://laravel.com')
//                    ->line('Thank you for using our application!');
    }
    /*
     * Get telegram
     */
    public function toTelegram($notifiable)
    {
        $url = url('http://localhost:8000/todo/info/'.$this->todo->id);

        return TelegramMessage::create()
            ->to($this->user->telegram_user_id) // Optional.
            ->content("*HELLO!* \n You Have UnDone Task named ".$this->todo->name) // Markdown supported.
            ->button('Notification Action', $url); // Inline Button
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
