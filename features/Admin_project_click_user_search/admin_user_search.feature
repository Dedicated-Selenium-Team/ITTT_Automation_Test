Feature: Admin edit Pop up

Scenario Outline: Verify click On Edit Button and update Entry and close the popup 

Given Open browser Start Application "<url>"
When I enter valid Admin "<username>" and "<password>"
Then User should be logged in and home page should open
Then I click on mouse hamberger
Then I click User in list
When I enter some invalid "<invalid_data>"
Then I should not see the result
When I enter some valid "<valid_data>"
Then I should see the result on top

Examples: 
| url                           | username        | password | invalid_data | valid_data | 
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | kjjjljd | Pravin |
