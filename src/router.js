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
import Router from 'vue-router'
import { generateUrl } from '@nextcloud/router'

import Main from './views/Main'
import Categories from './views/Categories'
import Favorites from './views/Favorites'
import store from './store/main.js'

Vue.use(Router)

const router = new Router({
	base: generateUrl('/apps/radio/'),
	linkActiveClass: 'active',
	routes: [
		{
			path: '/top',
			component: Main,
			name: 'TOP',
		},
		{
			path: '/recent',
			component: Main,
			name: 'RECENT',
		},
		{
			path: '/new',
			component: Main,
			name: 'NEW',
		},
		{
			path: '/favorites',
			component: Favorites,
			name: 'FAVORITES',
		},
		{
			path: '/categories/:category?/:query?',
			component: Categories,
			name: 'CATEGORIES',
		},
		{
			path: '/search/:query',
			component: Main,
			name: 'SEARCH',
			props: {},
		},
	],
})

router.beforeEach((to, from, next) => {

	if (to.name) {
		store.dispatch('setMenuState', to.name)
		next()
	} else {
		next({ name: store.state.menu })
	}

})

export default router
