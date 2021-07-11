<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Project;
use App\Form\ContactType;
use App\Repository\AboutMeRepository;
use App\Repository\ProjectRepository;
use App\Repository\EducationRepository;
use App\Repository\ProfessionalExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    private $aboutMeRepository;
    private $projectRepository;
    private $educationRepository;
    private $professionalExperienceRepository;

    public function __construct(
        AboutMeRepository $aboutMeRepository,
        ProjectRepository $projectRepository,
        EducationRepository $educationRepository,
        ProfessionalExperienceRepository $professionalExperienceRepository,
    ) {
        $this->aboutMeRepository =  $aboutMeRepository;
        $this->projectRepository =  $projectRepository;
        $this->educationRepository =  $educationRepository;
        $this->professionalExperienceRepository =  $professionalExperienceRepository;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'aboutMe' => $this->aboutMeRepository->findAll()[0],
            'experiences' => $this->professionalExperienceRepository->findAll(),
            'educations' => $this->educationRepository->findAll(),
            'projects' => $this->projectRepository->findAll(),
        ]);
    }

    #[Route('/project/{slug}', name: 'show_project')]
    public function showProject(Project $project): Response
    {
        return $this->render('front/show_project.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('front/contact.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);
    }
}
