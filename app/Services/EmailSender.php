<?php

declare(strict_types=1);

namespace App\Services;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\ITemplateFactory;
use Nette\Localization\ITranslator;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use PPIS\Settings\Entities\Settings;
use PPIS\Settings\Repositories\SettingsRepository;

class EmailSender
{

    /**
     * @var LinkGenerator
     */
    private $linkGenerator;

    /**
     * @var IMailer
     */
    private $mailer;

    /**
     * @var ITemplateFactory
     */
    private $templateFactory;

    /**
     * @var ITranslator
     */
    private $translator;

    public function __construct(LinkGenerator $linkGenerator, IMailer $mailer, ITemplateFactory $templateFactory, ITranslator $translator)
    {
        $this->linkGenerator = $linkGenerator;
        $this->mailer = $mailer;
        $this->templateFactory = $templateFactory;
        $this->translator = $translator;
    }


    public function send(): void
    {
        $params = [
            'orderId' => 123,
        ];
        $template = $this->createMailTemplate();
        $html = $template->renderToString(__DIR__ . '/../templates/email.latte', $params);

        $mail = new Message();
        $mail->setFrom('Franta <franta@example.com>')
            ->addTo('petr@example.com')
            ->setHtmlBody($html);

        $this->mailer->send($mail);
    }

    private function createMailTemplate(): ITemplate
    {
        $template = $this->templateFactory->createTemplate();
        $template->getLatte()->addProvider('uiControl', $this->linkGenerator);
        return $template;
    }
}
