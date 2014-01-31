<?php
namespace Librette\Doctrine\Migrations;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author David Matejka
 */
class OutputWriter extends \Doctrine\DBAL\Migrations\OutputWriter
{

	/** @var OutputInterface */
	protected $outputInterface;


	/**
	 * @param \Symfony\Component\Console\Output\OutputInterface $outputInterface
	 */
	public function setOutputInterface(OutputInterface $outputInterface)
	{
		$this->outputInterface = $outputInterface;
	}


	/**
	 * @return \Symfony\Component\Console\Output\OutputInterface
	 */
	public function getOutputInterface()
	{
		return $this->outputInterface;
	}


	public function write($message)
	{
		if ($this->outputInterface) {
			$this->outputInterface->writeln($message);
		} else {
			parent::write($message);
		}
	}
}

 