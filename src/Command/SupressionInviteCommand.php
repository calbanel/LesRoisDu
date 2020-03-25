<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\DBAL\Connection;

class SupressionInviteCommand extends Command
{
    protected static $defaultName = 'invite:suppression';

    protected function configure()
    {
        $this
            ->setDescription('Suppression comptes invités.')
            ->setHelp('Cette commande permet de supprimer tous les utilisateurs invités.')
        ;
    }

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
        '================================',
        'Suppression des invités en cours',
        '================================',
         ]);

        $this->connection->query('UPDATE plateau_en_jeu SET joueur_id=NULL WHERE joueur_id IN (SELECT id FROM utilisateur WHERE est_invite=1);DELETE FROM utilisateur WHERE est_invite=1;');

        $output->writeln([
        '================================',
        'Suppression des invités terminée !',
        '================================',
         ]);


        return 0;
    }
}
