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

import { Player } from './../services/Player'
const player = new Player()

export default ({
	state: {
		isPlaying: false,
		isBuffering: false,
		isPausing: false,
		volume: 0.5,
		oldVolume: null,
		title: '',
	},
	getters: {
		getPlaying: state => {
			return state.isPlaying
		},
		getBuffering: state => {
			return state.isBuffering
		},
		getVolume: state => {
			return state.volume
		},
		getTitle: state => {
			return state.title
		},
	},
	mutations: {
		setPlaying(state, playerState) {
			state.isPlaying = playerState
		},
		setPausing(state, pauseState) {
			state.isPausing = pauseState
		},
		setBuffering(state, bufferingState) {
			state.isBuffering = bufferingState
		},
		setVolume(state, volume) {
			state.volume = volume
			localStorage.setItem('radio.volume', volume)
			player.setVolume(state.volume)
		},
		toggleMute(state) {
			if (parseFloat(state.volume)) {
				state.oldVolume = state.volume
				state.volume = 0
			} else {
				if (parseFloat(state.oldVolume)) {
					state.volume = state.oldVolume
				} else {
					state.oldVolume = 0
					state.volume = 1
				}
			}
			localStorage.setItem('radio.volume', state.volume)
			player.setVolume(state.volume)
		},
		togglePlay(state) {
			if (state.isPlaying) {
				state.isPlaying = false
				state.isPaused = true
				player.doPause()
			} else {
				state.isPlaying = true
				state.isPaused = false
				player.doResume()
			}
		},
		setTitle(state, title) {
			state.title = title
		},
	},
	actions: {
		setPlaying(context, playerState) {
			context.commit('setPlaying', playerState)
		},
		setBuffering(context, bufferingState) {
			context.commit('setBuffering', bufferingState)
		},
		setVolume(context, volume) {
			context.commit('setVolume', volume)
		},
		loadVolume(context) {
			const volume = localStorage.getItem('radio.volume')
			if (typeof volume === 'string') {
				context.commit('setVolume', volume)
			}
		},
		toggleMute(context) {
			context.commit('toggleMute')
		},
		togglePlay(context) {
			context.commit('togglePlay')
		},
		setTitle(context, title) {
			context.commit('setTitle', title)
		},
		playStation(context, station) {
			context.commit('setBuffering', true)
			context.commit('setTitle', station.name)
			context.commit('setPausing', false)
			player.doPlay(station.url_resolved)
		},

	},
})
