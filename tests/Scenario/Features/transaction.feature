Feature: Manage Wallet Refill, Money Transfer, Transaction Details and Transaction Listing API
  I need to be able to wallet refill, money transfer, transaction details and transaction listing
  @WalletRefill @GetUserDetails
  Scenario: User can refill the own wallet
    Given I do not have an entity "Transaction" with "senderId=1&receiverId=null&amount=100"
    And I have an entity "User" with "id=1&email=mohit@gmail.com&balance=0"
    When I set Authentication token in request header with user id "1"
    And I send a "POST" request to "v1/wallet-refill/1" with data
      """
      {
        "amount": "100"
      }
      """
    Then the response code should "204"
    And I have an entity "Transaction" with "senderId=1&receiverId=null&amount=100"

  @MoneyTransfer
  Scenario: User can transfer money from their amount to other user wallet by using email
    Given I do not have an entity "Transaction" with "senderId=1&receiverId=2&amount=100"
    And I have an entity "User" with "id=1&email=mohit@gmail.com&balance=1000"
    And I have an entity "User" with "id=2&email=ashish@gmail.com"
    When I set Authentication token in request header with user id "1"
    And I send a "POST" request to "v1/transfer-money/1" with data
      """
      {
        "receiverId": 2,
        "amount": "100"
      }
      """
    Then the response code should "204"
    And I have an entity "Transaction" with "senderId=1&receiverId=2&amount=100"

  @GetTransactionListing
  Scenario: User can get their transaction listing
    Given I have an entity "User" with "id=1&email=mohit@gmail.com"
    And  I have an entity "Transaction" with "id=1&senderId=1&receiverId=2&amount=200"
    When I set Authentication token in request header with user id "1"
    And I send a "GET" request to "v1/transaction/list?senderId=1"
    Then the response code should "200"
    And the response has property "senderId" "1"
    And the response has property "amount" "100"
    And the response has property "receiverId" "2"

  @GetTransactionDetails
  Scenario: User can get their transaction details
    Given I have an entity "User" with "id=1&email=mohit@gmail.com"
    And I have an entity "User" with "id=2&email=ashish@gmail.com"
    And  I have an entity "Transaction" with "id=1&senderId=1&receiverId=2&amount=100"
    When I set Authentication token in request header with user id "1"
    And I send a "GET" request to "v1/transaction/1"
    Then the response code should "200"
    And the response has property "senderId" "1"
    And the response has property "amount" "100"