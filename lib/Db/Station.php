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

namespace OCA\Radio\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Station extends Entity implements JsonSerializable {
	protected $stationuuid;
	protected $name;
	protected $favicon;
	protected $urlresolved;
	protected $bitrate;
	protected $country;
	protected $language;
	protected $homepage;
	protected $codec;
	protected $tags;
	protected $userId;

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'stationuuid' => $this->stationuuid,
			'name' => $this->name,
			'favicon' => $this->favicon,
			'url_resolved' => $this->urlresolved,
			'bitrate' => $this->bitrate,
			'country' => $this->country,
			'language' => $this->language,
			'homepage' => $this->homepage,
			'codec' => $this->codec,
			'tags' => $this->tags
		];
	}
}
