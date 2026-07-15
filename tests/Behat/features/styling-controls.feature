@javascript @retry
Feature: Configure Element styling in the CMS
  As a CMS editor
  I want styling controls to be a dedicated Element action
  So that I can select supported neutral variants visually

  Background:
    Given I have a config file "styling-controls.yml"
      And I go to "/dev/build?flush=1"
      And a "page" "Styling Page" with a "Styled block" content element with "<p>Element styling browser test</p>" content
      And the "group" "EDITOR" has permissions "Access to 'Pages' section"
      And I am logged in as a member of "EDITOR" group
      And I go to "/admin/pages"
      And I left click on "Styling Page" in the tree

  Scenario: Styling is available as an Element action with every configured control
    Then I should see "Styled block"
    When I click on the ".element-editor-header__actions-toggle" element
    Then I should see "Styling"
    When I click "Styling" in the ".element-editor-header__actions-dropdown" element
    Then the "Height" styling control should offer "small,medium,large,full"
      And the "HorAlign" styling control should offer "start,center,end"
      And the "Limit" styling control should offer "three,six,twelve"
      And the "Size" styling control should offer "small,medium,large,extra-large"
      And the "Style" styling control should offer "default,light,dark"
      And the "TextAlign" styling control should offer "start,center,end"
      And the "VerAlign" styling control should offer "start,center,end"
      And the "Width" styling control should offer "quarter,half,three-quarters,full"
      And I save a CMS screenshot as "elemental-styling-controls.png"
