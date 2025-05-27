<?php

namespace App\Controller;
use App\Entity\Artiste;
use App\Entity\Release;
use App\Entity\Track;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'app_favoris')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        // On récupère toutes les entités
        $artists = $entityManager->getRepository(Artiste::class)->findAll();
        $albums = $entityManager->getRepository(Release::class)->findAll();
        $tracks = $entityManager->getRepository(Track::class)->findAll();

        // On filtre côté PHP pour ne garder que les favoris
        $favoriteArtists = array_filter($artists, fn($artist) => $artist->isFavorite());
        $favoriteAlbums = array_filter($albums, fn($album) => $album->isFavorite());
        $favoriteTracks = array_filter($tracks, fn($track) => $track->isFavorite());

        return $this->render('favoris/favoris.html.twig', [
            'favorite_artists' => $favoriteArtists,
            'favorite_albums' => $favoriteAlbums,
            'favorite_tracks' => $favoriteTracks,
        ]);

    
    }

    #[Route('/{id}/toggle-favorite', name: 'app_track_toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(Track $track, EntityManagerInterface $entityManager): JsonResponse
    {
    $track->setFavorite(!$track->isFavorite());
    $entityManager->flush();

    return new JsonResponse([
        'success' => true,
        'favorite' => $track->isFavorite(),
    ]);
}
    
}