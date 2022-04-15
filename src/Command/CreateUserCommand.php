<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = "app:create-user";
    private $managerResigstry;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct();
        $this->managerResigstry = $registry;
    }

    protected function configure()
    {
        $this->setHelp("This command allows you to create a user");
        $this->addArgument("username",InputArgument::REQUIRED,"The username of user.");
        $this->addOption('limit',null,InputOption::VALUE_REQUIRED,"How many users should be created?",1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->managerResigstry->getManager();
        for($i = 0; $i<$input->getOption("limit");$i++) {
            $user = new User();
            $user->setName($input->getArgument("username"));
            $user->setEmail("command" . uniqid() . "@email1.com");
            $user->setAddress("St. 12, Command Line, Lahore");
            $user->setPassword("Dummy");


            $entityManager->persist($user);
        }
        $entityManager->flush();
        $output->write("New user created! \n");
        return COMMAND::SUCCESS;

    }

}