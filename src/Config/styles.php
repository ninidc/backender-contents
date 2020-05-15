<?php

return [
  'back' => [
    'sidebar' => [
      // -----------------------------------------------------------------//
      //      RIGHT COL
      // -----------------------------------------------------------------//

      [
        'type' => 'box',
        'title' => 'General Settings',
        'identifier' => 'box_2',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backPrimary',
                'name' => 'backPrimary',
                'label' => 'Primary color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSecondary',
                'name' => 'backSecondary',
                'label' => 'Secondary color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 1
    ], //end sidebar

    'body' => [
      // -----------------------------------------------------------------//
      //      LEFT COL
      // -----------------------------------------------------------------//

      [
        'type' => 'box',
        'title' => 'Header Settings',
        'identifier' => 'box_3',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'image',
                'identifier' => 'backLogo',
                'name' => 'backLogo',
                'label' => 'Logo',
                'format' => 'medium',
              ],

              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backHeaderTextColor',
                'name' => 'backHeaderTextColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backHeaderBackgroundColor',
                'name' => 'backHeaderBackgroundColor',
                'label' => 'Background color',
              ],

              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backHeaderRightPartBackgroundHoverColor',
                'name' => 'backHeaderRightPartBackgroundHoverColor',
                'label' => 'Right menu hover background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backHeaderLogoBackgroundColor',
                'name' => 'backHeaderLogoBackgroundColor',
                'label' => 'Logo background color',
              ],
            ],
          ], //end children col
        ],
      ], //end box Header

      [
        'type' => 'box',
        'title' => 'Sidebar Settings',
        'identifier' => 'box_4',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSidebarColor',
                'name' => 'backSidebarColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSidebarHoverColor',
                'name' => 'backSidebarHoverColor',
                'label' => 'Hover text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSidebarHoverIconBorderColor',
                'name' => 'backSidebarHoverIconBorderColor',
                'label' => 'Hover border and icon color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSidebarBackgroundColor',
                'name' => 'backSidebarBackgroundColor',
                'label' => 'Background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSidebarBackgroundColorHover',
                'name' => 'backSidebarBackgroundColorHover',
                'label' => 'Hover Background color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box sidebar

      [
        'type' => 'box',
        'title' => 'Primary button',
        'identifier' => 'box_5',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backPrimaryButtonBackgroundColor',
                'name' => 'backPrimaryButtonBackgroundColor',
                'label' => 'Background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backPrimaryTextColor',
                'name' => 'backPrimaryTextColor',
                'label' => 'Text color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box primary-btn

      [
        'type' => 'box',
        'title' => 'Secondary button',
        'identifier' => 'box_5',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSecondaryButtonBackgroundColor',
                'name' => 'backSecondaryButtonBackgroundColor',
                'label' => 'Background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backSecondaryTextColor',
                'name' => 'backSecondaryTextColor',
                'label' => 'Text color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box secondary-btn
    ],
  ],
  'front' => [
    'sidebar' => [
      // -----------------------------------------------------------------//
      //      RIGHT COL
      // -----------------------------------------------------------------//

      [
        'type' => 'box',
        'title' => 'General Settings',
        'identifier' => 'box_2',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'font',
                'identifier' => 'frontFont',
                'name' => 'frontFont',
                'label' => 'General Font',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontPrimary',
                'name' => 'frontPrimary',
                'label' => 'Primary color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontSecondary',
                'name' => 'frontSecondary',
                'label' => 'Secondary color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'inputColor',
                'name' => 'inputColor',
                'label' => 'Input color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'errorColor',
                'name' => 'errorColor',
                'label' => 'Error color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'frontButtonRadius',
                'name' => 'frontButtonRadius',
                'label' => 'Border radius (px)',
              ],
            ], //end children col
          ],
          //HEADER
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderTextColor',
                'name' => 'frontHeaderTextColor',
                'label' => 'Header Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderRightPartBackgroundColor',
                'name' => 'frontHeaderRightPartBackgroundColor',
                'label' => 'Header Background color',
              ],
            ], //end children col
          ],
          //SIDEBAR
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementsBackgroundColor',
                'name' => 'frontElementsBackgroundColor',
                'label' => 'Elements background color',
              ],
            ], //end children col
          ],
          //BOX SHADOW
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'boxShadowOpacity',
                'name' => 'boxShadowOpacity',
                'label' => 'Box shadow opacity 0-100',
              ],
            ], //end children col
          ],
          //BODY
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyBackgroundColor',
                'name' => 'frontBodyBackgroundColor',
                'label' => 'Main background color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 1
    ], //end sidebar

    'body' => [
      // -----------------------------------------------------------------//
      //      LEFT COL
      // -----------------------------------------------------------------//

      [
        'type' => 'box',
        'title' => 'Header Settings',
        'identifier' => 'box_3',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderTextColor',
                'name' => 'frontHeaderTextColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderRightPartTextColor',
                'name' => 'frontHeaderRightPartTextColor',
                'label' => 'Right Part text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderRightPartBackgroundColor',
                'name' => 'frontHeaderRightPartBackgroundColor',
                'label' => 'Background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderLogoBackgroundColor',
                'name' => 'frontHeaderLogoBackgroundColor',
                'label' => 'Logo background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderButtonColor',
                'name' => 'frontHeaderButtonColor',
                'label' => 'Header button color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontHeaderHoverColor',
                'name' => 'frontHeaderHoverColor',
                'label' => 'Header hover button color',
              ],
            ],
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'image',
                'identifier' => 'frontLogo',
                'name' => 'frontLogo',
                'label' => 'Logo',
                'format' => 'medium',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 3

      [
        'type' => 'box',
        'title' => 'Sidebar Settings',
        'identifier' => 'box_4',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontSidebarColor',
                'name' => 'frontSidebarColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontSidebarActiveColor',
                'name' => 'frontSidebarActiveColor',
                'label' => 'Active text color',
              ],
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontSidebarBackgroundColor',
                'name' => 'frontSidebarBackgroundColor',
                'label' => 'Background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontSidebarActiveBackgroundColor',
                'name' => 'frontSidebarActiveBackgroundColor',
                'label' => 'Active Background color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 4

      [
        'type' => 'box',
        'title' => 'Body Settings',
        'identifier' => 'box_5',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyTextColor',
                'name' => 'frontBodyTextColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyH1Color',
                'name' => 'frontBodyH1Color',
                'label' => 'H1 color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyH2Color',
                'name' => 'frontBodyH2Color',
                'label' => 'H2 color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyH3Color',
                'name' => 'frontBodyH3Color',
                'label' => 'H3 color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyH4Color',
                'name' => 'frontBodyH4Color',
                'label' => 'H4 color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyH5Color',
                'name' => 'frontBodyH5Color',
                'label' => 'H5 color',
              ],
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontBodyBackgroundColor',
                'name' => 'frontBodyBackgroundColor',
                'label' => 'Background color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'frontBodyH1FontSize',
                'name' => 'frontBodyH1FontSize',
                'label' => 'H1 font size',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'frontBodyH2FontSize',
                'name' => 'frontBodyH2FontSize',
                'label' => 'H2 font size',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'frontBodyH3FontSize',
                'name' => 'frontBodyH3FontSize',
                'label' => 'H3 font size',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'frontBodyH4FontSize',
                'name' => 'frontBodyH4FontSize',
                'label' => 'H4 font size',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'frontBodyH5FontSize',
                'name' => 'frontBodyH5FontSize',
                'label' => 'H5 font size',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 5

      [
        'type' => 'box',
        'title' => 'Footer Settings',
        'identifier' => 'box_6',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-12',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontFooterTextColor',
                'name' => 'frontFooterTextColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontFooterHoverTextColor',
                'name' => 'frontFooterHoverTextColor',
                'label' => 'Text hover color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontFooterBackgroundColor',
                'name' => 'frontFooterBackgroundColor',
                'label' => 'Background color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 6

      [
        'type' => 'box',
        'title' => 'Elements Settings',
        'identifier' => 'box_7',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'titleFontSize',
                'name' => 'titleFontSize',
                'label' => 'Title font size (px)',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementHeadColor',
                'name' => 'frontElementHeadColor',
                'label' => 'Header text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementHeadBackground',
                'name' => 'frontElementHeadBackground',
                'label' => 'Header background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementColor',
                'name' => 'frontElementColor',
                'label' => 'Body text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementBackground',
                'name' => 'frontElementBackground',
                'label' => 'Body background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementBorder',
                'name' => 'frontElementBorder',
                'label' => 'Body Separator color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'elementFileInputBorder',
                'name' => 'elementFileInputBorder',
                'label' => 'Element Row border bottom',
              ],
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'titleCollapsableFontSize',
                'name' => 'titleCollapsableFontSize',
                'label' => 'Title collapsable font size (px)',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'elementHeadCollapsableColor',
                'name' => 'elementHeadCollapsableColor',
                'label' => 'Header collapsable text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementHeadCollapsableBackground',
                'name' => 'frontElementHeadCollapsableBackground',
                'label' => 'Header collapsable background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementLinkColor',
                'name' => 'frontElementLinkColor',
                'label' => 'Link color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementLinkHoverColor',
                'name' => 'frontElementLinkHoverColor',
                'label' => 'Link hover color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementButtonColor',
                'name' => 'frontElementButtonColor',
                'label' => 'Button box color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'frontElementButtonHoverColor',
                'name' => 'frontElementButtonHoverColor',
                'label' => 'Button box hover color',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 7
      [
        'type' => 'box',
        'title' => 'Primary Button Settings',
        'identifier' => 'box_8',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryColor',
                'name' => 'buttonPrimaryColor',
                'label' => 'Label color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryHoverColor',
                'name' => 'buttonPrimaryHoverColor',
                'label' => 'Label hover color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryIconColor',
                'name' => 'buttonPrimaryIconColor',
                'label' => 'Icon color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryIconHoverColor',
                'name' => 'buttonPrimaryIconHoverColor',
                'label' => 'Icon hover color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'buttonPrimaryBorderRadius',
                'name' => 'buttonPrimaryBorderRadius',
                'label' => 'Border radius (px)',
              ],
              
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryBackgroundImageColor',
                'name' => 'buttonPrimaryBackgroundImageColor',
                'label' => 'Background (Icon/Image) color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryBackgroundBottomColor',
                'name' => 'buttonPrimaryBackgroundBottomColor',
                'label' => 'Background label color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryBackgroundIconHoverColor',
                'name' => 'buttonPrimaryBackgroundIconHoverColor',
                'label' => 'Background hover (Icon/Image) color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonPrimaryBackgroundLabelHoverColor',
                'name' => 'buttonPrimaryBackgroundLabelHoverColor',
                'label' => 'Background hover label color',
              ],
            ],
          ],
        ], //en children box
      ], //Primary Button Settings
      [
        'type' => 'box',
        'title' => 'Secondary Button Settings',
        'identifier' => 'box_8b',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryColor',
                'name' => 'buttonSecondaryColor',
                'label' => 'Label color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryHoverColor',
                'name' => 'buttonSecondaryHoverColor',
                'label' => 'Label hover color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryIconColor',
                'name' => 'buttonSecondaryIconColor',
                'label' => 'Icon color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryIconHoverColor',
                'name' => 'buttonSecondaryIconHoverColor',
                'label' => 'Icon hover color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'buttonSecondaryBorderRadius',
                'name' => 'buttonSecondaryBorderRadius',
                'label' => 'Border radius (px)',
              ],
              
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryBackgroundImageColor',
                'name' => 'buttonSecondaryBackgroundImageColor',
                'label' => 'Background (Icon/image) color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryBackgroundBottomColor',
                'name' => 'buttonSecondaryBackgroundBottomColor',
                'label' => 'Background label color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryBackgroundLabelHoverColor',
                'name' => 'buttonSecondaryBackgroundLabelHoverColor',
                'label' => 'Background hover label color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'buttonSecondaryBackgroundIconHoverColor',
                'name' => 'buttonSecondaryBackgroundIconHoverColor',
                'label' => 'Background hover (Icon/Image) color',
              ],
            
              
            ],
          ],
        ], //en children box
      ], //Secondary Button Settings

      [
        'type' => 'box',
        'title' => 'Box total Settings',
        'identifier' => 'box_9b',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'titleColor',
                'name' => 'titleColor',
                'label' => 'Label color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'iconColor',
                'name' => 'iconColor',
                'label' => 'Icon color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'backgroundColorIcon',
                'name' => 'backgroundColorIcon',
                'label' => 'Icon background color',
              ],

              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'elementNumberColor',
                'name' => 'elementNumberColor',
                'label' => 'Numbers color',
              ],


            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'fontSizeLabel',
                'name' => 'fontSizeLabel',
                'label' => 'Label font-size (px)',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'fontSizeIcon',
                'name' => 'fontSizeIcon',
                'label' => 'Icon font-size (px)',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'borderRadiusBox',
                'name' => 'borderRadiusBox',
                'label' => 'Border radius box (px)',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'fontSizeNumbers',
                'name' => 'fontSizeNumbers',
                'label' => 'Numbers font-size (px)',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //Secondary Button Settings

      [
        'type' => 'box',
        'title' => 'Static Banner Settings',
        'identifier' => 'box_9',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'image',
                'identifier' => 'bannerImage',
                'name' => 'bannerImage',
                'label' => 'Banner Image',
                'format' => 'medium',
              ],
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'richtext',
                'identifier' => 'bannerText',
                'name' => 'bannerText',
                'label' => 'Banner Text',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box 7
      [
        'type' => 'box',
        'title' => 'Login Page Settings',
        'identifier' => 'box_10',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              /*  [
                          'type' => 'field',
                          'input' => 'color',
                          'identifier' => 'loginBackgroundColor',
                          'name' => 'loginBackgroundColor',
                          'label' => 'General background color',
                      ],*/
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'loginContainerBackgroundColor',
                'name' => 'loginContainerBackgroundColor',
                'label' => 'Box background color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'loginContainerBorderRadius',
                'name' => 'loginContainerBorderRadius',
                'label' => 'Box border radius (px)',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'loginContainerTextColor',
                'name' => 'loginContainerTextColor',
                'label' => 'Text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'loginButtonBackgroundColor',
                'name' => 'loginButtonBackgroundColor',
                'label' => 'Button background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'loginButtonHoverBackgroundColor',
                'name' => 'loginButtonHoverBackgroundColor',
                'label' => 'Button hover background color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'loginButtonTextColor',
                'name' => 'loginButtonTextColor',
                'label' => ' Button text color',
              ],
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'loginButtonHoverTextColor',
                'name' => 'loginButtonHoverTextColor',
                'label' => ' Button Hover text color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'loginButtonBorderRadius',
                'name' => 'loginButtonBorderRadius',
                'label' => 'Button border radius (px)',
              ],
            ], //end children col
          ],
          [
            'type' => 'col',
            'class' => 'col-sm-12 col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'image',
                'identifier' => 'loginLogo',
                'name' => 'loginLogo',
                'label' => 'Logo',
                'format' => 'medium',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box login

      [
        'type' => 'box',
        'title' => 'Form Settings',
        'identifier' => 'box_11',
        'children' => [
          [
            'type' => 'col',
            'class' => 'col-md-6',
            'children' => [
              [
                'type' => 'field',
                'input' => 'color',
                'identifier' => 'labelColor',
                'name' => 'labelColor',
                'label' => 'Label color',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'labelFontSize',
                'name' => 'labelFontSize',
                'label' => 'Label Font Size (px)',
              ],
              [
                'type' => 'field',
                'input' => 'number',
                'identifier' => 'labelPadding',
                'name' => 'labelPadding',
                'label' => 'Label padding (px)',
              ],
            ], //end children col
          ],
        ], //en children box
      ], //end box form settings
    ],
  ],
];
