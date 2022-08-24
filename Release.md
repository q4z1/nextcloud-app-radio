## Publish release on Gitlab

Before releasing a new version to Gitlab, be sure to note all changes in the
[CHANGELOG.md](CHANGELOG.md)-file.
Commit, tag and push the changes:
```
git commit -am "test release v1.0.0.4"
git tag -a 1.0.0.4 -m ""
git push --atomic origin master 1.0.0.4
```
This will trigger the Gitlab-CI pipeline and publishes a release to the Gitlab
release page, including source, a prebuild tarball and the latest changelog.

## Nextcloud app store release

First login to the app store using an API token which can be generated
[here](https://apps.nextcloud.com/account/token). Run the following ``make``
command to publish a nightly release in the app store. It will fetch and use the
latest release from the Gitlab project.
```
krankerl login --appstore <TOKEN>
make publish-appstore-nightly
```
Or if you want to publish the latest release as a stable release, do:
```
make publish-appstore
```
