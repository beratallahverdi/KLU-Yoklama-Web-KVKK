<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode;

require_once(APPPATH.'third_party/EndroidQrCode/Writer/WriterInterface.php');

interface WriterRegistryInterface
{
    public function addWriters(iterable $writers): void;

    public function addWriter(WriterInterface $writer): void;

    public function getWriter(string $name): WriterInterface;

    public function getDefaultWriter(): WriterInterface;

    public function getWriters(): array;
}
