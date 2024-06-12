<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

// Déclare une classe TrustHosts qui hérite des fonctionnalités de Middleware
class TrustHosts extends Middleware
{
    /**
     * Obtenir les modèles d'hôtes (domaines) qui doivent être de confiance.
     *
     * @return array<int, string|null> Un tableau de motifs d'hôtes de confiance
     */
    public function hosts(): array
    {
        // Retourne un tableau contenant tous les sous-domaines de l'URL de l'application
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
