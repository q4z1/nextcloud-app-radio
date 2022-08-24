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

import Vue from 'vue'
import Vuex from 'vuex'
import player from './player'
import favorites from './favorites'
import recent from './recent'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		player,
		favorites,
		recent,
	},
	state: {
		menu: localStorage.getItem('radio.menu') || 'TOP',
	},
	mutations: {
		setMenuState(state, menuState) {
			localStorage.setItem('radio.menu', menuState)
			state.menu = menuState
		},
	},
	actions: {
		setMenuState(context, menuState) {
			context.commit('setMenuState', menuState)
		},
	},
})
