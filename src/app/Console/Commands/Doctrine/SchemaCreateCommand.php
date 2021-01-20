<?php

namespace App\Console\Commands\Doctrine;

use App\SDK\Infrastructure\Providers\DoctrineServiceProvider;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class SchemaCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'doctrine:schema:create
    {--sql : Dumps the generated SQL statements to the screen (does not execute them)}
    {--em= : Create schema for a specific entity manager }';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output.';

    /**
     * Execute the console command.
     *
     * @param ManagerRegistry $registry
     */
    public function handle()
    {
        $em = $em = App::make(DoctrineServiceProvider::ENTITY_MANAGER);

        if (!$this->option('sql')) {
            $this->error('ATTENTION: This operation should not be executed in a production environment.');
        }

        $tool = new SchemaTool($em);

        $this->line('Creating database schema for entity manager...');

        if ($this->option('sql')) {
            $sql = $tool->getCreateSchemaSql($em->getMetadataFactory()->getAllMetadata());
            $this->comment('     ' . implode(';     ' . PHP_EOL, $sql));
        } else {
            $tool->createSchema($em->getMetadataFactory()->getAllMetadata());
        }

        $this->info('Database schema created successfully!');
    }
}