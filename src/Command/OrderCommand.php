<?php

namespace App\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class OrderCommand extends Command
{
    protected static $defaultName = 'app:order';
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct(null);
        $this->productRepository = $productRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a mcdonald order!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $burgerQuestion = new ChoiceQuestion('Which burger do you want?', $this->productRepository->getByCategoryName('Burgers'), 0);
        $areYouSureQuestion = new ConfirmationQuestion('Are you sure?', true, '/^y|^o/i');

        do {
            $burger = $io->askQuestion($burgerQuestion);
        } while (!$io->askQuestion($areYouSureQuestion));

        $quantityQuestion = new Question('How many?', 1);
        $quantity = $io->askQuestion($quantityQuestion);

        if ($output->isVeryVerbose()) {
            $io->comment("you chose $burger x $quantity");
        }

        $io->success('You have a new order! An email should have been sent to the customer.');

        return 0;
    }
}
