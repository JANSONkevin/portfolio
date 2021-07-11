<?php

namespace App\DataFixtures;

use App\Entity\AboutMe;
use App\Entity\Education;
use App\Entity\Illustration;
use App\Entity\ProfessionalExperience;
use App\Entity\Project;
use App\Entity\Techno;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(Slugify $slugify)
    {
        $this->slugger = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //AboutMe
        $aboutMe = new AboutMe();
        $aboutMe->setTitle('Kevin Janson')
            ->setProfession('Développeur Web')
            ->setEmail('contact@kevinjanson.com')
            ->setGithubLink('JANSONkevin')
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
                ->setGithubLink($faker->domainName())
                ->setWebsiteLink($faker->domainName())
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

        $manager->flush();
    }
}
