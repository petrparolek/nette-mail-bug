<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Services\EmailSender;

final class HomepagePresenter extends BasePresenter
{

	/**
	 * @var EmailSender
	 * @inject
	 */
	public $emailSender;

	public function actionDefault()
	{
		$this->emailSender->send();
	}

}
