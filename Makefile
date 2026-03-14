# SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
# SPDX-License-Identifier: AGPL-3.0-or-later

APP_NAME := fulltextsearch_opensearch

.PHONY: all
all: vendor

.PHONY: vendor
vendor: composer.json
	composer install --no-dev --prefer-dist
	@echo "Vendor libraries installed."

.PHONY: scoper
scoper: vendor
	# Install php-scoper via composer-bin-plugin
	composer bin php-scoper require --dev humbug/php-scoper:^0.18.19
	# Run php-scoper (outputs to lib/Vendor)
	vendor-bin/php-scoper/vendor/bin/php-scoper add-prefix \
		--config=scoper.inc.php \
		--output-dir=lib/Vendor \
		--force
	@echo "Vendor libraries scoped to OCA\\FullTextSearch_OpenSearch\\Vendor"

.PHONY: clean
clean:
	rm -rf vendor/ lib/Vendor/ vendor-bin/

.PHONY: lint
lint:
	find lib/ -name "*.php" -exec php -l {} \;

.PHONY: cs
cs:
	php-cs-fixer fix --dry-run --diff
