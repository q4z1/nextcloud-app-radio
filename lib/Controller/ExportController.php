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

		$stations = $this->service->findAll($this->userId);
		$pls = "[playlist]\nnumberofentries=" . count((array)$stations) . "\n";
		$i = 0;
		foreach($stations as $station) {
			$i++;
			$pls .= "File$i=" . $station->getUrlresolved() . "\n"
					. "Title$i=" . $station->getName() . "\n"
					. "Length$i=-1\n";
		}
		$pls .= "Version=2";
		return new ExportResponse($pls);

	}

}
