<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCA\FullTextSearch_OpenSearch\Exceptions\QueryContentGenerationException;
use OCA\FullTextSearch_OpenSearch\Exceptions\SearchQueryGenerationException;
use OCA\FullTextSearch_OpenSearch\Model\QueryContent;
use OCP\FullTextSearch\Model\IDocumentAccess;
use OCP\FullTextSearch\Model\ISearchRequest;
use OCP\FullTextSearch\Model\ISearchRequestSimpleQuery;
use stdClass;

class SearchMappingService {
	public function __construct(
		private ConfigService $configService,
	) {
	}

	/**
	 * @throws ConfigurationException
	 * @throws SearchQueryGenerationException
	 */
	public function generateSearchQuery(
		ISearchRequest $request,
		IDocumentAccess $access,
		string $providerId,
	): array {
		return [
			'params' => $this->generateSearchQueryParams($request, $access, $providerId),
		];
	}

	/**
	 * @throws ConfigurationException
	 * @throws SearchQueryGenerationException
	 */
	public function generateSearchQueryParams(
		ISearchRequest $request,
		IDocumentAccess $access,
		string $providerId,
	): array {
		$params = [
			'index' => $this->configService->getOpenSearchIndex(),
			'size' => $request->getSize(),
			'from' => (($request->getPage() - 1) * $request->getSize()),
			'_source_excludes' => 'content',
		];

		$bool = [];
		if ($request->getSearch() !== '') {
			$bool['must']['bool'] = $this->generateSearchQueryContent($request);
		}

		$bool['filter'][]['bool']['must'] = ['term' => ['provider' => $providerId]];
		$bool['filter'][]['bool']['should'] = $this->generateSearchQueryAccess($access);
		$bool['filter'][]['bool']['should'] =
			$this->generateSearchQueryTags('metatags', $request->getMetaTags());
		$bool['filter'][]['bool']['must'] =
			$this->generateSearchQueryTags('subtags', $request->getSubTags(true));
		$bool['filter'][]['bool']['must'] =
			$this->generateSearchSimpleQuery($request->getSimpleQueries());

		$this->generateSearchSince($bool, (int)$request->getOption('since'));

		$params['body']['query']['bool'] = $bool;
		$params['body']['highlight'] = $this->generateSearchHighlighting($request);

		$this->improveSearchQuerying($request, $params['body']['query']);

		return $params;
	}

	private function improveSearchQuerying(ISearchRequest $request, array &$arr): void {
		$this->improveSearchWildcardFilters($request, $arr);
		$this->improveSearchRegexFilters($request, $arr);
	}

	private function improveSearchWildcardFilters(ISearchRequest $request, array &$arr): void {
		$filters = $request->getWildcardFilters();
		foreach ($filters as $filter) {
			$wildcards = [];
			foreach ($filter as $entry) {
				$wildcards[] = ['wildcard' => $entry];
			}
			$arr['bool']['filter'][]['bool']['should'] = $wildcards;
		}
	}

	private function improveSearchRegexFilters(ISearchRequest $request, array &$arr): void {
		$filters = $request->getRegexFilters();
		foreach ($filters as $filter) {
			$regex = [];
			foreach ($filter as $entry) {
				$regex[] = ['regexp' => $entry];
			}
			$arr['bool']['filter'][]['bool']['should'] = $regex;
		}
	}

	/**
	 * @throws SearchQueryGenerationException
	 */
	private function generateSearchQueryContent(ISearchRequest $request): array {
		$str = strtolower($request->getSearch());

		preg_match_all('/[^?]"(?:\\\\.|[^\\\\"])*"|\S+/', " $str ", $words);
		$queryContent = [];
		foreach ($words[0] as $word) {
			try {
				$queryContent[] = $this->generateQueryContent(trim($word));
			} catch (QueryContentGenerationException $e) {
				continue;
			}
		}

		if (count($queryContent) === 0) {
			throw new SearchQueryGenerationException();
		}

		return $this->generateSearchQueryFromQueryContent($request, $queryContent);
	}

	/**
	 * @throws QueryContentGenerationException
	 */
	private function generateQueryContent(string $word): QueryContent {
		$qc = new QueryContent($word);
		if (strlen($qc->getWord()) === 0) {
			throw new QueryContentGenerationException();
		}

		return $qc;
	}

	/**
	 * @param QueryContent[] $contents
	 */
	private function generateSearchQueryFromQueryContent(ISearchRequest $request, array $contents): array {
		$query = [];
		foreach ($contents as $content) {
			if (!array_key_exists($content->getShould(), $query)) {
				$query[$content->getShould()] = [];
			}

			if ($content->getShould() === 'must') {
				$query[$content->getShould()][] =
					['bool' => ['should' => $this->generateQueryContentFields($request, $content)]];
			} else {
				$query[$content->getShould()] = array_merge(
					$query[$content->getShould()],
					$this->generateQueryContentFields($request, $content)
				);
			}
		}

		return $query;
	}

