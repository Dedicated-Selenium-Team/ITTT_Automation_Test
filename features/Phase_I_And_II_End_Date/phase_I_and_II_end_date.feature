Feature: Estimation

Scenario Outline: To check  the functinality of  calender of Phase 1 or Phase II End Date.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I click on any link of Estimation project (Let us check this project "<number>")
Then Click on the field of Phase I or Phase II End Date (Let us put "<Phase ID>")
Then Then select "<date>", "<month>" and "<year>"
Then The same selected month, year and date should reflect in the Phase I End Date and Phase II End Date field in the format of  mm/dd/yyyy


Examples: 
| url                            | username        | password | Estimates | number | date | month | year | Phase ID          |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1   | 5      | 29   | Dec   | 2016 | phase-I-end-date  |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1   | 5      | 29   | Dec   | 2016 | phase-II-end-date |
