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

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\Entity;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class RecentMapper extends QBMapper {
	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'recent', Station::class);
	}

	/**
	 * @param int $id
	 * @param string $userId
	 * @return Entity|Station
	 * @throws \OCP\AppFramework\Db\MultipleObjectsReturnedException
	 * @throws DoesNotExistException
	 */
	public function find(int $id, string $userId): Station {
		/* @var $qb IQueryBuilder */
		$qb = $this->db->getQueryBuilder();
		$qb->selectDistinct('stationuuid')
			->addSelect('name')
			->addSelect('favicon')
			->addSelect('urlresolved')
			->addSelect('bitrate')
			->addSelect('country')
			->addSelect('language')
			->addSelect('homepage')
			->addSelect('codec')
			->addSelect('tags')
			->from('recent')
			->orderBy('id', 'DESC')
			->where($qb->expr()->eq('id', $qb->createNamedParameter($id, IQueryBuilder::PARAM_INT)))
			->andWhere($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));
		return $this->findEntity($qb);
	}

	/**
	 * @param string $userId
	 * @return array
	 */
	public function findAll(string $userId): array {
		/* @var $qb IQueryBuilder */
		$qb = $this->db->getQueryBuilder();
		$qb->selectDistinct('stationuuid')
			->addSelect('name')
			->addSelect('favicon')
			->addSelect('urlresolved')
			->addSelect('bitrate')
			->addSelect('country')
			->addSelect('language')
			->addSelect('homepage')
			->addSelect('codec')
			->addSelect('tags')
			->from('recent')
			->orderBy('id', 'DESC')
			->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));
		return $this->findEntities($qb);
	}
}
