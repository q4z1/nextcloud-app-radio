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
import router from './router'
import store from './store/main'

import { translate, translatePlural } from '@nextcloud/l10n'

import App from './App'

import VueBlurHash from 'vue-blurhash'
import VueClipboard from 'vue-clipboard2'
import VueResizeObserver from 'vue-resize-observer'

import 'vue-blurhash/dist/vue-blurhash.css'

Vue.prototype.t = translate
Vue.prototype.n = translatePlural
Vue.prototype.OC = window.OC
Vue.prototype.OCA = window.OCA
Vue.prototype.$version = '1.1.0'

Vue.use(VueClipboard)
Vue.use(VueBlurHash)
Vue.use(VueResizeObserver)

export default new Vue({
	el: '#content',
	store,
	router,
	render: h => h(App),
})
