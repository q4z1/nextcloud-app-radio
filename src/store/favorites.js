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
		favorites: [],
	},
	getters: {
		favorites: state => {
			return state.favorites
		},
		isFavorite: state => (station) => {
			if (station !== undefined) {
				const index = state.favorites.findIndex(_station => _station.stationuuid === station.stationuuid)
				if (index !== -1) {
					return true
				}
			}
			return false
		},
	},
	mutations: {
		addFavorite(state, station) {
			state.favorites.push(station)
		},
		removeFavorite(state, station) {
			const existingIndex = state.favorites.findIndex(_station => _station.id === station.id)
			if (existingIndex !== -1) {
				state.favorites.splice(existingIndex, 1)
			}
		},
		setFavorites(state, stations) {
			state.favorites = stations
		},
	},
	actions: {
		async loadFavorites({ commit }) {
			const stations = await apiClient.loadFavorites()
			commit('setFavorites', stations)
		},
		addFavorite({ commit }, station) {
			apiClient.addFavorite(station)
				.then((station) => {
					commit('addFavorite', station)
				})
		},
		removeFavorite({ commit }, station) {
			apiClient.removeFavorite(station)
				.then((station) => {
					commit('removeFavorite', station)
				})
		},
	},
}
