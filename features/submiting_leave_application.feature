Feature: Submiting leave application
  In order to take a leave
  As a Worker
  I need to be able to submit leave application

  Scenario: Submitting leave application
    Given there is a worker with id "some_id" and 26 available leave days
    When I submit leave application from "2016-01-01" to "2016-01-10"
    Then I should have submited application
