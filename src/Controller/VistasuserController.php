<?php

namespace App\Controller;

use App\Entity\Tarea;
use App\Entity\Tipo;
use App\Form\TareaForm;
use App\Repository\TareaRepository;
use App\Repository\TipoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;

final class VistasuserController extends AbstractController
{
 #[Route('/vistasuser', name: 'app_vistasuser')]
public function index(
    TareaRepository $tareaRepository,
    TipoRepository $tipoRepository
): Response {
    $user = $this->getUser();

    if ($user) {
        // Usuario logueado
        $tareas = $this->isGranted('ROLE_SUPER_ADMIN')
            ? $tareaRepository->findAll()
            : $user->getTareas();
    } else {
        // Usuario no logueado: mostrar tareas vacías o un mensaje (acá vacío)
        $tareas = [];
    }

    return $this->render('vistasuser/index.html.twig', [
        'tareas' => $tareas,
        'tipos' => $tipoRepository->findAll(),
    ]);
}






    // FILTRADO POR ESTADO (si decidís usarlo en el futuro)
    #[Route('/tareas/estado/{estado}', name: 'app_vistasuser_estado')]
    public function filtrarPorEstado(string $estado, TareaRepository $repo, TipoRepository $tipoRepo, Request $request): Response
    {
        $estadoBool = $estado === 'completada';
        $tareas = $repo->findBy(['estado' => $estadoBool]);

        if ($request->isXmlHttpRequest()) {
            return $this->render('vistasuser/_tareas_grid.html.twig', [
                'tareas' => $tareas,
            ]);
        }

        return $this->render('vistasuser/index.html.twig', [
            'tareas' => $tareas,
            'tipos' => $tipoRepo->findAll(),
        ]);
    }

    // FILTRADO POR TIPO (opcional si hacés todo con JS)
    #[Route('/tareas/tipo/{id}', name: 'app_vistasuser_tipo')]
    public function filtrarPorTipo(
        Tipo $tipo,
        TareaRepository $repo,
        TipoRepository $tipoRepo,
        Request $request
    ): Response {
        $tareas = $repo->findBy(['tipo' => $tipo]);

        if ($request->isXmlHttpRequest()) {
            return $this->render('vistasuser/_tareas_grid.html.twig', [
                'tareas' => $tareas,
            ]);
        }

        return $this->render('vistasuser/index.html.twig', [
            'tareas' => $tareas,
            'tipos' => $tipoRepo->findAll(),
        ]);
    }

    // CREAR TAREA POR MODAL
    #[Route('/tarea/modal/new', name: 'app_tarea_modal_form', methods: ['GET', 'POST'])]
    public function nuevaTareaDesdeModal(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        /** @var \App\Entity\Admin|null $admin */
        $admin = $security->getUser();

        if (!$admin) {
            if ($request->isXmlHttpRequest()) {
                return $this->json(['success' => false, 'message' => 'Debes iniciar sesión.'], 401);
            }

            return $this->redirectToRoute('app_login');
        }

        $tarea = new Tarea();
        $tarea->addUser($admin);

        $form = $this->createForm(TareaForm::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tarea);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'message' => 'Tarea creada correctamente',
                    'tareaId' => $tarea->getId(),
                ]);
            }

            return $this->redirectToRoute('app_vistasuser');
        }

        return $this->render('inicio/new_tarea_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
