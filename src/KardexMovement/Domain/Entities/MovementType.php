<?php

namespace Src\KardexMovement\Domain\Entities;

enum MovementType: string
{
    case IN = 'in';
    case OUT = 'out';
}
