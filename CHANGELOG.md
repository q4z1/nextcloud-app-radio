## 1.1.0 - 2021-04

### Changed
- Simplify jsonSerialize keys to match API naming
  [#266](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/266) @onny
- Update npm modules
  [#269](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/269) @onny

## 1.0.3 - 2021-03

### Added
- Nextcloud 21 & PHP 8 support
  [#251](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/251) @onny
- Support add stations manually
  [#157](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/157) @onny
- Export favorite radio stations as playlist
  [#105](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/105) @onny

### Fixed
- Cleanup SCSS
  [#255](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/255) @onny
- Save state toggle volume
  [#250](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/250) @onny

### Changed
- Update npm modules
  [#254](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/254) @onny
- CI: Update krankerl
  [#257](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/257) @onny

## 1.0.2 - 2021-01
### Fixed
- Set user agent http header for remote API
  [#221](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/221) @onny
- Update favorite and recent categories without page reload
  [#242](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/242) @onny

### Changed
- Update npm modules
  [#235](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/235) @onny
- Update license year to 2021
  [#234](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/234) @onny
- Move menuState and volumeState into localStorage
  [#236](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/236) @onny
- Create seperate store modules for player, favorites and recent
  [#239](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/239) @onny
- Put player and api logic into seperate classes
  [#233](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/233) @onny

## 1.0.1 - 2020-12
### Added
- Support prepare a release with Krankerl
  [#200](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/200) @onny
- CI: Automatic releases based on version tags
  [#205](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/205) @onny
- CI: Besides source, provide prebuild tarball in Gitlab releases
  [#215](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/215) @onny
- Parse and supply changelog to Gitlab release
  [#216](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/216) @onny
- Add German translation
  [#190](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/190) @onny
- Publish releases to app store using make
  [#218](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/218) @onny
- CI: Add code signing to the release
  [#217](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/217) @onny
- CI: Add testing stage, enable app and code check
  [#212](https://git.project-insanity.org/onny/nextcloud-app-radio/-/issues/212) @onny

### Fixed
- Add AGPL headers
  [#206](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/206) @onny
- Support older browser CSS with autoprefix
  [#208](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/208) @onny
- Fix build and packaging with Gitlab CI
  [#118](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/118) @onny
- Update screenshot.png
  [#213](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/213) @onny
- More verbose app description for app store
  [#220](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/220) @onny
- Fix loading dashboard
  [#203](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/203) @onny
- Compile language files in make process
  [#226](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/226) @onny

## 1.0.0 - 2020-11
### Added
 - Complete new rewrite in VueJS
   Many bugs fixed and some features added.
   - Dashboard integration
   - Unified search support
   - Show recent played stations
   - Show sidebar with further infos
   - Improved performance and stability

## 0.6.6 - 2020-02
### Added
 - French translation
   [#92](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/92) @lftsy (Marc Leurent)
### Fixed
 - js/main.js: Fixed typo (Countires => Countries)
   [!2](https://git.project-insanity.org/onny/nextcloud-app-radio/merge_requests/2) @robin.vonbuelow (Robin von Bülow)
 - Support for Nextcloud 18
   [#98](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/98) @onny (Jonas Heinrich)

## 0.6.5 - 2019-05
### Added
- Smooth audio fade-in/out when changing stations
  [#80](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/80) @onny
- Implement category section
  [#35](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/35) @onny
### Fixed
- Prevent list from jumping back to top when adding station to favorites
  [#85](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/85) @onny
- Continous scrolling fails while searching
  [#47](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/47) @onny

## 0.6.4 – 2019-01
### Added
- Support for Nextcloud 15
  [#82](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/82) @onny
### Fixed
- Fix issue removing broken radio stations from fav
  [#76](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/76) @onny

## 0.6.3 – 2018-09-08
### Fixed
- Fix table size issues for mobile clients
  [#72](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/72) @onny
- Include custom User-Agent header
  [#75](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/75) @onny
- Fix loading all favorites
  [#58](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/58) @onny
- Remember favorite stations sort order
  [#64](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/64) @onny
- Split up javascript file
  [#67](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/67) @onny

## 0.6.2 – 2018-08-11
### Added
- Remember last menu state
  [#26](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/26) @onny
- Navigation by hash location
  [#63](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/63) @onny
- Add icon categories
  [#](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/b7e711955b90f388a5e340ab582461fd39df8969) @onny
- Add volume icon
  [#](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/07ce3e5aebd5e5b5bf91e3aae996441ae9268402) @onny
- Remember volume state
  [#66](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/66) @onny
- German translation
  [#38](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/38) @onny
- Add donation info to README
  [#70](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/70) @onny
- Toggle audio mute click on volume icon
  [#69](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/69) @onny

### Fixed
- Fix styling issue (overflow hidden) player area
  [#65](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/65) @onny
- Fix styling issue colum width on Chrome browsers
  [#37](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/37) @onny
- Don't scroll to top when clicking on station
  [#62](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/62) @onny
- Fix Nextcloud 14 compatibility
  [#57](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/57) @onny
  [#61](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/61) @onny
- Fix play/pause toggle favicon
  [#59](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/59) @onny
- Preload images
  [#68](https://git.project-insanity.org/onny/nextcloud-app-radio/issues/68) @onny

## 0.6.1 – 2018-08-11
### Changed
- Display station metadata
  [#53](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/9908231b7a24f21b1ab74d3aaa086eafa135e395) @onny

### Fixed
- Fix loading favorites
  [#54](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/d17b7720ced885d327ec5f74c066ef1862b49bd6) @onny

## 0.6.0 – 2017-08-11
### Added
- Display station metadata
  [#22](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/c62ee87b490de39ed27e43dec4dfff221bff40b1) @onny
- Add changelog file
  [#28](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/04b1bbf49c8d7eb95e9e5d08e9e3b4b7cdc7f4ee) @onny
- Continious scrolling
  [#13](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/c8e86558d0a1ceeea21f801f6e2391ab70046a4e) @onny
- Loading animation
  [#25](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/9624b4dc4c5770df93b548736c1be43b96d6dea5) @onny
- Display info messages, station not found / no favorites
  [#20](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/fba5aa6c8b913a63c4a726d4cbabf1c94331d9f0) @onny

### Fixed
- Fix missing background color for first td in table row
  [#32](https://git.project-insanity.org/onny/nextcloud-app-radio/commit/9e5b7961009ca7842f8a025de59cb3acaae2bea1) @onny

## 0.5.0 – 2017-08-06
### Added
- First release
