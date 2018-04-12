<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

namespace Module\Vote\Installer\Action;

use Pi;
use Pi\Application\Installer\Action\Update as BasicUpdate;
use Pi\Application\Installer\SqlSchema;
use Zend\EventManager\Event;

class Update extends BasicUpdate
{
    /**
     * {@inheritDoc}
     */
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('update.pre', [$this, 'updateSchema']);
        parent::attachDefaultListeners();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function updateSchema(Event $e)
    {
        $moduleVersion = $e->getParam('version');

        // Set item model
        $pointModel   = Pi::model('point', $this->module);
        $pointTable   = $pointModel->getTable();
        $pointAdapter = $pointModel->getAdapter();

        if (version_compare($moduleVersion, '1.3.0', '<')) {
            $sql
                = <<<'EOD'
CREATE TABLE `{score}` (
  `id`     INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`  VARCHAR(255)        NOT NULL DEFAULT '',
  `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `module` VARCHAR(64)         NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `module` (`module`),
  KEY `status_module` (`status`, `module`)
);

INSERT INTO `{score}` (`id`, `title`, `status`, `module`) VALUES ('1', 'Default', '1', '');
EOD;

            SqlSchema::setType($this->module);
            $sqlHandler = new SqlSchema;

            try {
                $sqlHandler->queryContent($sql);
            } catch (\Exception $exception) {
                $this->setResult('db', [
                    'status'  => false,
                    'message' => 'SQL schema query for package_period table failed: '
                        . $exception->getMessage(),
                ]);

                return false;
            }

            // Alter table field `position`
            $sql = sprintf("ALTER TABLE %s ADD `score` INT(10) UNSIGNED NOT NULL DEFAULT '1', ADD INDEX (`score`)", $pointTable);
            try {
                $pointAdapter->query($sql, 'execute');
            } catch (\Exception $exception) {
                $this->setResult('db', [
                    'status'  => false,
                    'message' => 'Table alter query failed: '
                        . $exception->getMessage(),
                ]);
                return false;
            }

        }
        return true;
    }
}