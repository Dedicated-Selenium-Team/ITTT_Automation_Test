Feature: Estimation

Scenario Outline: To check the field of "Warranty End date" when only 'holidays is entered' is entered.

Given Open browser and Start Application"<url>"
When I enter valid entry "<username>" and "<password>"
Then User should be logged in and home page should be open again
Then User should be in project tab
Then Click on any link of Estimation project (Let us check this project "<number>")
Then Enter valid data in the field of holidays or warranty (Let put the the number of "<days>" and "<ID>")

Examples: 
<<<<<<< HEAD
| url                            | username        | password | number | days | ID                      |
=======
| url                                      | username        | password | number | days | ID                      |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | 3      | 3    | Warrenty-period-holiday |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | 3      | 3    | Warrenty-days           |
