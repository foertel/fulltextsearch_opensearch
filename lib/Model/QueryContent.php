<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Model;

use JsonSerializable;

class QueryContent implements JsonSerializable {
	public const OPTION_MUST = 1;
	public const OPTION_MUST_NOT = 2;

	private string $word;
	private string $should;
	private string $match;
	private int $option = 0;

	private array $options = [
		'+' => [self::OPTION_MUST, 'must', 'match_phrase_prefix'],
		'-' => [self::OPTION_MUST_NOT, 'must_not', 'match_phrase_prefix'],
	];

	public function __construct(string $word) {
		$this->word = $word;
		$this->init();
	}

	private function init(): void {
		$this->should = 'should';
		$this->match = 'match_phrase_prefix';

		$firstChar = substr($this->word, 0, 1);

		if (array_key_exists($firstChar, $this->options)) {
			$this->option = $this->options[$firstChar][0];
			$this->should = $this->options[$firstChar][1];
			$this->match = $this->options[$firstChar][2];
			$this->word = substr($this->word, 1);
		}

		if (str_starts_with($this->word, '"')) {
			$this->match = 'match';
			if (str_contains($this->word, ' ')) {
				$this->match = 'match_phrase_prefix';
			}
		}

		$this->word = str_replace('"', '', $this->word);
	}

	public function getWord(): string {
		return $this->word;
	}

	public function setWord(string $word): self {
		$this->word = $word;
		return $this;
	}

	public function getShould(): string {
		return $this->should;
	}

	public function setShould(string $should): self {
		$this->should = $should;
		return $this;
	}

	public function getMatch(): string {
		return $this->match;
	}

	public function setMatch(string $match): self {
		$this->match = $match;
		return $this;
	}

	public function getOption(): int {
		return $this->option;
	}

	public function setOption(int $option): self {
		$this->option = $option;
		return $this;
	}

	public function jsonSerialize(): array {
		return [
			'word' => $this->word,
			'should' => $this->should,
			'match' => $this->match,
			'option' => $this->option,
		];
	}
}
