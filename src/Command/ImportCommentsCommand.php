<?php declare(strict_types=1);

namespace App\Command;

use App\Model\Comment\CommentFacade;
use App\Model\TypiCode\TypiCodeApiFacade;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:comments',
    description: 'Import comments form TypiCode API.',
)]
class ImportCommentsCommand extends Command
{
    public function __construct(
        private readonly CommentFacade $commentFacade,
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
        $io->title('Importing comments from TypiCode API');

        try {

            $dtoList = $this->typiCodeApiFacade->makeCommentsDtoListFromApi();
            $io->progressStart(count($dtoList));

            foreach ($dtoList as $dto) {
                $this->commentFacade->createFromCommentDto($dto);
                $io->progressAdvance();
            }

        } catch (\Exception $e) {
            $io->error('An error occurred while importing comments.');
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->progressFinish();
        $io->success('Comments imported successfully.');
        return Command::SUCCESS;
    }
}
