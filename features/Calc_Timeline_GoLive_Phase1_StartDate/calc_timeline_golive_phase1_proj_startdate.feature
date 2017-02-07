Feature: Estimation

Scenario Outline: To check calculation of 'Timeline Till Go-Live(Days) Phase 1 when only 'Project start date' is default date.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I click on any link of Estimation project (Let us check this project "<number>")
Then Keep the date as default (Present date)
Then Field of Timeline Till Go-Live (days) should display zero

Then Change the date from calender (Let say "<date>" "<month>" "<year>")
Then Field of Timeline Till Go-Live (days) should again display zero

Examples: 
| url                            | username        | password | Estimates | number | date | month | year |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1   | 3      | 15   | Dec   | 2016 |
