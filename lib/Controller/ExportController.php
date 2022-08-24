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

namespace OCA\Radio\Controller;

use OC;
use OCA\Radio\ExportResponse;
use OCA\Radio\AppInfo\Application;
use OCA\Radio\Service\FavoriteService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use SimpleXMLElement;
use DOMDocument;

class ExportController extends Controller {
	/** @var FavoriteService */
	private $service;

	/** @var string */
	private $userId;

	use Errors;

	public function __construct(IRequest $request,
								FavoriteService $service,
								$userId) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @NoAdminRequired
	 */
	public function index() {

		$xml = new SimpleXMLElement('<?xml version="1.0"?><playlist></playlist>');
		$xml->addAttribute('encoding', 'UTF-8');
		$trackList = $xml->addChild('trackList');
		foreach($this->service->findAll($this->userId) as $station) {
			$track = $trackList->addChild('track');
			$track->addChild('location', $station->getUrlresolved());
			$track->addChild('title', $station->getName());
			$track->addChild('image', $station->getFavicon());
		}

		$dom = new DOMDocument("1.0");
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());

		return new ExportResponse($dom->saveXML());

	}

}
