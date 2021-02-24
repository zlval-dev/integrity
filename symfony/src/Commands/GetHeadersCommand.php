<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class GetHeadersCommand extends Command{
    protected function configure(){
        $this->setName('getheaders')
            ->setDescription('Recebe um URL e retorna os Headers HTTP do URL final')
            ->addArgument('url', InputArgument::REQUIRED, 'Insere um link');
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        try{
            $client = new Client();
            $response = $client->request('GET', $input->getArgument('url'), [
                // Obter o url final
                'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$url) {
                    $url = $stats->getEffectiveUri();
                }
            ]);
            // Mostrar todos os headers
            foreach ($response->getHeaders() as $name => $values) {
                $output->writeln('<comment>' . $name . ':</comment> ' . implode(', ', $values));
            }                        
        }catch(\Exception $e){
            // Apresentar erro ao utilizador
            $output->writeln('<error>Erro obter os Headers HTTP do URL, verifique se introduziu um URL válido e existente!</error>');
        }
        return 0;
    }
}