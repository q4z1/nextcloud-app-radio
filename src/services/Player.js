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

import { Howl, Howler } from 'howler'
import { showError } from '@nextcloud/dialogs'
import store from './../store/main.js'

let audioPlayer = null

export class Player {

	doPlay(src) {

		if (audioPlayer !== null) {
			audioPlayer.fade(store.state.player.volume, 0, 500)
			Howler.unload()
		}

		audioPlayer = new Howl({
			src,
			html5: true,
			volume: store.state.player.volume,
			onplay() {
				store.dispatch('setPlaying', true)
				store.dispatch('setBuffering', false)
			},
			onpause() {
				store.dispatch('setPlaying', false)
				store.dispatch('setBuffering', false)
			},
			onend() {
				showError(t('radio', 'Lost connection to podcast station, retrying ...'))
				store.dispatch('setPlaying', false)
				store.dispatch('setBuffering', true)
			},
		})
		audioPlayer.unload()
		audioPlayer.play()
		audioPlayer.fade(0, store.state.player.volume, 500)

	}

	doPause() {
		if (audioPlayer !== null) {
			audioPlayer.pause()
		}
	}

	doResume() {
		if (audioPlayer !== null) {
			audioPlayer.play()
		}
	}

	setVolume(volume) {
		if (audioPlayer !== null) {
			audioPlayer.volume(volume)
		}
	}

}
