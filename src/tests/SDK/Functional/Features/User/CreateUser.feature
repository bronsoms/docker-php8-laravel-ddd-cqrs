Feature: Ability to create a new user
  As admin user
  I need to be able to do a request to an API endpoint to create an user

  Background:
    #Given an existing supplier admin user
    #And the Authorization System account has a valid token

  Scenario: Create a new user
    Given the request body is:
      """
        {
          "firstName": "John",
          "lastName": "Smith"
        }
      """
    When I request "/api/users/user" using HTTP POST
    Then the response code is 201
