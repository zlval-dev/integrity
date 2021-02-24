<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Url;
use App\Entity\UrlHasHeaders;

class GetHeadersCommand extends Command{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

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
            // Adicionar url e datetime a tabela url da base de dados
            $em = $this->container->get('doctrine')->getManager();
            $db_url = new Url();
            $db_url->setUrl($url);
            $db_url->setDate(new \DateTime());
            $em->persist($db_url);
            $em->flush();
            $url_id = $db_url->getId(); // Obter o id do tuplo inserido
            // Mostrar todos os headers
            foreach ($response->getHeaders() as $name => $values) {
                // Imprime os Headers
                $output->writeln('<comment>' . $name . ':</comment> ' . implode(', ', $values));
                // Adiciona os Headers a tabela url_has_headers da base de dados
                $em = $this->container->get('doctrine')->getManager();
                $db_url_has_header = new UrlHasHeaders();
                $db_url_has_header->setUrlId($url_id);
                $db_url_has_header->setHeader($name);
                $db_url_has_header->setValue(implode(', ', $values));
                $em->persist($db_url_has_header);
                $em->flush();
            }                        
        }catch(\Exception $e){
            // Apresentar erro ao utilizador
            $output->writeln('<error>Erro obter os Headers HTTP do URL, verifique se introduziu um URL válido e existente!</error>');
        }
        return 0;
    }
}