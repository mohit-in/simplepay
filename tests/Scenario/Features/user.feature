Feature: Manage Users data
  I need to be able to retrieve, create, update, and delete User resources

  @CreateUser
  Scenario: User can Create own account in the system by personal details
    Given I do not have an entity "User" with "email=mohit@gmail.com"
    When I send a "POST" request to "/v1/user" with data
      """
      {
        "name": "mohit",
        "email": "mohit@gmail.com",
        "mobile": "9999345816",
        "password": "123456"
      }
      """
    Then the response code should "201"
    And the response has property "name" "mohit"
    And I have an entity "User" with "email=mohit@gmail.com&mobile=9999345816"

  @GetUserDetails
  Scenario: User can GET their personal data by their unique ID
    Given I have an entity "User" with "email=mohit@gmail.com"
    When I send a "GET" request to "/v1/user/1"
    Then the response code should "200"
    And the response has property "name" "mohit"

  @UpdateUserDetails
  Scenario: User can PATCH to update their personal data
    Given I have an entity "User" with "email=mohit@gmail.com"
    When I send a "PATCH" request to "/v1/user/1" with data
      """
      {
        "name": "ashish"
      }
      """
    Then the response code should "204"
    And I have an entity "User" with "id=1&email=mohit@gmail.com&name=ashish"

  @DeleteUser
  Scenario: User can DELETE their personal data
    Given I have an entity "User" with "email=mohit@gmail.com"
    When I send a "DELETE" request to "/v1/user/1"
    Then the response code should "204"
    And I do not have an entity "User" with "id=1&email=mohit@gmail.com"

