Feature: Estimation 

Scenario Outline: Verify the functionality of Holiday

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open

When I click on mouse hamberger
Then I see project option and click on project 
Then I should on estimation page

When I click on project start date option
Then I should see same date highlited in calender

When I click on phase one end date
Then I should see same phase one date highlited in calender

When I click on phase two end date
Then I should see same phase two date highlited in calender

When I Enter valid day "<day>" in Warranty Days field
Then Day will be entered when day is numaric value
Then Day Will not entered if day is not numaric "<not_numeric>" value

When I Enter valid day "<day>" in holiday field
Then Day will be entered when day is between I to XV numaric value
Then Day Will not entered if day is greater then XV "<wrong_day>"

Examples: 
| url                                      | username        | password | day | wrong_day | not_numeric |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | 12  | 17        |  abs |
