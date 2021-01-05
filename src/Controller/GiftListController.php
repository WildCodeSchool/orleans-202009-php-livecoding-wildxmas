<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Entity\GiftList;
use App\Entity\User;
use App\Form\GiftListType;
use App\Repository\GiftListRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gift/list")
 * @IsGranted("ROLE_USER")
 */
class GiftListController extends AbstractController
{
    /**
     * @Route("/", name="gift_list_index", methods={"GET"})
     */
    public function index(GiftListRepository $giftListRepository): Response
    {
        return $this->render('gift_list/index.html.twig', [
            'gift_lists' => $giftListRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/add-list/{id}", name="gift_add_list", methods={"POST"})
     */
    public function addToList(
        Gift $gift,
        GiftListRepository $giftListRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $currentYear = (int)(new DateTime())->format('Y');
        $currentList = $giftListRepository->findOneBy(['year' => $currentYear, 'user' => $this->getUser()]);
        if ($currentList === null) {
            $currentList = new GiftList();
            /** @var User $user */
            $user = $this->getUser();
            $currentList->setUser($user)->setYear($currentYear);
            $entityManager->persist($currentList);
        }
        if ($currentList->getGifts()->contains($gift)) {
            $this->addFlash('danger', 'Already in this list');
        } else {
            $currentList->addGift($gift);
            $this->addFlash('success', 'Gift added to the list');
        }

        $entityManager->flush();

        return $this->redirectToRoute('gift_index');
    }

    /**
     * @Route("/remove-list/{giftList}/{gift}", name="gift_remove_list", methods={"POST"})
     */
    public function removeList(GiftList $giftList, Gift $gift, EntityManagerInterface $entityManager): Response
    {
        $giftList->removeGift($gift);
        $entityManager->flush();
        $this->addFlash('success', 'Gift removed from list');

        return $this->redirectToRoute('gift_list_show', ['id' => $giftList->getId()]);
    }

    /**
     * @Route("/new", name="gift_list_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $giftList = new GiftList();
        /** @var User $user */
        $user = $this->getUser();
        $giftList->setUser($user);
        $form = $this->createForm(GiftListType::class, $giftList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($giftList);
            $entityManager->flush();

            return $this->redirectToRoute('gift_list_index');
        }

        return $this->render('gift_list/new.html.twig', [
            'gift_list' => $giftList,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gift_list_show", methods={"GET"})
     */
    public function show(GiftList $giftList): Response
    {
        return $this->render('gift_list/show.html.twig', [
            'gift_list' => $giftList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gift_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GiftList $giftList): Response
    {
        $form = $this->createForm(GiftListType::class, $giftList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gift_list_index');
        }

        return $this->render('gift_list/edit.html.twig', [
            'gift_list' => $giftList,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gift_list_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GiftList $giftList): Response
    {
        if ($this->isCsrfTokenValid('delete' . $giftList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($giftList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gift_list_index');
    }
}
