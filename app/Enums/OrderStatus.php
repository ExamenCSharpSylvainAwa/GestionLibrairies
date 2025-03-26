<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'En attente';
    case PROCESSING = 'En préparation';
    case SHIPPED = 'Expédiée';
    case PAID = 'Payée';
    case CANCELLED = 'Annulée';
    case VALIDATED = 'validé';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::PROCESSING => 'En préparation',
            self::SHIPPED => 'Expédiée',
            self::PAID => 'Payée',
            self::CANCELLED => 'Annulée',
            self::VALIDATED => 'Validé',
            default => throw new \Exception('Statut non reconnu : ' . $this->value),
        };
    }
}