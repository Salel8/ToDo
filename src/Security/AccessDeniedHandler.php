<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        // ...

        $content = 'Vous n\'êtes pas autorisé à accéder à cette page. Seuls les utilisateurs avec un rôle administrateur peuvent se connecter. Veuillez retourner à la page d\'accueil.';

        return new Response($content, 403);
    }
}