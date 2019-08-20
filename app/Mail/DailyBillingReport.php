<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyBillingReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
	 * @var array $seller
    */
    private $seller;

    /**
     * Create a new message instance.
     *
	 * @param \App\Models\Seller $seller
     * @return void
     */
    public function __construct($seller)
    {
        $this->seller = $seller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		setlocale(LC_MONETARY, 'pt_BR');

		return $this
			->from(['address' => 'tray-test@test.com', 'name' => 'Tray Test'])
			->subject ('Relatório de faturamento diário')
			->markdown('mail.daily-billing-report')
			->with([
				'seller' => $this->seller
			]);
    }
}
