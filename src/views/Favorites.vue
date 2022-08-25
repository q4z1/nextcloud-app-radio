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
					<Breadcrumb title="Favorites" href="#/favorites" />
				</Breadcrumbs>
				<Actions>
					<ActionButton
						icon="icon-add"
						:close-after-click="true"
						@click="showModal()">
						Add station
					</ActionButton>
					<ActionButton
						icon="icon-download"
						:close-after-click="true"
						@click="doExport">
						Export favorites
					</ActionButton>
				</Actions>
			</div>
			<Player :pinned="true" />
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
			<Modal v-if="modal" @close="closeModal">
				<div class="modalContent">
					<h2 class="oc-dialog-title">
						{{ t('radio', 'Add custom station') }}
					</h2>
					<form @submit="addCustomStation">
						<label for="stationName">{{ t('radio', 'Name') }}:</label>
						<input
							id="stationName"
							v-model="station.name"
							type="text"
							required>
						<label for="streamUrl">{{ t('radio', 'Stream url') }}:</label>
						<input
							id="streamUrl"
							v-model="station.streamUrl"
							type="url"
							required>
						<label for="faviconUrl">{{ t('radio', 'Favicon url') }}:</label>
						<input
							id="faviconUrl"
							v-model="station.faviconUrl"
							type="url">
						<div class="formControls">
							<!-- FIXME: Use nextcloud-vue button component -->
							<button
								type="submit"
								class="icon-add-white primary button new-button">
								{{ t('radio', 'Add station') }}
							</button>
						</div>
					</form>
				</div>
			</Modal>
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
import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import Modal from '@nextcloud/vue/dist/Components/Modal'
import { getRequestToken } from '@nextcloud/auth'
import Navigation from './../components/Navigation'
import Table from './../components/Table'
import Sidebar from './../components/Sidebar'
import { mapGetters, mapActions } from 'vuex'
import { RadioBrowserApi } from './../services/RadioBrowserApi'
import Player from './../components/Player'
const apiClient = new RadioBrowserApi()

export default {
	name: 'Favorites',
	components: {
		Navigation,
		Content,
		AppContent,
		Table,
		EmptyContent,
		Breadcrumbs,
		Breadcrumb,
		Actions,
		ActionButton,
		Sidebar,
		Modal,
		Player,
	},
	data: () => ({
		pageLoading: false,
		blurHashes: require('../assets/blurHashes.json'),
		showSidebar: false,
		sidebarStation: {},
		tableData: [],
		modal: false,
		station: {
			faviconUrl: '',
		},
	}),
	computed: {
		...mapGetters([
			'favorites',
			'isFavorite',
		]),
		stations() {
			return this.favorites
		},
		emptyContentMessage() {
			return t('radio', 'No favorites yet')
		},
		emptyContentIcon() {
			return 'icon-star'
		},
		emptyContentDesc() {
			return t('radio', 'Stations you mark as favorite will show up here')
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

			this.pageLoading = false

		},

		toggleSidebar(station = null) {
			if (station) {
				this.showSidebar = true
				this.sidebarStation = station
			} else {
				this.showSidebar = false
			}
		},

		showModal() {
			this.modal = true
		},

		closeModal() {
			this.modal = false
		},

		uuidv4() {
		  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
		    const r = Math.random() * 16 | 0; const v = c === 'x' ? r : (r & 0x3 | 0x8)
		    return v.toString(16)
		  })
		},

		addCustomStation(e) {
			e.preventDefault()
			const station = {
				name: this.station.name,
				url_resolved: this.station.streamUrl,
				favicon: this.station.faviconUrl,
				stationuuid: this.uuidv4(),
				bitrate: '',
				country: '',
				language: '',
				homepage: '',
				codec: '',
				tags: '',
			}
			this.addFavorite(station)
			this.modal = false
		},

		doExport() {
			window.location
				= 'export?requesttoken='
					+ encodeURIComponent(getRequestToken())
		},

	},
}
</script>

<style lang="scss">

.controls {
	position: sticky;
	justify-content: flex-start;
	display: flex;
	top: 50px;
	margin-bottom: -2px;
	z-index: 60;
	background-color: var(--color-main-background-translucent);
}

.breadcrumb {
	flex-grow: 0 !important;
	width: auto !important;
}

.app-navigation-toggle {
	display: none;
}

.modalContent {
	max-width: 300px;
	width: 100%;
	padding: 20px;
	display: flex;
	flex-direction: column;

	h2 {
		// FIXME: No flex gap support in Chrome
		margin-bottom: 15px;
	}

	form {
		flex-grow: 1;
		display: grid;
		grid-template-columns: 100px 1fr;
		align-items: center;
		// FIXME: No flex gap support in Chrome

		.formControls {
			display: flex;
			justify-content: flex-end;
			margin-right: 40px;
			margin-top: 10px;
			grid-column: 1 / 3;

			.button {
				padding-left: 35px;
				padding-right: 15px;
				background-position: 10px center;
			}
		}
	}
}

@media only screen and (max-width: 1024px) {
	.app-navigation-toggle {
		display: block;
	}
	.controls {
		margin-left: 35px;
	}
}

</style>
