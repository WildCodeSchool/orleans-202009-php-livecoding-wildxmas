<?php

namespace App\Command;

use App\Services\GiftListMailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WildxmasListCommand extends Command
{
    protected static $defaultName = 'wildxmas:list';

    private GiftListMailer $giftListMailer;

    public function __construct( GiftListMailer $giftListMailer)
    {
        $this->giftListMailer = $giftListMailer;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->setDescription('Send mail with list')
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputOutput = new SymfonyStyle($input, $output);

        $this->giftListMailer->sendAll();
        $inputOutput->success('List sent');

        return Command::SUCCESS;
    }
}
