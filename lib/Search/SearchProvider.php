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

namespace OCA\Radio\Search;

use OCA\Radio\AppInfo\Application;
use OCP\IUser;
use OCP\IURLGenerator;
use OCP\Search\IProvider;
use OCP\Search\ISearchQuery;
use OCP\Search\SearchResult;
use OCP\Search\SearchResultEntry;

use OCP\Http\Client\IClientService;

use function urlencode;

class SearchProvider implements IProvider {

	/** @var IClientService */
	private $clientService;

	/** @var IURLGenerator */
	private $url;

	public function __construct(
		IClientService $clientService,
		IURLGenerator $url
	) {
		$this->clientService = $clientService;
		$this->url = $url;
	}

	public function getId(): string {
		return Application::APP_ID;
	}

	public function getName(): string {
		return 'Radio';
	}

	public function getOrder(string $route, array $routeParameters): int {
		if (strpos($route, 'files' . '.') === 0) {
			return 25;
		} elseif (strpos($route, Application::APP_ID . '.') === 0) {
			return -1;
		}
		return 4;
	}

  public function search(IUser $user, ISearchQuery $query): SearchResult {

		$term = $query->getTerm();
		$url = "https://de1.api.radio-browser.info/json/stations/byname/" . $term . "?limit=20";

		$client = $this->clientService->newClient();
		try {
			$response = $client->get($url);
		} catch (Exception $e) {
			$this->logger->error("Could not search for radio stations: " . $e->getMessage());
			throw $e;
		}
		$body = $response->getBody();
		$parsed = json_decode($body, true);

		$result = array_map(function (array $result) use ($term) {
			return new SearchResultEntry(
				$result['favicon'],
				$result['name'],
				str_replace(",",", ",$result['tags']),
				$this->url->linkToRouteAbsolute('radio.page.index') . '#/search/' . $term,
				'icon-radio-trans'
			);
		}, $parsed);

		return SearchResult::complete(
			$this->getName(),
			$result
		);
	}
}
