Feature: Estimation

Scenario Outline: To check  the functinality of  calender of Project start date.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I click on any link of Estimation project (Let us check this project "<number>")
Then Click on the field of Project Start Date
Then Then select "<date>", "<month>" and "<year>"


Examples: 
| url                            | username        | password | Estimates | number | date | month | year |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | ui-id-1   | 3      | 15   | Nov   | 2016 | 
