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

import { RadioApi } from './../services/RadioApi'
const apiClient = new RadioApi()

export default {
	state: {
		recent: [],
	},
	getters: {
		recent: state => {
			return state.recent
		},
	},
	mutations: {

		addRecent(state, station) {

			// Remove station from list if already exists
			const existingIndex = state.recent.findIndex(_station => _station.stationuuid === station.stationuuid)
			if (existingIndex !== -1) {
				state.recent.splice(existingIndex, 1)
			}
			// Append station at the begging of the list
			state.recent.unshift(station)

		},

		setRecent(state, stations) {
			state.recent = stations
		},

	},
	actions: {
		async loadRecent({ commit }) {
			const stations = await apiClient.loadRecent()
			commit('setRecent', stations)
		},
		addRecent({ commit }, station) {
			apiClient.addRecent(station)
				.then((station) => {
					commit('addRecent', station)
				})
		},
		removeRecent({ commit }, station) {
			apiClient.removeRecent(station)
				.then((station) => {
					commit('removeRecent', station)
				})
		},
	},
}
