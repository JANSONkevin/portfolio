<?php

namespace App\DataFixtures;

use App\Entity\AboutMe;
use App\Entity\Contributor;
use App\Entity\Education;
use App\Entity\Illustration;
use App\Entity\ProfessionalExperience;
use App\Entity\Project;
use App\Entity\Techno;
use App\Entity\User;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    private $passwordHasher;

    public function __construct(Slugify $slugify, UserPasswordHasherInterface $passwordHasher)
    {
        $this->slugger = $slugify;
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //AboutMe
        $aboutMe = new AboutMe();
        $aboutMe->setTitle('Kevin Janson')
            ->setProfession('Développeur Web')
            ->setEmail('contact@kevinjanson.com')
            ->setGithubLink('https://github.com/JANSONkevin')
            ->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat fugit corrupti ea repudiandae blanditiis pariatur. Sint nihil, reiciendis voluptatem dolor, dicta quod dolorum unde ea tempore mollitia cumque beatae? Repellendus!')
            ->setAvatar('https://i.ibb.co/0C3ySTx/Kevin-JANSON.png');

        $manager->persist($aboutMe);

        //Education
        $year = 2017;
        for ($i = 0; $i < 5; $i++) {
            $timeline = new Education();
            $timeline->setStartYear($year + $i)
                ->setEndYear($year + $i)
                ->setDescription($faker->paragraph(5))
                ->setTitle($faker->word())
                ->setName($faker->word());

            $manager->persist($timeline);
        }

        //ProfessionalExperience
        $year = 2017;
        for ($i = 0; $i < 5; $i++) {
            $timeline = new ProfessionalExperience();
            $timeline->setStartYear($year + $i)
                ->setEndYear($year + $i)
                ->setDescription($faker->paragraph(5))
                ->setTitle($faker->word())
                ->setName($faker->word());

            $manager->persist($timeline);
        }

        //Technos
        $technos = ['PHP', 'Javascript', 'Symfony', 'Bootstrap', 'WebPack Encore', 'Methode SCRUM'];
        $technosPersist = [];
        foreach ($technos as $techno) {
            $new = new Techno();
            $new->setName($techno);

            $manager->persist($new);
            $technosPersist[] = $new;
        }

        //Contributors
        $contributors = [
            [
                "name" => "hugo guillaume",
                "website" => "",
                "github" => "https://github.com/musosy",
                "linkedin" => "https://www.linkedin.com/in/hugo-guillaume-53420b129/",
            ],
            [
                "name" => "guillaume joulia",
                "website" => "",
                "github" => "https://github.com/Keisuke-Joulia",
                "linkedin" => "https://www.linkedin.com/in/guillaume-joulia/",
            ],
            [
                "name" => "mickael garatens",
                "website" => "",
                "github" => "https://github.com/micka260583",
                "linkedin" => "https://www.linkedin.com/in/mickael-garatens/",
            ],
            [
                "name" => "franck bouchet",
                "website" => "",
                "github" => "https://github.com/Franck1981-dev",
                "linkedin" => "https://www.linkedin.com/in/franck-bouchet-585652110/",
            ],
            [
                "name" => "colin mora le gac",
                "website" => "",
                "github" => "https://github.com/clnmlg",
                "linkedin" => "https://www.linkedin.com/in/colin-mora-le-gac-b0077344/",
            ],
            [
                "name" => "eddy rajaonarivelo",
                "website" => "",
                "github" => "https://github.com/eddyRAJA",
                "linkedin" => "https://www.linkedin.com/in/eddy-rajaonarivelo",
            ],
            [
                "name" => "jody gauthier",
                "website" => "",
                "github" => "https://github.com/Jody-G",
                "linkedin" => "https://www.linkedin.com/in/jody-gauthier-b7a397215/",
            ],
        ];
        foreach ($contributors as $contributor) {
            $participant = new Contributor();
            $participant->setName($contributor["name"])
                ->setGithub($contributor["github"])
                ->setLinkedin($contributor["linkedin"]);
            $manager->persist($participant);
            $contributorPersist[] = $participant;
        }

        //Projects
        for ($i = 0; $i < 5; $i++) {
            $project = new Project();
            $project->setTitle($faker->sentence())
                ->setSlug($this->slugger->generate($project->getTitle()))
                ->setPitch($faker->paragraph(1))
                ->setDescription($faker->paragraph(3))
                ->addTechno($faker->randomElement($technosPersist))
                ->addTechno($faker->randomElement($technosPersist))
                ->addTechno($faker->randomElement($technosPersist))
                ->addContributor($faker->randomElement($contributorPersist))
                ->addContributor($faker->randomElement($contributorPersist))
                ->addContributor($faker->randomElement($contributorPersist))
                ->setGithubLink($faker->url())
                ->setWebsiteLink($faker->url())
                ->setCreatedAt($faker->datetime())
                ->setIllustration("https://picsum.photos/500/300");

            for ($j = 0; $j < 5; $j++) {
                $illustration = new Illustration();
                $illustration->setImage('https://picsum.photos/500/300')
                    ->setProject($project);
                $manager->persist($illustration);

                $project->addGallery($illustration);
            }


            $manager->persist($project);
        }


        //User
        $admin = new User();
        $admin->setEmail('kevin.janson.pro@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword(
            $admin,
            'admin'
        ));

        $manager->persist($admin);

        $manager->flush();
    }
}
