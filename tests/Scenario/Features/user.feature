Feature: Manage Users data
  I need to be able to retrieve, create, update, and delete User resources

  @CreateUser
  Scenario: User can Create own account in the system by personal details
    Given I do not have an entity "User" with "email=mohit@gmail.com"
    When I send a "POST" request to "/user" with data
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
    When I send a "GET" request to "/user/1" with authorization token "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzMyMTUyMjMsImlkIjoxLCJleHAiOjE1NzMyMTg4MjN9.rUSYOpuGuy7ZdQRc1tfQA0RyzH9zK6MG8mDPUYkaUyLPqR4HfXAmeHY0EJmWou0KHDEwyFAdNnre1IhjEdugGi_6pgkFs74PIDAFJH4vy1cCrZ0LGRPcyCSQnF53Rkdy0GyPo2cLCWUeM_J7x6Hm4_Ayq4txQx0BUX-L0S7_ZSVWspX8_0i6wJQ_VJGXV6JAc_8p99KLMjn4GjfJ0TgETfWiAe6yKPEzXrGWK1jSmxFIYaQoI2cRcnBMLMPDR-lM3rGFy409phHmFFYVbnpedAaPqtvMqnqyGUleax1BypqBcCsFGfTo6ZVKP0uIQg6Xfp8Rh4dvjr6HcXto1QavyHQ-C6u07cAHCacq7fRQscDiWuw_RAKnRNlrkRRjJkHX2-IM_h_9KMZvS_o4kmsWsWx7cjJJ6uHlVCvhoQ81Q7t8_dgAzzX1JFbhZuR6zE6lsDeAXllowa6TyXcnL6iUDTQJUe5MSDEKweTcB1FgC8ZPaJeSRRmZ58T44ZBr3uZnipZjtFP0A2860KQ72c5HBYQrH6qy6GeobOi_eVkUY2wdaPlPCJo784dcL-pu3KeO5R1PSLZKqtSY_urv02pla0PZk2EDpZsVWxPi-NFCSWeaBtgY3XXcs1MvQ3tu-hgGNXHVytcmoZgU3QNw_vNgjSMl9sbG2M6lfkjd6Wcs8NY"
    Then the response code should "200"
    And the response has property "name" "mohit"

  @UpdateUserDetails
  Scenario: User can PATCH to update their personal data
    Given I have an entity "User" with "email=mohit@gmail.com"
    When I send a "PATCH" request to "/user/1" with authorization token "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzMyMTUyMjMsImlkIjoxLCJleHAiOjE1NzMyMTg4MjN9.rUSYOpuGuy7ZdQRc1tfQA0RyzH9zK6MG8mDPUYkaUyLPqR4HfXAmeHY0EJmWou0KHDEwyFAdNnre1IhjEdugGi_6pgkFs74PIDAFJH4vy1cCrZ0LGRPcyCSQnF53Rkdy0GyPo2cLCWUeM_J7x6Hm4_Ayq4txQx0BUX-L0S7_ZSVWspX8_0i6wJQ_VJGXV6JAc_8p99KLMjn4GjfJ0TgETfWiAe6yKPEzXrGWK1jSmxFIYaQoI2cRcnBMLMPDR-lM3rGFy409phHmFFYVbnpedAaPqtvMqnqyGUleax1BypqBcCsFGfTo6ZVKP0uIQg6Xfp8Rh4dvjr6HcXto1QavyHQ-C6u07cAHCacq7fRQscDiWuw_RAKnRNlrkRRjJkHX2-IM_h_9KMZvS_o4kmsWsWx7cjJJ6uHlVCvhoQ81Q7t8_dgAzzX1JFbhZuR6zE6lsDeAXllowa6TyXcnL6iUDTQJUe5MSDEKweTcB1FgC8ZPaJeSRRmZ58T44ZBr3uZnipZjtFP0A2860KQ72c5HBYQrH6qy6GeobOi_eVkUY2wdaPlPCJo784dcL-pu3KeO5R1PSLZKqtSY_urv02pla0PZk2EDpZsVWxPi-NFCSWeaBtgY3XXcs1MvQ3tu-hgGNXHVytcmoZgU3QNw_vNgjSMl9sbG2M6lfkjd6Wcs8NY" and data
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
    When I send a "DELETE" request to "/user/1" with authorization token "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NzMyMTUyMjMsImlkIjoxLCJleHAiOjE1NzMyMTg4MjN9.rUSYOpuGuy7ZdQRc1tfQA0RyzH9zK6MG8mDPUYkaUyLPqR4HfXAmeHY0EJmWou0KHDEwyFAdNnre1IhjEdugGi_6pgkFs74PIDAFJH4vy1cCrZ0LGRPcyCSQnF53Rkdy0GyPo2cLCWUeM_J7x6Hm4_Ayq4txQx0BUX-L0S7_ZSVWspX8_0i6wJQ_VJGXV6JAc_8p99KLMjn4GjfJ0TgETfWiAe6yKPEzXrGWK1jSmxFIYaQoI2cRcnBMLMPDR-lM3rGFy409phHmFFYVbnpedAaPqtvMqnqyGUleax1BypqBcCsFGfTo6ZVKP0uIQg6Xfp8Rh4dvjr6HcXto1QavyHQ-C6u07cAHCacq7fRQscDiWuw_RAKnRNlrkRRjJkHX2-IM_h_9KMZvS_o4kmsWsWx7cjJJ6uHlVCvhoQ81Q7t8_dgAzzX1JFbhZuR6zE6lsDeAXllowa6TyXcnL6iUDTQJUe5MSDEKweTcB1FgC8ZPaJeSRRmZ58T44ZBr3uZnipZjtFP0A2860KQ72c5HBYQrH6qy6GeobOi_eVkUY2wdaPlPCJo784dcL-pu3KeO5R1PSLZKqtSY_urv02pla0PZk2EDpZsVWxPi-NFCSWeaBtgY3XXcs1MvQ3tu-hgGNXHVytcmoZgU3QNw_vNgjSMl9sbG2M6lfkjd6Wcs8NY"
    Then the response code should "204"
    And I do not have an entity "User" with "id=1&email=mohit@gmail.com"

