<?php

/**
 * Radio App
 *
 * @author Jonas Heinrich
 * @copyright 2021 Jonas Heinrich <onny@project-insanity.org>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

declare(strict_types=1);

namespace OCA\Radio\AppInfo;

use OC\Security\CSP\ContentSecurityPolicy;
use OCA\Radio\Search\SearchProvider;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\IRequest;

use OCA\Radio\Dashboard\RadioWidget;

class Application extends App implements IBootstrap {

	public const APP_ID = 'radio';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {

		$context->registerSearchProvider(SearchProvider::class);
		$context->registerDashboardWidget(RadioWidget::class);

		$context->registerService('request', static function ($c) {
			return $c->get(IRequest::class);
		});

		$this->registerCsp();

	}

	public function boot(IBootContext $context): void {
	}

	/**
	 * Allow radio-browser hosts in the csp
	 *
	 * @throws \OCP\AppFramework\QueryException
	 */
	public function registerCsp() {
		$manager = $this->getContainer()->getServer()->getContentSecurityPolicyManager();
		$policy  = new ContentSecurityPolicy();
		$policy->addAllowedConnectDomain('https://de1.api.radio-browser.info');
		$policy->addAllowedImageDomain('*');
		$policy->addAllowedMediaDomain('*');
		$manager->addDefaultPolicy($policy);
	}
}
