/*
 * @copyright Copyright (c) 2021 Jonas Heinrich <onny@project-insanity.org>
 *
 * @author Jonas Heinrich <onny@project-insanity.org>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

const requesttoken = axios.defaults.headers.requesttoken

export class RadioApi {

	url(url) {
		url = `/apps/radio/api${url}`
		return generateUrl(url)
	}

	addFavorite(station) {
		station = {
			id: -1,
			name: station.name.toString(),
			url_resolved: station.url_resolved.toString(),
			favicon: station.favicon.toString(),
			stationuuid: station.stationuuid.toString(),
			bitrate: station.bitrate.toString(),
			country: station.country.toString(),
			language: station.language.toString(),
			homepage: station.homepage.toString(),
			codec: station.codec.toString(),
			tags: station.tags.toString(),
		}
		axios.defaults.headers.requesttoken = requesttoken
		return axios.post(this.url('/favorites'), station)
			.then(
				(response) => {
					return Promise.resolve(response.data)
				},
				(err) => {
					return Promise.reject(err)
				}
			)
			.catch((err) => {
				return Promise.reject(err)
			})
	}

	removeFavorite(station) {
		axios.defaults.headers.requesttoken = requesttoken
		return axios.delete(this.url(`/favorites/${station.id}`))
			.then(
				(response) => {
					return Promise.resolve(response.data)
				},
				(err) => {
					return Promise.reject(err)
				}
			)
			.catch((err) => {
				return Promise.reject(err)
			})
	}

	loadFavorites() {
		axios.defaults.headers.requesttoken = requesttoken
		return axios.get(this.url('/favorites'))
			.then(
				(response) => {
					return Promise.resolve(response.data)
				},
				(err) => {
					return Promise.reject(err)
				}
			)
			.catch((err) => {
				return Promise.reject(err)
			})
	}

	addRecent(station) {
		station = {
			id: -1,
			name: station.name.toString(),
			url_resolved: station.url_resolved.toString(),
			favicon: station.favicon.toString(),
			stationuuid: station.stationuuid.toString(),
			bitrate: station.bitrate.toString(),
			country: station.country.toString(),
			language: station.language.toString(),
			homepage: station.homepage.toString(),
			codec: station.codec.toString(),
			tags: station.tags.toString(),
		}
		axios.defaults.headers.requesttoken = requesttoken
		return axios.post(this.url('/recent'), station)
			.then(
				(response) => {
					return Promise.resolve(response.data)
				},
				(err) => {
					return Promise.reject(err)
				}
			)
			.catch((err) => {
				return Promise.reject(err)
			})
	}

	loadRecent() {
		axios.defaults.headers.requesttoken = requesttoken
		return axios.get(this.url('/recent'))
			.then(
				(response) => {
					return Promise.resolve(response.data)
				},
				(err) => {
					return Promise.reject(err)
				}
			)
			.catch((err) => {
				return Promise.reject(err)
			})
	}

}
