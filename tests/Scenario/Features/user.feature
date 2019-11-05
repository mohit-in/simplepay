Feature: Manage Users data
  I need to be able to retrieve, create, update, and delete User resources

  @CreateUser
  Scenario: User can Create own account in the system by personal details
    Given I do not have an entity "User" with "email=mohit@gmail.com&mobile=99999345816"
    When I send a "POST" request to "/user" with data
      """
      {
        "uuid": "db1747e5-ffaf-11e9-a66c-28c63fd0ba7e"
        "name": "mohit",
        "email": "mohit@gmail.com",
        "mobile": "99999345816",
        "password": "123456"
      }
      """
    Then the response code should "201"
    And the response should have property "name" "mohit"
    And I have an entity "User" with "uuid=db1747e5-ffaf-11e9-a66c-28c63fd0ba7e"
    And entity "User" has property "name" value "mohit"
#    When I send a "GET" request to "/user/1"
#    Then the response code should "200"
#    And the response has property "name" "mohit"

  @GetUserDetails
  Scenario: User can GET their personal data by their unique ID
    When I send a "GET" request to "/user/1"
    Then the response code should "200"
    And the response has property "name" "mohit"

  @UpdateUserDetails
  Scenario: User can PATCH to update their personal data
    When I send a "GET" request to "/user/1"
    Then the response code should "200"
    And the response has property "name" "mohit"
    When I send a "PATCH" request to "/user/1" with data
      """
      {
        "name": "ashish"
      }
      """
    Then the response code should "204"
    When I send a "GET" request to "/user/1"
    Then the response code should "200"
    And the response has property "name" "ashish"

  @DeleteUser
  Scenario: User can DELETE their personal data
    When I send a "GET" request to "/user/1"
    Then the response code should "200"
    When I send a "DELETE" request to "/user/1"
    Then the response code should "204"
    When I send a "GET" request to "/user/1"
    Then the response code should "404"
