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
				</Breadcrumbs>
			</div>
			<Table
				v-show="!pageLoading && stations.length > 0"
				v-resize="onResize"
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

import { RadioBrowserApi } from './../services/RadioBrowserApi'
const apiClient = new RadioBrowserApi()

export default {
	name: 'Main',
	components: {
		Navigation,
		Content,
		AppContent,
		Table,
		EmptyContent,
		Sidebar,
		Breadcrumbs,
		Breadcrumb,
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
			'recent',
			'isFavorite',
		]),
		stations() {
			if (this.$route.name === 'RECENT') {
				return this.recent
			}
			return this.tableData
		},
		emptyContentMessage() {
			 if (this.$route.name === 'RECENT') {
				return t('radio', 'No recent stations yet')
			} else if (this.$route.name === 'SEARCH') {
				return t('radio', 'No search results')
			}
			return t('radio', 'No stations here')
		},
		emptyContentIcon() {
			if (this.$route.name === 'RECENT') {
				return 'icon-recent'
			} else if (this.$route.name === 'SEARCH') {
				return 'icon-search'
			}
			return 'icon-radio'
		},
		emptyContentDesc() {
			if (this.$route.name === 'RECENT') {
				return t('radio', 'Stations you recently played will show up here')
			} else if (this.$route.name === 'SEARCH') {
				return t('radio', 'No stations were found matching your search term')
			}
			return t('radio', 'No stations here')
		},
	},
	watch: {
		$route: 'onRoute',
	},
	mounted() {
		this.onRoute()
		this.scroll()
	},
	methods: {
		...mapActions([
			'addFavorite',
			'removeFavorite',
			'addRecent',
			'playStation',
		]),

		onResize({ width, height }) {
			const contentHeight
				= document.getElementById('app-content-vue').scrollHeight
			const tableHeight = height
			if (tableHeight < contentHeight) {
				// this.preFill()
				console.log('prefill')
			}
		},

		preFill() {
			const route = this.$route
			this.loadStations(route.name)
		},

		async onRoute() {
			this.tableData = []
			this.pageLoading = true
			const route = this.$route
			this.loadStations(route.name)
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

		async loadStations(menuState = 'TOP') {

			// Skip loading more stations on certain sites
			if (this.tableData.length > 0
				&& (this.$route.name === 'RECENT')) {
				return true
			}

			if (menuState === 'RECENT') {
				this.pageLoading = false
			} else if (menuState === 'SEARCH') {
				const stations
					= await apiClient.searchStations(this.$route.params.query,
						this.tableData.length)
				this.tableData = this.tableData.concat(stations)
				this.pageLoading = false
			} else if (menuState === 'NEW' || menuState === 'TOP') {
				const stations
					= await apiClient.queryList(menuState, this.tableData.length)
				this.tableData = this.tableData.concat(stations)
				this.pageLoading = false
			}

		},

		/**
		 * On scroll event, load more stations if bottom reached
		 */
		scroll() {
			window.onscroll = () => {
				if ((window.innerHeight + window.scrollY)
					>= document.body.scrollHeight) {
					const route = this.$route
					this.loadStations(route.name)
		    }
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
