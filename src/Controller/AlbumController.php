<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class AlbumController extends AbstractController
{

    #[Route('/albums', name: 'app_albums')]
    public function appIndex(AlbumRepository $albumRepository): Response
    {
        $albums = $albumRepository->findAll();

        return $this->render('album/album_list.html.twig', [
            'albums' => $albums,
        ]);
    }
    
    #[Route('admin/album', name: 'admin_album_index', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('admin/album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }

    #[Route('admin/new', name: 'admin_album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('admin_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'admin_album_show', methods: ['GET'])]
    public function show(Album $album): Response
    {
        return $this->render('admin/album/show.html.twig', [
            'album' => $album,
        ]);
    }

    #[Route('admin/{id}/edit', name: 'admin_album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'admin_album_delete', methods: ['POST'])]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
