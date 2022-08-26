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

namespace OCA\Radio\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Radio\Db\Station;
use OCA\Radio\Db\FavoriteMapper;

class FavoriteService {

	/** @var FavoriteMapper */
	private $mapper;

	public function __construct(FavoriteMapper $mapper) {
		$this->mapper = $mapper;
	}

	public function findAll(string $userId): array {
		return $this->mapper->findAll($userId);
	}

	private function handleException(Exception $e): void {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new StationNotFound($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find($id, $userId) {
		try {
			return $this->mapper->find($id, $userId);

			// in order to be able to plug in different storage backends like files
		// for instance it is a good idea to turn storage related exceptions
		// into service related exceptions so controllers and service users
		// have to deal with only one type of exception
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function create($stationuuid, $name, $favicon, $url_resolved,
	 	$bitrate, $country, $language, $homepage, $codec, $tags, $userId) {
		$station = new Station();
		$station->setStationuuid($stationuuid);
		$station->setName($name);
		$station->setFavicon($favicon);
		$station->setUrlresolved($url_resolved);
		$station->setBitrate($bitrate);
		$station->setCountry($country);
		$station->setLanguage($language);
		$station->setHomepage($homepage);
		$station->setCodec($codec);
		$station->setTags($tags);
		$station->setUserId($userId);
		return $this->mapper->insert($station);
	}

	public function update($id, $stationuuid, $name, $favicon, $url_resolved,
		$bitrate, $country, $language, $homepage, $codec, $tags, $userId) {
		try {
			$station = $this->mapper->find($id, $userId);
			$station->setStationuuid($stationuuid);
			$station->setName($name);
			$station->setFavicon($favicon);
			$station->setUrlresolved($url_resolved);
			$station->setBitrate($bitrate);
			$station->setCountry($country);
			$station->setLanguage($language);
			$station->setHomepage($homepage);
			$station->setCodec($codec);
			$station->setTags($tags);
			return $this->mapper->update($station);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete($id, $userId) {
		try {
			$station = $this->mapper->find($id, $userId);
			$this->mapper->delete($station);
			return $station;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
}
