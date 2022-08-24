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
	<table>
		<thead>
			<tr>
				<th class="iconColumn" />
				<th class="nameColumn">
					{{ t('radio', 'Name') }}
				</th>
				<th class="actionColumn" />
			</tr>
		</thead>
		<tbody>
			<template v-if="!isFolder">
				<tr
					v-for="(station, idx) in stationData"
					:key="idx"
					:class="{ selected: idx === activeItem}">
					<td @click="doPlay(idx, station)">
						<blur-hash-image
							class="stationIcon"
							width="32"
							height="32"
							:hash="station.blurHash || 'L1TSUA?bj[?b~qfQfQj[ayfQfQfQ'"
							:src="station.favicon" />
						<span :class="{ 'icon-starred': isFavorite(station) }" />
					</td>
					<td class="nameColumn" @click="doPlay(idx, station)">
						<span class="innernametext">
							{{ station.name }}
						</span>
					</td>
					<td class="actionColumn">
						<Actions>
							<ActionButton
								v-if="!isFavorite(station)"
								icon="icon-star"
								:close-after-click="true"
								@click="doFavor(idx, station)">
								{{ t('radio', 'Add to favorites') }}
							</ActionButton>
							<ActionButton
								v-if="isFavorite(station)"
								icon="icon-star"
								:close-after-click="true"
								@click="doFavor(idx, station)">
								{{ t('radio', 'Remove from favorites') }}
							</ActionButton>
							<ActionButton
								icon="icon-info"
								:close-after-click="true"
								@click="toggleSidebar(station)">
								{{ t('radio', 'Details') }}
							</ActionButton>
						</Actions>
					</td>
				</tr>
			</template>
			<template v-if="isFolder">
				<tr
					v-for="(station, idx) in stationData"
					:key="idx"
					@click="changeRoute(station.path)">
					<td>
						<span class="icon-folder" />
					</td>
					<td class="nameColumn">
						<span class="innernametext">
							{{ station.name }}
						</span>
					</td>
					<td class="actionColumn" />
				</tr>
			</template>
		</tbody>
	</table>
</template>

<script>
import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import Vuex from 'vuex'

export default {
	name: 'Table',
	components: {
		Actions,
		ActionButton,
	},
	props: {
		favorites: {
			type: Array,
			default() { return [] },
		},
		stationData: {
			type: Array,
			default() { return [] },
		},
	},
	data: () => ({
		activeItem: null,
	}),
	computed: {
		...Vuex.mapGetters([
			'isFavorite',
		]),
		isFolder() {
			if (this.stationData[0]) {
				if (this.stationData[0].type === 'folder') {
					return true
				}
			}
			return false
		},
	},
	methods: {
		doPlay(idx, station) {
			this.activeItem = idx
			this.$emit('doPlay', station)
		},
		doFavor(idx, station) {
			this.$emit('doFavor', station)
		},
		toggleSidebar(station) {
			this.$emit('toggleSidebar', station)
		},
		changeRoute(path) {
			this.$router.push({ path })
		},
	},
}
</script>

<style lang="scss">

/* Workaround wrong positioning
   actions popover menu
	  https://github.com/nextcloud/nextcloud-vue/issues/1384 */
body {
	min-height: 100%;
	height: auto;
}

table {
	width: 100%;
	min-width: 250px;
	table-layout:fixed;
	position: relative;

	thead {
		background-color: var(--color-main-background-translucent);
		z-index: 60;
		position: sticky;
		top: 93px;

		th {
			border-bottom: 1px solid var(--color-border);
			padding: 15px;
			height: 50px;

			a {
				color: var(--color-text-maxcontrast);
			}

			&.iconColumn {
				padding: 0px;
				width: 72px;
			}

			&.nameColumn {
				width: 100%;
			}

			&.actionColumn {
				width: 72px;
			}
		}

	}

	tbody {

		td {
			padding: 0 15px;
			font-style: normal;
			background-position: 8px center;
			background-repeat: no-repeat;
			border-bottom: 1px solid var(--color-border);
			cursor: pointer;

			span.icon-folder {
				display: block;
				background-size: cover;
				width: 30px;
				height: 30px;
			}
		}

		tr {
			height: 51px;
			background-color: var(--color-background-light);
			transition: opacity 500ms ease 0s;

			&.selected {
				background-color: var(--color-primary-light);
			}

			&:hover, &:focus, &.mouseOver td {
				background-color: var(--color-background-hover);
			}

			td {

				&:first-child {
					padding-left: 40px;
					width: 32px;
					padding-right: 0px;
				}

				&.nameColumn {
					white-space: nowrap;
					overflow: hidden;
					text-overflow: ellipsis;
					padding-right: 0px;
				}

				&.nameColumn .innernametext {
					color: var(--color-main-text);
					position: relative;
					vertical-align: top;
					user-select: none;
					cursor: pointer;
				}

			}

		}

		tr td * {
			cursor: pointer;
		}

		.icon-starred {
			background-image: var(--icon-star-dark-fc0);
			background-size: 16px 16px;
			background-repeat: no-repeat;
			background-position: center;
			min-width: 16px;
			min-height: 16px;
			right: -7px;
			top: -38px;
			margin-bottom: -38px;
			float: right;
			position: relative;
			pointer-events: none;
		}

	}

}

</style>
