<?php declare(strict_types=1);

namespace App\Command;

use App\Model\TypiCode\TypiCodeApiFacade;
use App\Model\User\UserFacade;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:users',
    description: 'Import users form TypiCode API.',
)]
class ImportUsersCommand extends Command
{
    public function __construct(
        private readonly UserFacade $userFacade,
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
        $io->title('Importing users from TypiCode API');

        try {

            $dtoList = $this->typiCodeApiFacade->makeUsersDtoListFromApi();
            $io->progressStart(count($dtoList));

            foreach ($dtoList as $dto) {
                $this->userFacade->createFromUserDto($dto);
                $io->progressAdvance();
            }

        } catch (\Exception $e) {
            $io->error('An error occurred while importing users.');
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->progressFinish();
        $io->success('Users imported successfully.');
        return Command::SUCCESS;
    }
}
