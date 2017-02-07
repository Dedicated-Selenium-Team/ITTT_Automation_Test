Feature: Estimation

Scenario Outline: To check the field of "Warranty End date" when 'project start date', 'Phase 1 End Date', 'Phase 2 End Date' are entered same.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I click on any link of Estimation project (Let us check this project "<number>")
Then Place mouse on warranty End date field
Then Cursor should change to disable symbol
Then Field of Warranty end date should display the dd/mm/yyyy
Then Select date from project start date from calender (Let say "<date>" "<month>" "<year>")
Then Set the same date for Phase I End Date from calender (Let say "<date>" "<month>" "<year>")
Then Set the same date for Phase II End Date from calender (Let say "<date>" "<month>" "<year>")
Then Warranty end daye should be same as the date set in all the filed

Examples: 
<<<<<<< HEAD
| url                            | username        | password | Estimates | number | date | month | year |
=======
| url                                      | username        | password | Estimates | number | date | month | year |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1   | 5      | 29   | Dec   | 2016 |
