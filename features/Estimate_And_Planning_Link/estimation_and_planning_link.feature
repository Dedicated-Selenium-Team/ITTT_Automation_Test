Feature: Project Tab

Scenario Outline: Verify click functionality for the Estimation and Planning Projects Links.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I should see the mouse pointer changes to the hand pointer (Let us check this project "<number>" and "<Tab>")
And color of "<Links>" changes to red (Let us check this project "<number>" and "<Tab>")
And color of link changes to red and tool tip appears on hovering on Estimation and Planning "<Links>" link (Let us check this project "<number>" and "<Tab>")
Then I click on any link of Estimation and Planning "<Links>" project (Let us check this project "<number>" and "<Tab>")

Examples: 
| url                            | username        | password | number | Tab    | Links         |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | 5      | tabs-1 | estimate-span |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | 5      | tabs-1 | planning-span |
