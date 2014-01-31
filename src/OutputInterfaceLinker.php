<?php
namespace Librette\Doctrine\Migrations;

use Kdyby\Events\Subscriber;
use Nette\Application;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author David Matejka
 */
class OutputInterfaceLinker implements Subscriber
{

	/** @var OutputWriter */
	protected $outputWriter;


	/**
	 * @param OutputWriter $outputWriter
	 */
	public function __construct(OutputWriter $outputWriter)
	{
		$this->outputWriter = $outputWriter;
	}


	/**
	 * Returns an array of events this subscriber wants to listen to.
	 *
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return array(
			'Nette\Application\Application::onRequest' => 'handleApplicationRequest',
		);
	}


	public function handleApplicationRequest(Application\Application $application, Application\Request $request)
	{
		if ($request->getPresenterName() === 'Kdyby:Cli') {
			$parameters = $request->getParameters();
			if (isset($parameters['output']) && ($output = $parameters['output']) instanceof OutputInterface) {
				$this->outputWriter->setOutputInterface($output);
			}
		}
	}
}