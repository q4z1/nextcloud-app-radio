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

namespace OCA\Radio\Service;

use OCP\IURLGenerator;
use OCP\Http\Client\IClientService;

use function urlencode;

class RadioBrowserApiService {

	/** @var IClientService */
	private $clientService;

	/** @var IURLGenerator */
	private $url;

	public $baseUrl = "https://api.fyyd.de/0.2";

	public function __construct(
		IClientService $clientService,
		IURLGenerator $url
	) {
		$this->clientService = $clientService;
		$this->url = $url;
	}

  public function queryEpisodes(int $podcast_id, int $count = 20, int $page = 0) {

		$url = $this->baseUrl . "/podcast/episodes";

		$options['query'] = [
			'podcast_id' => $podcast_id,
			'count' => $count,
			'page' => $page
		];

		$client = $this->clientService->newClient();
		try {
			$response = $client->get($url, $options);
		} catch (Exception $e) {
			$this->logger->error("Could not search for podcasts: " . $e->getMessage());
			throw $e;
		}
		$body = $response->getBody();

		$parsed = json_decode($body, true);

		return $parsed;
	}

	public function queryEpisode(int $episode_id) {

		$url = $this->baseUrl . "/episode";

		$options['query'] = [
			'episode_id' => $episode_id,
		];

		$client = $this->clientService->newClient();
		try {
			$response = $client->get($url, $options);
		} catch (Exception $e) {
			$this->logger->error("Could not search for podcasts: " . $e->getMessage());
			throw $e;
		}
		$body = $response->getBody();
		$parsed = json_decode($body, true);

		return $parsed;
	}

	public function queryPodcast(int $podcast_id) {

		$url = $this->baseUrl . "/podcast";

		$options['query'] = [
			'podcast_id' => $podcast_id,
		];

		$client = $this->clientService->newClient();
		try {
			$response = $client->get($url, $options);
		} catch (Exception $e) {
			$this->logger->error("Could not search for podcasts: " . $e->getMessage());
			throw $e;
		}
		$body = $response->getBody();
		$parsed = json_decode($body, true);

		return $parsed;
	}

	public function queryCategory(string $category, int $count = 20,
		int $page = 0) {

		if ($category === 'hot') {
			$url = $this->baseUrl . "/feature/podcast/hot";
			$options['query'] = [
				'count' => $count,
				'page' => $page,
			];
		} else if ($category === 'latest') {
			$url = $this->baseUrl . "/podcast/latest";
			$options['query'] = [
				'count' => $count,
				'page' => $page,
			];
		} else {
			$url = $this->baseUrl . "/category";
			$options['query'] = [
				'count' => $count,
				'page' => $page,
				'category_id' => $category,
			];
		}

		$client = $this->clientService->newClient();
		try {
			$response = $client->get($url, $options);
		} catch (Exception $e) {
			$this->logger->error("Could not search for podcasts: " . $e->getMessage());
			throw $e;
		}
		$body = $response->getBody();
		$parsed = json_decode($body, true);

		return $parsed;
	}
}
