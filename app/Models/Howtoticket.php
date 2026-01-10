<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Howtoticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'sign_up_first_login',
        'complete_your_profile',
        'choose_a_ticket',
        'sign_up_first_login_icon',
        'complete_your_profile_icon',
        'choose_a_ticket_icon',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'sign_up_first_login' => 'array',
        'complete_your_profile' => 'array',
        'choose_a_ticket' => 'array',
    ];

    /**
     * Get localized title
     */
    public function getTitle($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $title = $this->title;

        if (is_string($title)) {
            $title = json_decode($title, true);
        }

        return $title[$locale] ?? $title['en'] ?? '';
    }

    /**
     * Get localized description
     */
    public function getDescription($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $description = $this->description;

        if (is_string($description)) {
            $description = json_decode($description, true);
        }

        return $description[$locale] ?? $description['en'] ?? '';
    }

    /**
     * Get localized sign up first login text
     */
    public function getSignUpFirstLogin($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $text = $this->sign_up_first_login;

        if (is_string($text)) {
            $text = json_decode($text, true);
        }

        return $text[$locale] ?? $text['en'] ?? '';
    }

    /**
     * Get localized complete your profile text
     */
    public function getCompleteYourProfile($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $text = $this->complete_your_profile;

        if (is_string($text)) {
            $text = json_decode($text, true);
        }

        return $text[$locale] ?? $text['en'] ?? '';
    }

    /**
     * Get localized choose a ticket text
     */
    public function getChooseATicket($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $text = $this->choose_a_ticket;

        if (is_string($text)) {
            $text = json_decode($text, true);
        }

        return $text[$locale] ?? $text['en'] ?? '';
    }
}
