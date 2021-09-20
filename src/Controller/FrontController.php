<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Project;
use App\Entity\Techno;
use App\Form\ContactType;
use App\Repository\AboutMeRepository;
use App\Repository\ProjectRepository;
use App\Repository\EducationRepository;
use App\Repository\ProfessionalExperienceRepository;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FrontController extends AbstractController
{
    private $aboutMeRepository;
    private $projectRepository;
    private $educationRepository;
    private $professionalExperienceRepository;
    private $technoRepository;
    private $serializer;

    public function __construct (
        AboutMeRepository $aboutMeRepository,
        ProjectRepository $projectRepository,
        EducationRepository $educationRepository,
        ProfessionalExperienceRepository $professionalExperienceRepository,
        TechnoRepository $technoRepository,
        SerializerInterface $serializer
     ) {
        $this->aboutMeRepository =  $aboutMeRepository;
        $this->projectRepository =  $projectRepository;
        $this->educationRepository =  $educationRepository;
        $this->professionalExperienceRepository =  $professionalExperienceRepository;
        $this->technoRepository = $technoRepository;
        $this->serialize = $serializer;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'aboutMe' => $this->aboutMeRepository->findAll()[0],
            'experiences' => $this->professionalExperienceRepository->findAll(),
            'educations' => $this->educationRepository->findAll(),
            'projects' => $this->projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/project/{slug}", name="show_project")
     */
    public function showProject(Project $project): Response
    {
        return $this->render('front/show_project.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
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
    /*

    /**
     * @Route("/search", name="search", methods={"GET"})
     * @return Response
     */

    /*

    public function search(Request $request): Response
    {
        $query = $request->query->get('q');

        if (null !== $query) {
            $project = $this->projectRepository->findByQuery($query);
        }

        return $this->render('front/show_project_search.html.twig', [
            'project' => $project ?? [],
        ]);
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     * @return Response
     */

    /*

    public function autocomplete(Request $request): Response
    {
        $query = $request->query->get('q');
        
        if (null !== $query) {
            $projects = $this->projectRepository->findByQuery($query);
        } else {
            $projects = [];
        }
        $json = $this->serializer->serialize(
            $projects,
            'json',
            ['groups' => 'technos']
        );

        return $this->json($json, 200);
         return new Response(
            json_encode($projects), 
            200
        ); 
    }*/
}
