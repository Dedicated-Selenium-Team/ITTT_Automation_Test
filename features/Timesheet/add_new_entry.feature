Feature: Total hours

Scenario Outline: Verify click on NewEntry, check popup display, check empty field validation and click save button.

Given Open browser and Start Application (New)"<url>"

When I enter the valid "<user>" and "<pass>"
Then User should be logged in and home-page should be open
When I click on New Entry button
Then New Entry popup should be display
When I Click on save button without value
Then SHould be get error message
Then If I not fill the "<project>", "<designation>", "<task>" and "<hours>"
Then I click on save button
Then New entry "<project>" and "<designation>" should be entered

Examples: 
<<<<<<< HEAD
| url                            | user            | pass     | project      | designation | task        | hours |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ITTT         | PM          | conectivity | 5     |  
=======
| url                                      | user            | pass     | project               | designation     | task        | hours |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | TESTZ                 | Tester          | conectivity | 5     |  
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
