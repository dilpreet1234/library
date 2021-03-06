<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Step;

use PHPoole\PHPoole;

interface StepInterface
{
    /**
     * StepInterface constructor.
     *
     * @param PHPoole $phpoole
     *
     * @return void
     */
    public function __construct(PHPoole $phpoole);

    /**
     * Checks if step can be processed.
     *
     * @return void
     */
    public function init();

    /**
     * Public call to process.
     *
     * @return void
     */
    public function process();

    /**
     * Process implementation.
     *
     * @return void
     */
    public function internalProcess();
}
