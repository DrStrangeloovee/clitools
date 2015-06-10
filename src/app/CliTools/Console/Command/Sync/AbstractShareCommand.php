<?php

namespace CliTools\Console\Command\Sync;

/*
 * CliTools Command
 * Copyright (C) 2015 Markus Blaschke <markus@familie-blaschke.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use CliTools\Console\Shell\CommandBuilder\CommandBuilderInterface;

abstract class AbstractShareCommand extends \CliTools\Console\Command\Sync\AbstractCommand {

    const PATH_DUMP   = '/dump/';
    const PATH_DATA   = '/data/';

    /**
     * Configure command
     */
    protected function configure() {
        parent::configure();

        $this->confArea = 'share';
    }

    /**
     * Validate configuration
     *
     * @return boolean
     */
    protected function validateConfiguration() {
        $ret = parent::validateConfiguration();

        // Rsync required for share
        $ret = $ret && $this->validateConfigurationRsync();

        return $ret;
    }

    /**
     * Create rsync command for share sync
     *
     * @param string  $source            Rsync Source
     * @param string  $target            Rsync target
     * @param boolean $useExcludeInclude Use file/exclude lists
     *
     * @return CommandBuilderInterface
     */
    protected function createShareRsyncCommand($source, $target, $useExcludeInclude = false) {
        // File list
        $filelist = null;
        if ($useExcludeInclude && $this->config->exists('rsync.directory')) {
            $filelist = $this->config->get('rsync.directory');
        }

        // Exclude list
        $exclude  = null;
        if ($useExcludeInclude && $this->config->exists('rsync.exclude')) {
            $exclude = $this->config->get('rsync.exclude');
        }

        return $this->createRsyncCommand($source, $target, $filelist, $exclude);
    }

}
