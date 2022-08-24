<!--
  - @copyright Copyright (c) 2021 Jonas Heinrich
  -
  - @author Jonas Heinrich <onny@project-insanity.org>
  -
  - @license GNU AGPL version 3 or any later version
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program. If not, see <http://www.gnu.org/licenses/>.
  -
  -->

<template>
	<DashboardWidget :items="items"
		:show-more-text="t('radio', 'stations')"
		:show-more-url="showMoreUrl"
		:loading="state === 'loading'">
		<template #empty-content>
			<EmptyContent
				v-if="emptyContentMessage"
				:icon="emptyContentIcon">
				<template #desc>
					{{ emptyContentMessage }}
				</template>
			</EmptyContent>
		</template>
	</DashboardWidget>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { showError } from '@nextcloud/dialogs'
import { DashboardWidget } from '@nextcloud/vue-dashboard'
import EmptyContent from '@nextcloud/vue/dist/Components/EmptyContent'

const requesttoken = axios.defaults.headers.requesttoken

export default {
	name: 'Dashboard',

	components: {
		DashboardWidget,
		EmptyContent,
	},

	data() {
		return {
			notifications: [],
			showMoreUrl: generateUrl('/apps/radio/#/favorites'),
			state: 'loading',
			darkThemeColor: OCA.Accessibility.theme === 'dark' ? 'ffffff' : '000000',
		}
	},

	computed: {
		items() {
			return this.notifications.map((n) => {
				return {
					id: n.id,
					targetUrl: generateUrl('/apps/radio/#/favorites'),
					avatarUrl: n.favicon,
					mainText: n.name,
					subText: n.tags.replaceAll(',', ', '),
				}
			})
		},
		emptyContentMessage() {
			if (this.state === 'error') {
				return t('radio', 'Error fetching favorite stations')
			} else if (this.state === 'ok') {
				return t('radio', 'No favorites added yet!')
			}
			return ''
		},
		emptyContentIcon() {
			if (this.state === 'error') {
				return 'icon-close'
			} else if (this.state === 'ok') {
				return 'icon-checkmark'
			}
			return 'icon-checkmark'
		},
	},

	beforeMount() {
		this.fetchNotifications()
	},

	methods: {
		fetchNotifications() {
			const req = {}
			axios.defaults.headers.requesttoken = requesttoken
			axios.get(generateUrl('/apps/radio/api/favorites'), req).then((response) => {
				this.processNotifications(response.data)
				this.state = 'ok'
			}).catch((error) => {
				clearInterval(this.loop)
				if (error.response && error.response.status === 401) {
					showError(t('radio', 'Failed to fetch favorite radio stations'))
					this.state = 'error'
				} else {
					// there was an error in notif processing
					console.debug(error)
				}
			})
		},
		processNotifications(newNotifications) {
			console.log(newNotifications)
			this.notifications = newNotifications
		},
	},
}
</script>