	private function generateQueryContentFields(ISearchRequest $request, QueryContent $content): array {
		$queryFields = [];

		$fields = array_merge(['content', 'title'], $request->getFields());
		foreach ($fields as $field) {
			if (!$this->fieldIsOutLimit($request, $field)) {
				$queryFields[] = [$content->getMatch() => [$field => $content->getWord()]];
			}
		}

		foreach ($request->getWildcardFields() as $field) {
			if (!$this->fieldIsOutLimit($request, $field)) {
				$queryFields[] = ['wildcard' => [$field => '*' . $content->getWord() . '*']];
			}
		}

		$parts = [];
		foreach ($this->getPartsFields($request) as $field) {
			if (!$this->fieldIsOutLimit($request, $field)) {
				$parts[] = $field;
			}
		}

		if (count($parts) > 0) {
			$queryFields[] = [
				'query_string' => [
					'fields' => $parts,
					'query' => $content->getWord(),
				],
			];
		}

		return $queryFields;
	}

	private function generateSearchQueryAccess(IDocumentAccess $access): array {
		$query = [];
		$query[] = ['term' => ['owner.keyword' => $access->getViewerId()]];
		$query[] = ['term' => ['users.keyword' => $access->getViewerId()]];
		$query[] = ['term' => ['users.keyword' => '__all']];

		foreach ($access->getGroups() as $group) {
			$query[] = ['term' => ['groups.keyword' => $group]];
		}

		foreach ($access->getCircles() as $circle) {
			$query[] = ['term' => ['circles.keyword' => $circle]];
		}

		return $query;
	}

	private function fieldIsOutLimit(ISearchRequest $request, string $field): bool {
		$limit = $request->getLimitFields();
		if (count($limit) === 0) {
			return false;
		}

		return !in_array($field, $limit);
	}

	private function generateSearchQueryTags(string $k, array $tags): array {
		$query = [];
		foreach ($tags as $t) {
			$query[] = ['term' => [$k => $t]];
		}

		return $query;
	}

	private function generateSearchSince(array &$bool, int $since): void {
		if ($since === 0) {
			return;
		}

		$bool['filter'][]['bool']['must'] = [
			['range' => ['lastModified' => ['gte' => $since]]],
		];
	}

	/**
	 * @param ISearchRequestSimpleQuery[] $queries
	 */
	private function generateSearchSimpleQuery(array $queries): array {
		$simpleQuery = [];
		foreach ($queries as $query) {
			$value = $query->getValues()[0] ?? null;
			if ($value === null) {
				continue;
			}

			match ($query->getType()) {
				ISearchRequestSimpleQuery::COMPARE_TYPE_KEYWORD =>
					$simpleQuery[] = ['term' => [$query->getField() => $value]],
				ISearchRequestSimpleQuery::COMPARE_TYPE_WILDCARD =>
					$simpleQuery[] = ['wildcard' => [$query->getField() => $value]],
				ISearchRequestSimpleQuery::COMPARE_TYPE_INT_EQ =>
					$simpleQuery[] = ['term' => [$query->getField() => $value]],
				ISearchRequestSimpleQuery::COMPARE_TYPE_INT_GTE =>
					$simpleQuery[] = ['range' => [$query->getField() => ['gte' => $value]]],
				ISearchRequestSimpleQuery::COMPARE_TYPE_INT_LTE =>
					$simpleQuery[] = ['range' => [$query->getField() => ['lte' => $value]]],
				ISearchRequestSimpleQuery::COMPARE_TYPE_INT_GT =>
					$simpleQuery[] = ['range' => [$query->getField() => ['gt' => $value]]],
				ISearchRequestSimpleQuery::COMPARE_TYPE_INT_LT =>
					$simpleQuery[] = ['range' => [$query->getField() => ['lt' => $value]]],
				default => null,
			};
		}

		return $simpleQuery;
	}

	private function generateSearchHighlighting(ISearchRequest $request): array {
		$parts = $this->getPartsFields($request);
		$fields = ['content' => new stdClass()];
		foreach ($parts as $part) {
			$fields[$part] = new stdClass();
		}

		return [
			'fields' => $fields,
			'pre_tags' => [''],
			'post_tags' => [''],
			'max_analyzer_offset' => 1000000,
		];
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getDocumentQuery(string $providerId, string $documentId): array {
		return [
			'index' => $this->configService->getOpenSearchIndex(),
			'id' => $providerId . ':' . $documentId,
		];
	}

	private function getPartsFields(ISearchRequest $request): array {
		return array_map(
			fn(string $value): string => 'parts.' . $value,
			$request->getParts()
		);
	}
}
