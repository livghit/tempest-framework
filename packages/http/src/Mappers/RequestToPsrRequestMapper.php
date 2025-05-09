<?php

declare(strict_types=1);

namespace Tempest\Http\Mappers;

use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ServerRequestInterface as PsrRequest;
use Tempest\Http\Request;
use Tempest\Mapper\Mapper;

final readonly class RequestToPsrRequestMapper implements Mapper
{
    public function canMap(mixed $from, mixed $to): bool
    {
        return $from instanceof Request && is_a($to, PsrRequest::class, true);
    }

    public function map(mixed $from, mixed $to): PsrRequest
    {
        /** @var Request $from */
        return new ServerRequest(
            uploadedFiles: $from->files,
            uri: $from->uri,
            method: $from->method->value,
            headers: $from->headers->toArray(),
            cookieParams: $from->cookies,
            queryParams: $from->query,
            parsedBody: $from->body,
        );
    }
}
