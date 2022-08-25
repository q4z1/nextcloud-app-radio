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
	<div id="app-settings" class="controls">
		<div class="rplayer">
			<button class="player" :class="getPlaying ? 'pause' : 'play'" @click="togglePlay">
				<svg
					v-if="getPlaying"
					width="32"
					height="32"
					viewBox="0 0 24 24"
					fill="none"
					xmlns="http://www.w3.org/2000/svg">
					<path
						d="M10 9V15"
						stroke-width="1.5"
						stroke-linecap="round" />
					<path
						d="M14 9V15"
						stroke-width="1.5"
						stroke-linecap="round" />
					<rect
						x="4"
						y="4"
						width="16"
						height="16"
						rx="2.8"
						stroke-width="1.5" />
				</svg>
				<svg
					v-else
					:class="{ buffering: getBuffering }"
					width="32"
					height="32"
					viewBox="0 0 24 24"
					fill="none"
					xmlns="http://www.w3.org/2000/svg">
					<rect
						x="4"
						y="4"
						width="16"
						height="16"
						rx="2.8"
						stroke-width="1.5" />
					<path
						d="M14.6707 11.4226C15.1145 11.7174 15.1087 12.3586 14.6594 12.6456L11.1638 14.8789C10.661 15.2002 9.99465 14.8442 10 14.2572L10.0416 9.72962C10.0469 9.1426 10.7197 8.79833 11.2166 9.12835L14.6707 11.4226Z"
						stroke-width="1.5" />
				</svg>
			</button>
			<div class="volumeIcon" :class="getVolume == 0 ? 'volumeMute' : 'volumeFull'" @click="toggleMute" />
			<input class="volume"
				type="range"
				name="volume"
				min="0"
				max="1"
				step=".05"
				:value="getVolume"
				@input="setVolume($event.target.value)">
		</div>
		<div class="playerMetadata">
			{{ getTitle }}
		</div>
	</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
	computed: {
		...mapGetters([
			'getVolume',
			'getBuffering',
			'getPlaying',
			'getTitle',
		]),
	},
	methods: {
		...mapActions([
			'toggleMute',
			'setVolume',
			'togglePlay',
		]),
	},
}
</script>

<style>
#app-settings {
	display: grid;
	grid-auto-flow: row;
	justify-self: end;
	grid-gap: 20px;
}

.rplayer {
	display: grid;
	grid-auto-flow: column;
	grid-auto-columns: min-content;
	place-items: center;
	grid-gap: 5px;
}

.rplayer .volume {
	position: static;
	top: auto;
	left: auto;
	width: auto;
	height: auto;
}

.rplayer .volumeIcon {
	position: static;
	top: auto;
	left: auto;
}

button.player {
	width: auto;
	height: auto;
	margin:0;
	padding: 0;
	border: none !important;
}

button.player:focus {
	border: none !important;
}

.play svg{
	stroke: #0082c9;
}

.pause svg{
	stroke: #0082c9;
}

.buffering {
	stroke: #0082c9;
	animation: buffering 2s infinite linear;
}

@keyframes buffering {
	0% {
		stroke: #0082c9;
	}

	50% {
		stroke: var(--color-main-background);
	}

	100% {
		stroke: #0082c9;
	}
}

.playerMetadata {
	position: relative;
	left: 5px;
	top: -20px;
	width: 203px;
	height: 20px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.volumeIcon {
	width: 25px;
	height: 25px;
	position: relative;
	left: 85px;
	top: 20px;
	cursor: pointer;
}

.volumeFull {
	background-color: #0082c9;
	mask-repeat: no-repeat;
	mask-size: 100%;
	mask-image: var(--icon-sound-000);
}

.volumeMute {
	background-color: #0082c9;
	mask-repeat: no-repeat;
	mask-size: 100%;
	mask-image: var(--icon-sound-off-000);
}

.volume {
	width: 165px;
	display: inline-block;
	position: relative;
	left: 40px;
	top: -12px;
}
</style>
