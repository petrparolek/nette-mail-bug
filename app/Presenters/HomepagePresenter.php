<?php

declare(strict_types=1);

namespace App\Presenters;


use Latte\Engine;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

final class HomepagePresenter extends BasePresenter
{

    /**
     * @var IMailer
     */
    public $mailer;

	public function renderDefault(): void
	{
        $latte = new Engine();
        $params = [
            'orderId' => 123,
        ];

        $mail = new Message();
        $mail->setFrom('Franta <franta@example.com>')
            ->addTo('petr@example.com')
            ->setHtmlBody(
                $latte->renderToString(__DIR__ . '/templates/email.latte', $params)
            );

        $this->mailer->send();
    }
}
