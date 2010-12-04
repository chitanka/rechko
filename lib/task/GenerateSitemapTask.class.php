<?php

class GenerateSitemapTask extends sfBaseTask
{
	protected $urlLimit = 50000;

	protected function configure()
	{
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
			new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
			new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
			new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
			// add your own options here
		));

		$this->namespace        = 'generate';
		$this->name             = 'sitemap';
		$this->briefDescription = 'Generate sitemaps for the project';
		$this->detailedDescription = <<<EOF
The [generate:sitemap|INFO] task generates simple sitemaps for the words and the incorrect forms.
Call it with:

  [php symfony generate:sitemap|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array())
	{
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'])->getConnection();
		$context = sfContext::createInstance($this->configuration->getApplicationConfiguration($options['application'], $options['env'], false));

		$this->genSitemaps($context);
	}


	protected function genSitemaps(sfContext $context)
	{
		$files = array_merge(
			$this->genSitemapForModel('Word', 'word.%d.txt', $context),
			$this->genSitemapForModel('IncorrectForm', 'incorrect.%d.txt', $context)
		);
		$this->generateSitemapIndex($files);
	}


	protected function genSitemapForModel($model, $fileTpl = '%d.txt', sfContext $context)
	{
		$this->log(sprintf('Generating sitemap for %s...', $model));

		$sitemapDir = '/sitemaps';
		$localSitemapDir = sfConfig::get('sf_web_dir') . $sitemapDir;
		$httpSitemapDir = sfConfig::get('app_site_domain') . $sitemapDir;

		$controller = $context->getController();
		$table = Doctrine_Core::getTable($model);
		$count = $table->count();

		$files = array();
		for ($i = 0; $i < $count; $i += $this->urlLimit) {
			$items = $table->createQuery()
				->select('name')
				->offset($i)->limit($this->urlLimit)
				->groupBy('name')
				->fetchArray();

			if ( empty($items) ) {
				continue;
			}

			$map = '';
			foreach ($items as $item) {
				$url = $controller->genUrl('@word?query='.$item['name'], true);
				$domain = sfConfig::get('app_site_domain');
				$map .= strtr($url, array(
					'./symfony/symfony' => $domain,
					'./symfony' => $domain,
				)) . "\n";
			}

			$file = sprintf($fileTpl, ($i / $this->urlLimit + 1)) . '.gz';
			$this->log($file);
			$this->file_put_gz_contents($localSitemapDir .'/'. $file, $map);
			$files[] = 'http://'. $httpSitemapDir .'/'.$file;
		}

		return $files;
	}

	protected function generateSitemapIndex($files)
	{
		$sitemaps = array();
		foreach ($files as $file) {
			$sitemaps[] = sprintf('<sitemap><loc>%s</loc><lastmod>%s</lastmod></sitemap>', $file, date('c'));
		}

		$s = implode("\n", $sitemaps);
		file_put_contents(sfConfig::get('sf_web_dir').'/sitemap.xml',
<<<EOS
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
$s
</sitemapindex>
EOS
		);
	}

	protected function file_put_gz_contents($file, $contents)
	{
		$gz = gzopen($file, 'w9');
		gzwrite($gz, $contents);
		gzclose($gz);

		return $file;
	}
}
