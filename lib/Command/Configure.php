<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Command;

use OC\Core\Command\Base;
use OCA\FullTextSearch_OpenSearch\Service\ConfigService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Configure extends Base {
	public function __construct(
		private ConfigService $configService,
	) {
		parent::__construct();
	}

	protected function configure(): void {
		parent::configure();
		$this->setName('fulltextsearch_opensearch:configure')
			 ->addArgument('json', InputArgument::OPTIONAL, 'set config as JSON')
			 ->setDescription('Configure the OpenSearch platform');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$json = $input->getArgument('json');
		if ($json !== null) {
			$data = json_decode($json, true);
			if (is_array($data)) {
				$this->configService->setConfig($data);
			}
		}

		$output->writeln(json_encode($this->configService->getConfig(), JSON_PRETTY_PRINT));
		return self::SUCCESS;
	}
}
