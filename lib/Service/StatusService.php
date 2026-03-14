<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;
use Psr\Log\LoggerInterface;

class StatusService {
	public function __construct(
		private IDBConnection $db,
		private ClientService $clientService,
		private ConfigService $configService,
		private LoggerInterface $logger,
	) {
	}

	public function getStatus(): array {
		return [
			'runner' => $this->getRunnerStatus(),
			'index' => $this->getOpenSearchIndexStatus(),
			'queue' => $this->getQueueStatus(),
			'cluster' => $this->getClusterHealth(),
		];
	}

	private function getRunnerStatus(): array {
		try {
			$qb = $this->db->getQueryBuilder();
			$qb->select('*')
			   ->from('fulltextsearch_ticks')
			   ->where($qb->expr()->eq('status', $qb->createNamedParameter('run')))
			   ->orderBy('id', 'DESC')
			   ->setMaxResults(1);

			$result = $qb->executeQuery();
			$row = $result->fetch();
			$result->closeCursor();

			if ($row === false) {
				return ['running' => false];
			}

			$data = json_decode($row['data'] ?? '{}', true) ?: [];
			$tickAge = time() - (int)$row['tick'];

			return [
				'running' => $tickAge < 300,
				'action' => $row['action'] ?? '',
				'source' => $row['source'] ?? '',
				'startedAt' => (int)$row['first_tick'],
				'lastTick' => (int)$row['tick'],
				'tickAge' => $tickAge,
				'data' => $data,
			];
		} catch (\Exception $e) {
			$this->logger->debug('Could not query runner status', ['exception' => $e]);
			return ['running' => false];
		}
	}

	private function getQueueStatus(): array {
		try {
			// Total documents tracked
			$qb = $this->db->getQueryBuilder();
			$qb->select($qb->func()->count('*', 'total'))
			   ->from('fulltextsearch_indexes');
			$total = (int)$qb->executeQuery()->fetchOne();

			// Indexed OK (status = 1)
			$qb = $this->db->getQueryBuilder();
			$qb->select($qb->func()->count('*', 'cnt'))
			   ->from('fulltextsearch_indexes')
			   ->where($qb->expr()->eq('status', $qb->createNamedParameter(1, IQueryBuilder::PARAM_INT)));
			$indexed = (int)$qb->executeQuery()->fetchOne();

			// Errors
			$qb = $this->db->getQueryBuilder();
			$qb->select($qb->func()->count('*', 'cnt'))
			   ->from('fulltextsearch_indexes')
			   ->where($qb->expr()->gt('err', $qb->createNamedParameter(0, IQueryBuilder::PARAM_INT)));
			$errors = (int)$qb->executeQuery()->fetchOne();

			$pending = $total - $indexed;
			$progress = $total > 0 ? round(($indexed / $total) * 100, 1) : 0;

			return [
				'total' => $total,
				'indexed' => $indexed,
				'pending' => $pending,
				'errors' => $errors,
				'progress' => $progress,
			];
		} catch (\Exception $e) {
			$this->logger->debug('Could not query queue status', ['exception' => $e]);
			return [
				'total' => 0,
				'indexed' => 0,
				'pending' => 0,
				'errors' => 0,
				'progress' => 0,
			];
		}
	}

	private function getOpenSearchIndexStatus(): array {
		try {
			$client = $this->clientService->getClient();
			$indexName = $this->configService->getOpenSearchIndex();

			$response = $client->cat()->indices(['index' => $indexName, 'format' => 'json']);
			if (empty($response)) {
				return ['exists' => false];
			}

			$info = $response[0];
			return [
				'exists' => true,
				'name' => $indexName,
				'health' => $info['health'] ?? 'unknown',
				'status' => $info['status'] ?? 'unknown',
				'documentCount' => (int)($info['docs.count'] ?? 0),
				'deletedCount' => (int)($info['docs.deleted'] ?? 0),
				'sizeBytes' => $info['store.size'] ?? '0b',
			];
		} catch (\Exception $e) {
			return ['exists' => false, 'error' => $e->getMessage()];
		}
	}

	private function getClusterHealth(): array {
		try {
			$client = $this->clientService->getClient();
			$health = $client->cluster()->health();
			return [
				'status' => $health['status'] ?? 'unknown',
				'numberOfNodes' => (int)($health['number_of_nodes'] ?? 0),
				'activePrimaryShards' => (int)($health['active_primary_shards'] ?? 0),
				'activeShards' => (int)($health['active_shards'] ?? 0),
				'relocatingShards' => (int)($health['relocating_shards'] ?? 0),
				'unassignedShards' => (int)($health['unassigned_shards'] ?? 0),
			];
		} catch (\Exception $e) {
			return ['status' => 'unavailable', 'error' => $e->getMessage()];
		}
	}
}
