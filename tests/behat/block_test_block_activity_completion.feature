@block @block_test_block
Feature: Enable the test_block block in a course
  In order to view the test_block block in a course
  As a teacher
  I can add test_block block to a course and set up activity completion

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email | idnumber |
      | teacher1 | Teacher | 1 | teacher1@example.com | T1 |
      | student1 | Student | 1 | student1@example.com | S1 |
    And the following "courses" exist:
      | fullname | shortname | category | enablecompletion |
      | Course 1 | C1        | 0        | 1                |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And the following "activities" exist:
      | id | activity | course | idnumber | name           | intro                 | added      |
      | 1  | page     | C1     | page1    | Test page name | Test page description | 1640556370 |

  Scenario: Add the block to a the course
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I add the "Moodle test block" block
    And I log out
    When I log in as "student1"
    And I am on "Course 1" course homepage
    Then I should see "1 - Test page name - 27-Dec-2021" in the "Moodle test block" "block"

  Scenario: View Actvity Completion Status in the Moodle test block in a course
    Given I log in as "student1"
    And I am on "Course 1" course homepage
    And I follow "Test page name"
    And I clicked "Mark Done"
    And I am on "Course 1" course homepage
    And I should see "1 - Test page name - 27-Dec-2021 Completed" in the "Moodle test block" "block"
