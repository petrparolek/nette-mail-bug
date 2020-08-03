<?php

declare(strict_types=1);

namespace App\Services;

use Latte\Engine;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplateFactory;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use PPIS\Settings\Entities\Settings;
use PPIS\Settings\Repositories\SettingsRepository;

class EmailSender
{

	/**
	 * @var LinkGenerator
	 */
	public $linkGenerator;

	/**
	 * @var ITemplateFactory
	 */
	public $templateFactory;

	/**
	 * @var IMailer
	 */
	public $mailer;

	/**
	 * @var SettingsRepository
	 */
	public $settingsRepository;

	public function __construct(
		LinkGenerator $linkGenerator,
		ITemplateFactory $templateFactory,
		IMailer $mailer,
		SettingsRepository $settingsRepository
	) {
		$this->linkGenerator = $linkGenerator;
		$this->templateFactory = $templateFactory;
		$this->mailer = $mailer;
		$this->settingsRepository = $settingsRepository;
	}

	public function sendMail($to, $bcc, $subject, $templateFile, $params)
	{
		$mailFrom = $this->settingsRepository->findOneBy(["key" => Settings::EMAIL_FROM])
			->getValue();

		$latte = new Engine();

		$html = $latte->renderToString($templateFile, $params);

		$mail = new Message;

		$mail->setFrom($mailFrom)
			->addTo($to)
			->setSubject($subject)
			->setHtmlBody($html);

		if ($bcc) {
			$mail->addBcc($bcc);
		}

		$this->mailer->send($mail);
	}
}
