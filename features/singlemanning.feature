Feature: Single Manning

In order to calculate the daily bonus for staff
  As a shop manager
  I need to be able to know how many single manning minutes
  There were in my shop each day of this week

Rules:
  Rota should be for a full week - Monday to Sunday
  Single Manning Minutes is the amount of time in a day that a worker works alone in the shop

Background:
    Given staff are working at the "FunHouse"
    And we are looking at the current working week

Scenario: On Monday Only One Worker staffs the FunHouse
    Given "Black Widow" is working on "Monday" starting at 8 and ending at 18
    When no-one else works during the day
    Then "Black Widow" receives single manning supplement for the whole duration of their shift for "Monday", 600 minutes. 

Scenario: On Tuesday Two Workers staff the FunHouse without overlapping times
    Given "Black Widow" is working on "Tuesday" starting at 8 and ending at 12
    And "Thor" is working on "Tuesday" starting at 12 and ending at 18
    Then "Black Widow" receives single manning supplement for the whole duration of their shift for "Tuesday", 240 minutes. 
    And "Thor" receives single manning supplement for the whole duration of their shift for "Tuesday", 360 minutes. 

Scenario: On Wednesday Two Workers staff the FunHouse with overlapping times
    Given "Wolverine" is working on "Wednesday" starting at 8 and ending at 12
    And "Gamora" is working on "Wednesday" starting at 10 and ending at 18
    Then "Wolverine" receives single manning supplement for a portion of their shift for "Wednesday", 120 minutes.
    And "Gamora" receives single manning supplement for a portion of their shift for "Wednesday", 360 minutes.

Scenario: On Thursday Three Workers staff the FunHouse with overlapping times
    Given "Wolverine" is working on "Thursday" starting at 8 and ending at 12
    And "Gamora" is working on "Thursday" starting at 10 and ending at 18
    And "Black Widow" is working on "Thursday" starting at 8 and ending at 14
    Then "Wolverine" receives no single manning supplement for their shift for "Thursday"
    And "Black Widow" receives no single manning supplement for their shift for "Thursday"
    And "Gamora" receives single manning supplement for a portion of their shift for "Thursday", 240 minutes.

Scenario: On Friday and Saturday there is only one worker working on each day
    Given "Wolverine" is working on "Friday" starting at 8 and ending at 18
    And "Gamora" is working on "Saturday" starting at 8 and ending at 18
    Then "Wolverine" receives single manning supplement for the whole duration of their shift for "Friday", 600 minutes. 
    And "Gamora" receives single manning supplement for the whole duration of their shift for "Saturday", 600 minutes. 