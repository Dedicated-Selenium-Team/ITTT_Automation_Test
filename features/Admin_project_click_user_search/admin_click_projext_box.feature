Feature: Project Tab

Scenario Outline: Verify click Projects box.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I should see hover and mouse pointer
When I click on any random Project
Then I should see the project which I have selected

Examples: 
| url                           | username        | password | 
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | 
