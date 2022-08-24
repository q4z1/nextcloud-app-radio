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

namespace OCA\Radio;

use OC;
use OC\HintException;
use OCP\AppFramework\Http\Response;

class ExportResponse extends Response {
	private $returnstring;

	public function __construct($returnstring) {
		parent::__construct();

		$user = OC::$server->getUserSession()->getUser();
		if (is_null($user)) {
			throw new HintException('User not logged in');
		}

		$userName = $user->getDisplayName();
		$productName = OC::$server->getThemingDefaults()->getName();
		$dateTime = OC::$server->getDateTimeFormatter();

		$export_name = '"' . $productName . ' Radio Favorites (' . $userName . ') (' . $dateTime->formatDate(time()) . ').xspf"';
		$this->addHeader("Cache-Control", "private");
		$this->addHeader("Content-Type", " application/xspf+xml");
		$this->addHeader("Content-Length", strlen($returnstring));
		$this->addHeader("Content-Disposition", "attachment; filename=" . $export_name);
		$this->returnstring = $returnstring;
	}

	public function render() {
		return $this->returnstring;
	}
}