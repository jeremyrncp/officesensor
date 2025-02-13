<?php

namespace App\Controller;

use App\Entity\Queue;
use App\Entity\User;
use App\Form\QueueType;
use App\Repository\QueueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/export')]
#[IsGranted('ROLE_USER')]
class ExportQueueController extends AbstractController
{
    #[Route('/', name: 'app_export_queue_index', methods: ['GET'])]
    public function index(QueueRepository $queueRepository, Request $request, PaginatorInterface $paginator): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user instanceof InMemoryUser) {
            $queues = $queueRepository->findBy([], ['id' => 'DESC']);
        } else {
            $queues = $queueRepository->findBy(["organization" => $user->getOrganization()], ['id' => 'DESC']);
        }

        $pagination = $paginator->paginate(
            $queues,
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('export_queue/index.html.twig', [
            'queues' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_export_queue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $this->getUser();

        $fileName = md5(time() . $user->getId());

        $queue = new Queue();

        $queueForm = $this->createForm(QueueType::class, $queue);
        $queueForm->handleRequest($request);

        if ($queueForm->isSubmitted() && $queueForm->isValid()) {
            $queue->setCreatedAt(new \DateTime())
                  ->setOrganization($user->getOrganization())
                  ->setFileName($fileName);

            $entityManager->persist($queue);
            $entityManager->flush();

            return $this->redirectToRoute('app_export_queue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('export_queue/new.html.twig', [
            'form' => $queueForm,
        ]);
    }
}
