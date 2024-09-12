<?php declare(strict_types=1);

namespace App\Command;

use App\Model\Post\PostFacade;
use App\Model\TypiCode\TypiCodeApiFacade;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:posts',
    description: 'Import posts form TypiCode API.',
)]
class ImportPostsCommand extends Command
{
    public function __construct(
        private readonly PostFacade $postFacade,
        private readonly TypiCodeApiFacade $typiCodeApiFacade
    )
    {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing posts from TypiCode API');

        try {

            $dtoList = $this->typiCodeApiFacade->makePostsDtoListFromApi();
            $io->progressStart(count($dtoList));

            foreach ($dtoList as $dto) {
                $this->postFacade->createFromPostDto($dto);
                $io->progressAdvance();
            }

        } catch (\Exception $e) {
            $io->error('An error occurred while importing posts.');
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->progressFinish();
        $io->success('Posts imported successfully.');
        return Command::SUCCESS;
    }
}
