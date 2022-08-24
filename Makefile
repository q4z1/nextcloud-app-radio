# This file is licensed under the Affero General Public License version 3 or
# later. See the COPYING file.

all: dev-setup lint build-js-production test

# Dev env management
dev-setup: clean clean-dev npm-init

npm-init:
	npm ci

npm-update:
	npm update

# Building
build-js:
	npm run dev

build-js-production:
	npm run build

watch-js:
	npm run watch

# Testing
test:
	npm run test

test-watch:
	npm run test:watch

test-coverage:
	npm run test:coverage

# Linting
lint:
	npm run lint

lint-fix:
	npm run lint:fix

# Style linting
stylelint:
	npm run stylelint

stylelint-fix:
	npm run stylelint:fix

# Cleaning
clean:
	rm -f js/*

clean-dev:
	rm -rf node_modules

release:
	krankerl package

translations:
	if [ ! -d "utils/docker-ci" ]; then \
		git clone https://github.com/nextcloud/docker-ci.git utils/docker-ci; \
	fi
	php utils/docker-ci/translations/translationtool/translationtool.phar create-pot-files
	php utils/docker-ci/translations/translationtool/translationtool.phar convert-po-files

publish-appstore-nightly:
	$(eval ASSET_URL = $(shell curl -s https://git.project-insanity.org/api/v4/projects/onny%2Fnextcloud-app-radio/releases | jq -r '.[0].assets.links[0].url'))
	wget $(ASSET_URL) -O build/artifacts/radio.tar.gz
	krankerl publish --nightly $(ASSET_URL)

publish-appstore:
	$(eval ASSET_URL = $(shell curl -s https://git.project-insanity.org/api/v4/projects/onny%2Fnextcloud-app-radio/releases | jq -r '.[0].assets.links[0].url'))
	wget $(ASSET_URL) -O build/artifacts/radio.tar.gz
	krankerl publish $(ASSET_URL)
