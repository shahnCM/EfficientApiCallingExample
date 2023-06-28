<?php

namespace App\Notifications;

use App\Http\Services\CompanyService;
use App\Models\CompanyDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Mail extends Notification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 25;
    public array $backoff = [30, 90, 360];
    public CompanyDetail $companyDetail;

    public function __construct(CompanyDetail $companyDetail)
    {
        $this->companyDetail = $companyDetail;
    }
    public function toMail(AnonymousNotifiable $notifiable): ?MailMessage
    {
        $mailData = $this->companyDetail;
        $symbolList = resolve(CompanyService::class)->getCompanySymbolList();
        $companyName = $symbolList[$mailData->symbol];
        return (new MailMessage())->subject($companyName)->view('mail.template', compact('mailData'));
    }

    public function via(AnonymousNotifiable $notifiable): array
    {
        return ['mail'];
    }
}
