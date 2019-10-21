Feature: User API testing
  It is used to perform test for user related task
  Scenario: Create a user
    Given I have the payload:
    """
    {
      "name": "Mobil",
      "password" : "123",
      "email": "mohitks.in@gmail.com"
      "mobile": "9999345816"
      "status": "active"
    }
    """
    When I request "GET v1/user/"
    Then the response status code should be 201

  Scenario: Update a user
    Given I have the payload:
    """
    {
      "name": "sharma",
    }
    """
    When I request "PATCH v1/user/1"
    Then the response status code should be 204

  Scenario: Delete a user
    When I request "Delete v1/user/1"
    Then the response status code should be 204

  Scenario: Get User Details
    When I request "GET v1/user/1"
    Then the response status code should be 200