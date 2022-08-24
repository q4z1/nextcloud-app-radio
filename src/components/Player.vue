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
	<div id="app-settings">
		<div
			class="wrap"
			:class="{ buffering: getBuffering }">
			<button
				class="player"
				:class="getPlaying ? 'pause' : 'play'"
				@click="togglePlay" />
		</div>
		<div
			class="volumeIcon"
			:class="getVolume == 0 ? 'volumeMute' : 'volumeFull'"
			@click="toggleMute" />
		<input
			class="volume"
			type="range"
			name="volume"
			min="0"
			max="1"
			step=".05"
			:value="getVolume"
			@input="setVolume($event.target.value)">
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

	.wrap {
		background: var(--color-main-background);
		border: 2px solid #0082c9;
		float: left;
		border-radius: 2px;
		margin: 10px;
	}

	.player{
		height:50px;
		width: 50px;
		background-color: #0082c9;
		mask-repeat: no-repeat;
		mask-size: 55%;
		mask-position: 70% 50%;
	}

	.play{
		mask-image: var(--icon-play-000);
		transition: mask-image 0.4s ease-in-out;
	}

	.pause{
		mask-image: var(--icon-pause-000);
		mask-position: 58% 50%;
		transition: mask-image 0.4s ease-in-out;
	}

	.buffering {
		border: 3px solid #0082c9;
		animation: buffering 2s infinite linear;
	}

	@keyframes buffering {
		0% {
			border-color: #0082c9;
		}
		50% {
			border-color: var(--color-main-background);
		}
		100% {
			border-color: #0082c9;
		}
	}

	.playerMetadata{
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

	.volume{
		width: 165px;
		display: inline-block;
		position: relative;
		left: 40px;
		top: -12px;
	}

</style>
