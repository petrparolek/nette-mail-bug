<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplate;
use Nette\Localization\ITranslator;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

final class HomepagePresenter extends BasePresenter
{

    /**
     * @var LinkGenerator
     * @inject
     */
    public $linkGenerator;

    /**
     * @var IMailer
     * @inject
     */
    public $mailer;

    /**
     * @var ITranslator
     * @inject
     */
    public $translator;

	public function renderDefault(): void
	{
        $params = [
            'orderId' => 123,
        ];
        $template = $this->createMailTemplate();
        $html = $template->renderToString(__DIR__ . '/templates/email.latte', $params);

        $mail = new Message();
        $mail->setFrom('Franta <franta@example.com>')
            ->addTo('petr@example.com')
            ->setHtmlBody($html);

        $this->mailer->send($mail);
    }

    private function createMailTemplate(): ITemplate
    {
        $template = $this->getTemplateFactory()->createTemplate();
        $template->getLatte()->addProvider('uiControl', $this->linkGenerator);
        return $template;
    }

}
