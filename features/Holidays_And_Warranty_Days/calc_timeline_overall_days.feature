Feature: Estimation

Scenario Outline: To check the calculation of Timeline overall(days) when only 'Holidays' or Warranty days' are filled.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I click on any link of Estimation project (Let us check this project "<number>")
Then Enter valid data in the field of holidays or warranty (Let put the number of "<days>" and "<ID>")
Then Column of Timeline Overall (Days) should display zero

Examples: 
| url                            | username        | password | Estimates | number | days | ID                      |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1   | 3      | 3    | Warrenty-period-holiday |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1   | 3      | 3    | Warrenty-days           |

