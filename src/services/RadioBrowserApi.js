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

export class RadioBrowserApi {

	url() {
		const url = 'https://de1.api.radio-browser.info'
		return url
	}

	countClick(station) {

		delete axios.defaults.headers.requesttoken
		return axios.get(this.url() + '/json/url/' + station.stationuuid)
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

	queryList(listName, offset) {

		let order = 'clickcount'
		let reverse = true
		if (listName === 'NEW') {
			order = 'lastchangetime'
			reverse = false
		}

		delete axios.defaults.headers.requesttoken
		return axios.get(this.url() + '/json/stations', {
			params: {
				limit: 20,
				order,
				reverse,
				offset,
			},
		})
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

	searchStations(query, offset) {

		delete axios.defaults.headers.requesttoken
		return axios.get(this.url() + '/json/stations/byname/' + query, {
			params: {
				limit: 20,
				order: 'clickcount',
				offset,
			},
		})
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

	queryCategory(categoryName, offset = 0) {

		delete axios.defaults.headers.requesttoken
		return axios.get(this.url() + '/json/' + categoryName, {
			params: {
				limit: 20,
				offset,
			},
		})
			.then(
				(response) => {
					for (let i = 0; i < response.data.length; i++) {
						const obj = response.data[i]
						response.data[i].type = 'folder'
						response.data[i].path = '/categories/' + categoryName + '/' + obj.name
					}
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

	queryByCategory(categoryName, categoryQuery, offset = 0) {

		let categoryNameShort = ''
		if (categoryName === 'countries') {
			categoryNameShort = 'country'
		} else if (categoryName === 'tags') {
			categoryNameShort = 'tag'
		} else if (categoryName === 'states') {
			categoryNameShort = 'state'
		} else if (categoryName === 'languages') {
			categoryNameShort = 'language'
		}
		console.log(categoryNameShort, categoryQuery)
		delete axios.defaults.headers.requesttoken
		return axios.get(this.url() + '/json/stations/search?' + categoryNameShort
			+ '=' + categoryQuery + '&' + categoryNameShort + 'Exact=true', {
			params: {
				limit: 20,
				order: 'clickcount',
				offset,
			},
		})
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
