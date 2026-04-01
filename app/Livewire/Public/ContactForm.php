<?php

namespace App\Livewire\Public;

use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ContactForm extends Component
{
    #[Validate('required|min:3|max:255')]
    public $name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('required|min:5|max:255')]
    public $subject = '';

    #[Validate('required|min:10|max:1000')]
    public $message = '';

    public $successMessage = '';

    public function submit()
    {
        // Rate limiting: 3 messages per hour per IP
        $executed = RateLimiter::attempt(
            'contact-form:' . request()->ip(),
            $perMinute = 3,
            function() {
                $this->validate();

                Contact::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'subject' => $this->subject,
                    'message' => $this->message,
                    'is_read' => false,
                ]);

                $this->reset(['name', 'email', 'subject', 'message']);
                $this->successMessage = 'Pesan Anda berhasil dikirim! Kami akan menghubungi Anda kembali secepatnya.';
            },
            $decaySeconds = 3600
        );

        if (! $executed) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak pesan yang dikirim (' . RateLimiter::availableIn('contact-form:' . request()->ip()) .' detik lagi). Silakan coba lagi nanti.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.public.contact-form');
    }
}
