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
	<AppNavigation>
		<template id="app-radio-navigation" #list>
			<AppNavigationItem
				:to="{ name: 'TOP' }"
				icon="icon-category-dashboard"
				:title="t('radio', 'Top')" />
			<AppNavigationItem
				:to="{ name: 'RECENT' }"
				icon="icon-recent"
				:title="t('radio', 'Recent')" />
			<AppNavigationItem
				:to="{ name: 'NEW' }"
				icon="icon-category-monitoring"
				:title="t('radio', 'New')" />
			<AppNavigationItem
				:to="{ name: 'FAVORITES' }"
				icon="icon-favorite"
				:title="t('radio', 'Favorites')" />
			<AppNavigationItem
				:to="{ name: 'CATEGORIES' }"
				icon="icon-files-dark"
				:title="t('radio', 'Categories')" />
			<AppNavigationItem
				v-if="isSearch"
				:to="{ name: 'SEARCH' }"
				icon="icon-search"
				:title="t('radio', 'Search')">
				<AppNavigationCounter
					slot="counter"
					:highlighted="true">
					{{ stationData.length }}
				</AppNavigationCounter>
			</AppNavigationItem>
		</template>
		<template #footer>
			<Player
				:pinned="true" />
		</template>
	</AppNavigation>
</template>

<script>
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation'
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'
import AppNavigationCounter from '@nextcloud/vue/dist/Components/AppNavigationCounter'
import Player from './Player'

export default {
	name: 'Navigation',
	components: {
		AppNavigation,
		AppNavigationItem,
		AppNavigationCounter,
		Player,
	},
	props: {
		stationData: {
			type: Array,
			default() { return [] },
		},
	},
	computed: {
		isSearch() {
			return this.$route.name === 'SEARCH'
		},
	},
}
</script>

<style>
.app-navigation-entry__utils {
	margin-right: 10px;
}
</style>
