<?php

namespace Bithost\Pdfviewhelpers\ViewHelpers;

/* * *
 *
 * This file is part of the "PDF ViewHelpers" Extension for TYPO3 CMS.
 *
 *  (c) 2016 Markus Mächler <markus.maechler@bithost.ch>, Bithost GmbH
 *           Esteban Marin <esteban.marin@bithost.ch>, Bithost GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * * */

use Bithost\Pdfviewhelpers\Exception\Exception;
use Bithost\Pdfviewhelpers\Model\BasePDF;

/**
 * HeaderViewHelper
 *
 * @author Markus Mächler <markus.maechler@bithost.ch>, Esteban Marin <esteban.marin@bithost.ch>
 */
class HeaderViewHelper extends AbstractPDFViewHelper
{
    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('posY', 'integer', '', false, $this->settings['header']['posY']);
        $this->registerArgument('scope', 'string', '', false, null);
    }

    /**
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        if ($this->arguments['scope'] === null) {
            $this->arguments['scope'] = $this->viewHelperVariableContainer->get('DocumentViewHelper', 'defaultHeaderFooterScope');
        }
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function render()
    {
        $pdf = $this->getPDF();
        $arguments = $this->arguments;
        $renderChildrenClosure = $this->buildRenderChildrenClosure();
        $headerClosure = function () use ($pdf, $arguments, $renderChildrenClosure) {
            if ($arguments['posY']) {
                $pdf->SetY($arguments['posY']);
            }

            $renderChildrenClosure();
        };

        $pdf->setHeaderClosure($headerClosure, $arguments['scope']);
    }
}
