Feature: Manage Users data
  I need to be able to retrieve, create, update, and delete User resources

  @CreateUser
  Scenario: User can Create own account in the system by personal details
    Given I do not have an entity "User" with "email=mohit@gmail.com"
    When I send a "POST" request to "v1/user" with data
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
    Given I have an entity "User" with "id=1&email=mohit@gmail.com"
    When I set Authentication token in request header with user id "1"
    And I send a "GET" request to "v1/user/1"
    Then the response code should "200"
    And the response has property "name" "mohit"

  @UpdateUserDetails
  Scenario: User can PATCH to update their personal data
    When I set Authentication token in request header with user id "1"
    And  I have an entity "User" with "id=1&name=mohit&email=mohit@gmail.com"
    When I send a "PATCH" request to "v1/user/1" with data
      """
      {
        "name": "ashish"
      }
      """
    Then the response code should "204"
    And I have an entity "User" with "id=1&name=ashish&email=mohit@gmail.com"

  @DeleteUser
  Scenario: User can DELETE their personal data
    When I set Authentication token in request header with user id "1"
    And  I have an entity "User" with "id=1&name=mohit&email=mohit@gmail.com"
    When I send a "DELETE" request to "v1/user/1"
    Then the response code should "204"
    And I do not have an entity "User" with "id=1&email=mohit@gmail.com"

#  @LoginUser
#  Scenario: User can get token by their email and password
#    And  I have an entity "User" with "email=mohit@gmail.com&password=123456"
#    When I send a "POST" request to "v1/user/login" with data
#      """
#      {
#        "email": "mohit@gmail.com",
#        "password": "123456"
#      }
#      """
#    Then the response code should "201"
#    And the response has property "token" "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzM1Mzc0ODgsImlkIjo5LCJleHAiOjE1NzM1NDEwODh9.DMoPSjtHX6S9BcjSpwjARGauHSthCGl8PWHCzWVGHRl-t_IJdp8p1FZwL5R-nBOd0kN6rwWK1KkF4jQOAjxwHNMjAQ0CQCqZTD3DWljw8ziflGer8u0_Wx7tloraZV8YGKzS_BBm8Q7cJeu4AwuSaJdd3nJbd13DbLKE0zOzqVzzVt-m-Ule4rEgg-kMYFjTjkjx2niMBU-cc0KZfiLR0u1HIa5-34AIcrSm75Zm8EzfRrV3leajZRWHa0saH6jDqbhpjRfsSnaQjqlxuIx6M2ivwo2dfWoYktY2HuIGahq9VT5GOxW6Puc7Ww_aPzsrgwx4PrQKUSUtDhZDyKHtlGuO8wmkDqCef_g5wqPGS8oYoSA4Mu8PO1yBIQgLsD5lHUjXvLT0W8HUBSnCWKuWpFADJe8qGd8jAqH1c6F42eASv-PTkWNXQP-QLgjFMeMvjpn_jXNol9MZfd3RBwJqydnpj0yBuuQKPu3Anxoe3acMmml4wD_TB8h29v4NKf7Cjr_j0mpZhT-XYBDmgm2D7ee7w3frdroSu00dobiEhepoHHG9416SZv_MXF9ehltCqSQ1mbBqaouAT7nCXP70L5nCLTCObXndlp0UAOhCKezygssVoZhPkOKx376dVL_yoiPojxJzM6FaEShWEwAg2DovEKmIlHpOTswEE_WtLZQ"
#
