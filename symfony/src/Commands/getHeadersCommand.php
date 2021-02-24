<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class getHeadersCommand extends Command{
    protected function configure(){
        $this->setName('helloworld')
            ->setHelp('Primeiro Comando de Consola!')
            ->addArgument('username', InputArgument::REQUIRED, 'Escreve o teu nome');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $output->writeln(sprintf('Hello World! %s', $input->getArgument('username')));
    }
}