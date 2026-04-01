<?php

namespace App\Notifications;

use App\Enums\StudentStatus;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PpdbStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Student $student,
        protected StudentStatus $status,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject("Status Pendaftaran PPDB - {$this->status->label()}")
            ->greeting("Halo, {$this->student->full_name}!")
            ->line("Kode Pendaftaran: **{$this->student->registration_code}**");

        if ($this->status === StudentStatus::Accepted) {
            $mail->line('Selamat! Pendaftaran Anda telah **diterima**.')
                ->line('Silakan datang ke sekolah untuk verifikasi berkas fisik dengan membawa bukti pendaftaran.')
                ->action('Cetak Bukti Pendaftaran', url('/ppdb/print'));
        } elseif ($this->status === StudentStatus::Rejected) {
            $mail->line('Mohon maaf, pendaftaran Anda **ditolak**.');

            if ($this->student->rejection_reason) {
                $mail->line("**Alasan:** {$this->student->rejection_reason}");
            }

            $mail->line('Silakan hubungi pihak sekolah untuk informasi lebih lanjut.');
        }

        $mail->line('Terima kasih telah mendaftar di SDN 001 Kepenuhan.');

        return $mail;
    }
}
