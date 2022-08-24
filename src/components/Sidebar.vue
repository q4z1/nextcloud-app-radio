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
	<AppSidebar
		v-show="showSidebar"
		:title="sidebarStation.name"
		:subtitle="stationTags"
		:background="sidebarStation.favicon"
		class="has-preview"
		@close="toggleSidebar">
		<div class="configBox">
			<span class="icon icon-link" />
			<span class="title">
				{{ t('radio', 'Stream URL') }}
			</span>
			<div class="content">
				<input type="text" :value="sidebarStation.url_resolved" disabled="disabled">
				<Actions>
					<ActionButton icon="icon-clippy" @click="copyLink">
						{{ t('radio', 'Copy link to clipboard') }}
					</ActionButton>
				</Actions>
			</div>
		</div>
		<div class="configBox">
			<span class="icon icon-external" />
			<span class="title">
				{{ t('radio', 'Homepage') }}
			</span>
			<div class="content">
				<span>
					<a
						:href="sidebarStation.homepage"
						target="new">
						{{ sidebarStation.homepage }}
					</a>
				</span>
			</div>
		</div>
		<div class="configBox">
			<span class="icon icon-details" />
			<span class="title">
				{{ t('radio', 'Country & Language') }}
			</span>
			<div class="content">
				<span>
					{{ sidebarStation.country }}, {{ sidebarStation.language }}
				</span>
			</div>
		</div>
		<div class="configBox">
			<span class="icon icon-details" />
			<span class="title">
				{{ t('radio', 'Codec & Bitrate') }}
			</span>
			<div class="content">
				<span>
					{{ sidebarStation.codec }}, {{ sidebarStation.bitrate }}
				</span>
			</div>
		</div>
	</AppSidebar>
</template>

<script>
import AppSidebar from '@nextcloud/vue/dist/Components/AppSidebar'
import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import { showError, showSuccess } from '@nextcloud/dialogs'

export default {
	name: 'Sidebar',
	components: {
		AppSidebar,
		Actions,
		ActionButton,
	},
	props: {
		showSidebar: {
			type: Boolean,
			default() { return false },
		},
		sidebarStation: {
			type: Object,
			default() {
				return {}
			},
		},
	},
	computed: {
		stationTags() {
			if (this.sidebarStation.tags) {
				return this.sidebarStation.tags.replaceAll(',', ', ')
			}
			return ''
		},
	},
	methods: {
		toggleSidebar(station) {
			this.$emit('toggleSidebar')
		},
		copyLink() {
			this.$copyText(this.sidebarStation.url_resolved).then(
				function() {
					showSuccess(t('radio', 'Link copied to clipboard'))
				},
				function() {
					showError(t('radio', 'Error while copying link to clipboard'))
				}
			)
		},
	},
}
</script>

<style lang="scss" scoped>

.app-sidebar {
	&.has-preview::v-deep {
		.app-sidebar-header__figure {
			background-size: cover;
			height: 200px;
		}
	}
}

.configBox {
	padding: 0 15px;
	margin-bottom: 20px;

	&.title {
		font-size: 1.2em;
		display: block;
		margin-bottom: 15px;
	}

	&.icon {
		float: left;
		margin: 4px 7px 0px 0px;
	}

	&.content {
		display: flex;
		margin-left: 25px;

		input {
			flex-grow: 1;
		}

		button {
			margin-top: -3px;
		}
	}

}

</style>
