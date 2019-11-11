Feature: Manage Users data
  I need to be able to retrieve, create, update, and delete User resources

  @CreateUser
  Scenario: User can Create own account in the system by personal details
    Given I do not have an entity "User" with "email=mohit@gmail.com"
    When I send a "POST" request to "v1/user" with data
      """
      {
        "name": "mohit",
        "email": "mohit1@gmail.com",
        "mobile": "9999345816",
        "password": "123456"
      }
      """
    Then the response code should "201"
    And the response has property "name" "mohit"