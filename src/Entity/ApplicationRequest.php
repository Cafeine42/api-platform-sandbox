<?php

namespace App\Entity;

use App\Api\Dto\Request\OutputDto;
use App\Api\Resource\Request;
use App\Api\Resource\Response;
use App\Api\Resource\Tracking;
use App\Enum\RequestStatus;
use App\Enum\ResponseStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[ORM\Entity]
#[Map(target: Request::class)]
#[Map(target: Response::class)]
#[Map(target: Tracking::class)]
#[Map(target: OutputDto::class)]
class ApplicationRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $comment = null;

    #[ORM\Column(type: 'string', enumType: RequestStatus::class)]
    public RequestStatus $status = RequestStatus::DRAFT;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $responseComment = null;

    #[ORM\Column(type: 'string', enumType: ResponseStatus::class)]
    public ResponseStatus $responseStatus = ResponseStatus::TO_PROCESS;
}
