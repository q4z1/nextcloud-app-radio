# Nextcloud Radio app
This experimental app uses the radio-browser.info api and offers radio stations right in your Nextcloud!

[![](https://git.project-insanity.org/onny/nextcloud-app-radio/raw/master/screenshot.png)](https://git.project-insanity.org/onny/nextcloud-app-radio/raw/master/screenshot.png)

## Features

- [x] Browse hundreds of radio stations world wide and play them directly
- [x] Explore new stations in the category section
- [x] Smooth playback with audio transitions
- [x] Save stations to your favorites list
- [x] Export favorites as playlist
- [x] Add your own radio streams

## Maintainers
* [Jonas Heinrich](https://github.com/onny)

## Installation

**From the appstore**

The most recent and stable version of the app can be found in the [official appstore](https://apps.nextcloud.com/apps/radio). For ArchLinux, there is an [AUR package](https://aur.archlinux.org/packages/nextcloud-app-radio-git/) available.

**From source**

Clone the development repository with:
```
git clone https://git.project-insanity.org/onny/nextcloud-app-radio.git radio
```
Then run following commands to compile the project:
```
cd radio
make dev-setup
make build-js
```
Mount or move the ``radio`` folder into your Nextcloud ``apps/`` directory. Go to the apps manager tab in your Nextcloud web interface, and enable the Radio app.

## Testing

Can be easily tested using Docker:
```
docker build -t nextcloud https://git.project-insanity.org/onny/docker-nextcloud.git
docker run -v /tmp/nextcloud-app-radio:/opt/nextcloud/apps/radio -d --name nextcloud-app-radio -p 80:80 nextcloud
```
First part of -v is the path to the cloned and compiled or downloaded Nextcloud Radio app. Debug running container it with:
```
docker exec -i -t 665b4a1e17b6 /bin/bash
```
Where -t specifies the container id. If you further need to access the sqlite-database, logs or files inside the data folder of Nextcloud, that you also have to share this folder with the host:
```
docker run -v /tmp/dockerdata:/data/data -v /tmp/nextcloud-app-radio:/opt/nextcloud/apps/radio -d --name nextcloud -p 80:80 rootlogin/nextcloud
```

## Development notes
### General
While editing the code, you could run following helper script to automatically
compile the project:
```
echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p # ref: https://github.com/gatsbyjs/gatsby/issues/11406
make watch-js
```

### Translations
Manually generate translations. The following commands will require the
dependency packages ``gettext`` and ``php``.
```
cd nextcloud-app-radio
git clone https://github.com/nextcloud/docker-ci.git utils/docker-ci
make translations
```
Use the source file ``translationfiles/template/radio.pot`` to create
translations. For example, contribute translations via
[Transifex](https://www.transifex.com/project-insanityorg/radio-2/dashboard/).

Put the translated language file into the corresponding template folder. For
example the German language file should be placed at
``translationfiles/de/radio.po``. Run ``make translations`` again.

### Prepare a release
Consoult [Release.md](Release.md) on how to prepare a release for Gitlab and the app store.

## Contribute

### Reporting bugs

You can report bugs in the public gitlab repository [here](https://git.project-insanity.org/onny/nextcloud-app-radio/issues) and for discussion you can find a section for the app in the offical Nextcloud forums [here](https://help.nextcloud.com/c/apps/radio).

### Adding translations
For now only German translations are provided, so please submit your translations if possible :) It's really easy, just `git clone` this repo and copy the translation files in `l10n` according to your locale. Merge requests go to [this radio repository](https://git.project-insanity.org/onny/nextcloud-app-radio).

### Adding radio stations
This app uses a public and open database of radio stations as its backend, so any station you add in [radio-browser.info](http://www.radio-browser.info/) (no account required), will be also available in this app. Feel free to contribute :)

### Donation
If you like this app and want to support my work, you can donate to this Bitcoin address:
```
19mpmuNczGDgdxaBLBn3REEpQLPPcJHZB6
```

## Credits
* [radio-browser.info](http://www.radio-browser.info/) database api as backend for this app
* Python example code to query stream metadata, took from [here](https://anton.logvinenko.name/en/blog/how-to-get-title-from-audio-stream-with-python.html).
