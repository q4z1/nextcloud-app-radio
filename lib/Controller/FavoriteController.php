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

use OCA\Radio\AppInfo\Application;
use OCA\Radio\Service\FavoriteService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class FavoriteController extends Controller {
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
	public function index(): DataResponse {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @NoAdminRequired
	 */
	public function show(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

	/**
	 * @NoAdminRequired
	 */
	 public function create(string $stationuuid, string $name, string $favicon, string $urlresolved,
 		string $bitrate, string $country, string $language, string $homepage,
 		string $codec, string $tags): DataResponse {
 		return new DataResponse($this->service->create($stationuuid, $name,
 			$favicon, $urlresolved, $bitrate, $country, $language, $homepage, $codec,
 			$tags, $this->userId));
 	}

	/**
	 * @NoAdminRequired
	 */
	 public function update(int $id, string $stationuuid,
 						   string $name, string $favicon, string $urlresolved,
 							 string $bitrate, string $country, string $language, string $homepage,
 					 		 string $codec, string $tags): DataResponse {
 		return $this->handleNotFound(function () use ($id, $stationuuid, $name,
 			$favicon, $urlresolved, $bitrate, $country, $language, $homepage, $codec,
 			$tags) {
 			return $this->service->update($id, $stationuuid, $name, $favicon,
 				$urlresolved, $bitrate, $country, $language, $homepage, $codec,
 				$tags, $this->userId);
 		});
 	}

	/**
	 * @NoAdminRequired
	 */
	public function destroy(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->delete($id, $this->userId);
		});
	}
}
