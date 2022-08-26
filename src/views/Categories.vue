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
	<Content app-name="radio">
		<Navigation
			:station-data="stations" />
		<AppContent>
			<div class="controls">
				<Breadcrumbs>
					<Breadcrumb title="Home" href="#/" />
					<Breadcrumb title="Categories" href="#/categories" />
				</Breadcrumbs>
			</div>
			<Player class="dplayer" :pinned="true" />
			<Table
				v-show="!pageLoading && stations.length > 0"
				:station-data="stations"
				:favorites="favorites"
				@doPlay="doPlay"
				@doFavor="doFavor"
				@toggleSidebar="toggleSidebar" />
			<EmptyContent
				v-if="pageLoading"
				icon="icon-loading" />
			<EmptyContent
				v-if="stations.length === 0 && !pageLoading"
				:icon="emptyContentIcon">
				{{ emptyContentMessage }}
				<template #desc>
					{{ emptyContentDesc }}
				</template>
			</EmptyContent>
		</AppContent>
		<Sidebar
			:show-sidebar="showSidebar"
			:sidebar-station="sidebarStation"
			@toggleSidebar="toggleSidebar" />
	</Content>
</template>

<script>
import Content from '@nextcloud/vue/dist/Components/Content'
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import EmptyContent from '@nextcloud/vue/dist/Components/EmptyContent'
import Breadcrumbs from '@nextcloud/vue/dist/Components/Breadcrumbs'
import Breadcrumb from '@nextcloud/vue/dist/Components/Breadcrumb'
import Navigation from './../components/Navigation'
import Table from './../components/Table'
import Sidebar from './../components/Sidebar'
import { mapGetters, mapActions } from 'vuex'
import Player from './../components/Player'
import { RadioBrowserApi } from './../services/RadioBrowserApi'
const apiClient = new RadioBrowserApi()

export default {
	name: 'Categories',
	components: {
		Navigation,
		Content,
		AppContent,
		EmptyContent,
		Table,
		Sidebar,
		Breadcrumbs,
		Breadcrumb,
		Player,
	},
	data: () => ({
		pageLoading: false,
		blurHashes: require('../assets/blurHashes.json'),
		showSidebar: false,
		sidebarStation: {},
		tableData: [],
	}),
	computed: {
		...mapGetters([
			'favorites',
			'isFavorite',
		]),
		stations() {
			return this.tableData
		},
		emptyContentMessage() {
			return t('radio', 'No stations here')
		},
		emptyContentIcon() {
			return 'icon-radio'
		},
		emptyContentDesc() {
			return t('radio', 'No stations here')
		},
	},
	watch: {
		$route: 'onRoute',
	},
	mounted() {
		this.onRoute()
	},
	methods: {
		...mapActions([
			'addFavorite',
			'removeFavorite',
			'addRecent',
			'playStation',
		]),

		async onRoute() {
			this.tableData = []
			this.pageLoading = true
			this.loadStations()
		},

		/**
			 * Favor a new station by sending the information to the server
			 * @param {Object} station Station object
			 */
		async doFavor(station) {
			if (this.isFavorite(station)) {
				this.removeFavorite(station)
			} else {
				this.addFavorite(station)
			}
		},

		/**
			 * Start playing a radio station and counting the playback
			 * @param {Object} station Station object
			 */
		doPlay(station) {

			/* Start streaming station */
			this.playStation(station)

			/* Count click */
			apiClient.countClick(station)

			/* Put into recent stations */
			this.addRecent(station)

		},

		async loadStations() {

			// Skip loading more stations on certain sites
			if (this.tableData.length > 0) {
				return true
			}

			if (this.$route.path === '/categories') {
				this.tableData = [
					{
						name: t('radio', 'Countries'),
						type: 'folder',
						path: '/categories/countries',
					},
					{
						name: t('radio', 'States'),
						type: 'folder',
						path: '/categories/states',
					},
					{
						name: t('radio', 'Languages'),
						type: 'folder',
						path: '/categories/languages',
					},
					{
						name: t('radio', 'Tags'),
						type: 'folder',
						path: '/categories/tags',
					},
				]
				this.pageLoading = false
				return true
			} else if (this.$route.params.category && !this.$route.params.query) {
				const stations
					= await apiClient.queryCategory(this.$route.params.category)
				this.tableData = this.tableData.concat(stations)
				this.pageLoading = false
			} else if (this.$route.params.category && this.$route.params.query) {
				const stations
					= await apiClient.queryByCategory(this.$route.params.category,
						this.$route.params.query)
				this.tableData = this.tableData.concat(stations)
				this.pageLoading = false
			}

		},

		toggleSidebar(station = null) {
			if (station) {
				this.showSidebar = true
				this.sidebarStation = station
			} else {
				this.showSidebar = false
			}
		},
	},
}
</script>

<style>

@media only screen and (min-width: 1024px) {
	.app-navigation-toggle {
		display: none;
	}
}

</style>
