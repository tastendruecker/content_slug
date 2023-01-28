<?php

declare(strict_types=1);

namespace Sebkln\ContentSlug\FormEngine\FieldControl;

/*
 * This file is part of the package sebkln/content_slug
 *
 * Copyright (c) 2021 Sebastian Klein <sebastian@sebkln.de>
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

/**
 * Class GenerateFragmentFromHeaderControl
 *
 * This will render a button next to the input field,
 * which allows editors to generate a URL fragment
 * from the current header field contents.
 */
class GenerateFragmentFromHeaderControl extends AbstractNode
{
    /**
     * Handler for single nodes
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     */
    public function render(): array
    {
        $result = [
            'iconIdentifier' => 'actions-refresh',
            'title' => $GLOBALS['LANG']->sL('LLL:EXT:content_slug/Resources/Private/Language/locallang_db.xlf:tt_content.tx_content_slug_fragment.generateFromHeader'),
            'linkAttributes' => [
                'class' => 'btn-fragment ', // Button class can be selected in JavaScript.
                'data-uid' => $this->data['databaseRow']['uid'] // Fills the data-uid attribute with the uid of the current content element.
            ],
        ];

        if ((new Typo3Version())->getMajorVersion() < 12) {
            $result['requireJsModules'] = ['TYPO3/CMS/ContentSlug/FillFragment'];
        } else {
            $result['javaScriptModules'] = [
                JavaScriptModuleInstruction::forRequireJS(
                    'TYPO3/CMS/ContentSlug/FillFragment'
                ),
            ];
        }

        return $result;
    }
}
